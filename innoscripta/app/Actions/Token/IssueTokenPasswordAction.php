<?php
namespace App\Actions\Token;

use App\Entities\BadLoginEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Managers\BadLoginManager;
use App\Models\UserIdentifierModel;
use DeviceDetector\DeviceDetector;
use Illuminate\Http\Request;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use App\Actions\Token\GetTokenInfoAction;

/**
 * Class IssueTokenPasswordAction
 * @package Azki\Systems\User\Authentication\Action
 */
class IssueTokenPasswordAction
{

    /**
     * @var AuthorizationServer
     */
    private AuthorizationServer $authorizationServer;

    /**
     * @var HttpFoundationFactory
     */
    private HttpFoundationFactory $httpFoundationFactory;

    /**
     * @var BadLoginManager
     */
    private BadLoginManager $badLoginManager;

    /**
     * @var DeviceDetector
     */
    private DeviceDetector $deviceDetector;

    private GetTokenInfoAction $getTokenInfoAction;


    /**
     * ActionIssueTokenByPassword constructor.
     * @param AuthorizationServer $authorizationServer
     * @param HttpFoundationFactory $httpFoundationFactory
     * @param BadLoginManager $badLoginManager
     * @param DeviceDetector $deviceDetector
     */
    public function __construct(
        AuthorizationServer $authorizationServer,
        HttpFoundationFactory $httpFoundationFactory,
        BadLoginManager $badLoginManager,
        DeviceDetector $deviceDetector,
        GetTokenInfoAction $getTokenInfoAction
    ) {
        $this->authorizationServer = $authorizationServer;
        $this->httpFoundationFactory = $httpFoundationFactory;
        $this->badLoginManager = $badLoginManager;
        $this->deviceDetector = $deviceDetector;
        $this->getTokenInfoAction = $getTokenInfoAction;
    }

    /**
     * @param Request $request
     * @return array
     * @throws InvalidUserCredentialsException
     */
    public function __invoke(Request $request): array
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $psrRequest = $psrHttpFactory->createRequest($request);

        try{
            $psrResponse = $this->authorizationServer->respondToAccessTokenRequest($psrRequest, new Response());
            $response = $this->httpFoundationFactory->createResponse($psrResponse);

            $responseContent = $response->getContent();
            $responseData = json_decode($responseContent, true); // Convert JSON string to an array
            $tokenInfo = $this->getTokenInfoAction->__invoke($responseData['access_token']);
            if ($tokenInfo) {
                $responseData = array_merge($responseData, $tokenInfo->toArray());
            }

            return $responseData;

        }
        catch (InvalidUserCredentialsException | OAuthServerException $e) {

            /** @var UserIdentifierModel $userIdentifier */
            $userIdentifier = UserIdentifierModel::query()
                ->where('value', $request->get('username'))
                ->first();
            $userIdentifierId = !is_null($userIdentifier) ? $userIdentifier->id: null;

            $this->logBadLogin(
                $userIdentifierId,
                $request->get('username'),
                $request->get('password'),
                "password"
            );

            throw new InvalidUserCredentialsException;
        }

    }

    /**
     * @param int|null $userIdentifierId
     * @param string $username
     * @param string $password
     * @param string $login_type
     */
    private function logBadLogin(
        int $userIdentifierId = null,
        string $username,
        string $password,
        string $login_type
    )
    {
        $this->badLoginManager->logBadLogin(
            (new BadLoginEntity())
                ->setUsername($username)
                ->setPassword($password)
                ->setUserIdentifierId($userIdentifierId)
                ->setDeviceType($this->deviceDetector->getDeviceName())
                ->setOsType($this->deviceDetector->getOs())
                ->setIp(get_user_ip())
                ->setLoginType($login_type)
        );
    }


}
