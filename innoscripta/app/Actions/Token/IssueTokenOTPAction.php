<?php
namespace App\Actions\Token;

use App\Entities\BadLoginEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Managers\BadLoginManager;
use App\Models\UserIdentifierModel;
use DeviceDetector\DeviceDetector;
use Exception;
use Illuminate\Http\Request;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/**
 * Class IssueTokenOTPAction
 * @package Azki\Systems\User\Authentication\Action
 */
class IssueTokenOTPAction
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
        DeviceDetector $deviceDetector
    ) {
        $this->authorizationServer = $authorizationServer;
        $this->httpFoundationFactory = $httpFoundationFactory;
        $this->badLoginManager = $badLoginManager;
        $this->deviceDetector = $deviceDetector;
    }

    /**
     * @param Request $request
     * @return string
     * @throws OAuthServerException
     * @throws Exception
     */
    public function __invoke(Request $request)
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $psrRequest = $psrHttpFactory->createRequest($request);

        try {
            $psrResponse = $this->authorizationServer->respondToAccessTokenRequest($psrRequest, new Response());
            $response = $this->httpFoundationFactory->createResponse($psrResponse);
            $response = $response->getContent();

            return $response;
        }
        catch (InvalidUserCredentialsException $e) {

            /** @var UserIdentifierModel $userIdentifier */
            $userIdentifier = UserIdentifierModel::query()
                ->where('value', $request->get('username'))
                ->first();
            $userIdentifierId = !is_null($userIdentifier) ? $userIdentifier->id: null;

            $this->logBadLogin(
                $userIdentifierId,
                $request->get('username'),
                $request->get('code'),
                "otp"
            );
            throw $e;
        }
            ### todo remove these source
        catch (\Exception $e) {
            ## do sth

            throw $e;
        }

    }

    /**
     * @param int $userIdentifierId
     * @param string $username
     * @param string $password
     * @param string $login_type
     */
    private function logBadLogin(
        int $userIdentifierId,
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
