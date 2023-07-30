<?php
namespace App\Actions\Token;

use App\Entities\BadLoginEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Managers\BadLoginManager;
use DeviceDetector\DeviceDetector;
use Illuminate\Http\Request;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/**
 * Class IssueTokenAdminAction
 * @package App\Actions\Token
 */
class IssueTokenAdminAction
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
     * @var DeviceDetector
     */
    private DeviceDetector $deviceDetector;

    /**
     * @var BadLoginManager
     */
    private BadLoginManager $badLoginManager;

    /**
     * IssueTokenClientCredentialsAction constructor.
     * @param AuthorizationServer $authorizationServer
     * @param HttpFoundationFactory $httpFoundationFactory
     * @param DeviceDetector $deviceDetector
     * @param BadLoginManager $badLoginManager
     */
    public function __construct(
        AuthorizationServer $authorizationServer,
        HttpFoundationFactory $httpFoundationFactory,
        DeviceDetector $deviceDetector,
        BadLoginManager $badLoginManager
    )
    {
        $this->authorizationServer = $authorizationServer;
        $this->httpFoundationFactory = $httpFoundationFactory;
        $this->deviceDetector = $deviceDetector;
        $this->badLoginManager = $badLoginManager;
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws InvalidUserCredentialsException
     * @throws OAuthServerException
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
            return json_decode($response, true);
        }
        catch (InvalidUserCredentialsException $e) {

            $this->logBadLogin(
                null,
                $request->get('username'),
                $request->get('client_secret'),
                "admin_generate_token"
            );
            throw $e;
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
