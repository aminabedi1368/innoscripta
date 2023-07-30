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
 * Class IssueTokenClientCredentialsAction
 * @package App\Actions\Token
 */
class IssueTokenClientCredentialsAction
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

            // $this->logBadLogin(
            //     null,
            //     $request->get('client_secret'),
            //     "client_credentials"
            // );
            throw $e;
        }
        catch (OAuthServerException $e) {
            throw new InvalidUserCredentialsException;
        }
    }

    /**
     * @param int|null $userIdentifierId
     * @param string $password
     * @param string $login_type
     */
    private function logBadLogin(
        int $userIdentifierId = null,
        string $password,
        string $login_type
    )
    {
        $this->badLoginManager->logBadLogin(
            (new BadLoginEntity())
                ->setUsername(null)
                ->setPassword($password)
                ->setUserIdentifierId($userIdentifierId)
                ->setDeviceType($this->deviceDetector->getDeviceName())
                ->setOsType($this->deviceDetector->getOs())
                ->setIp(get_user_ip())
                ->setLoginType($login_type)
        );
    }


}
