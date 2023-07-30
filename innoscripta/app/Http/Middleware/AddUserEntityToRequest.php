<?php
namespace App\Http\Middleware;

use App\Actions\Token\GetTokenInfoAction;
use App\Exceptions\Token\InvalidTokenException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use League\OAuth2\Server\ResourceServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/**
 * Class AddUserEntityToRequest
 * @package App\Http\Middleware
 */
class AddUserEntityToRequest
{
    /**
     * @var GetTokenInfoAction
     */
    private GetTokenInfoAction $getTokenInfoAction;

    /**
     * @var ResourceServer
     */
    private ResourceServer $resourceServer;


    /**
     * AddUserEntityToRequest constructor.
     * @param GetTokenInfoAction $getTokenInfoAction
     * @param ResourceServer $resourceServer
     */
    public function __construct(GetTokenInfoAction $getTokenInfoAction,ResourceServer $resourceServer)
    {
        $this->getTokenInfoAction = $getTokenInfoAction;
        $this->resourceServer = $resourceServer;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->cookie('access_token')) {
            $this->handleWithCookieRequest($request);
        }

        $this->setUserOnRequestIfExists($request);

        return $next($request);
    }

    /**
     * @param Request $request
     */
    private function handleWithCookieRequest(Request $request)
    {
        $request->headers->set('Authorization', 'Bearer ' . $request->cookie('access_token'));
    }

    /**
     * @param Request $request
     */
    private function setUserOnRequestIfExists(Request $request)
    {
        try{
            $authorizationHeader = $request->header('Authorization');

            if(!empty($authorizationHeader) && Str::contains($authorizationHeader, "Bearer")) {
                $psr17Factory = new Psr17Factory();
                $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
                $psrRequest = $psrHttpFactory->createRequest($request);

                $access_token = explode(" ", $authorizationHeader)[1];

                try {
//                    $serverRequest = $this->resourceServer->validateAuthenticatedRequest($psrRequest);
//                    $access_token_id = $serverRequest->getAttributes()['oauth_access_token_id'];
                    $tokenInfo = $this->getTokenInfoAction->__invoke($access_token);
                    $userEntity = $tokenInfo->getUserEntity();

                    // Convert the UserEntity object to an array (if it exists)
                    $userEntityArray = $userEntity ? $userEntity->toArray() : null;

                    // Assemble the data into an array
                    $tokenInfoArray = [
                        'userEntity' => $userEntityArray,
                        'oauth_access_token_id' => $tokenInfo->getOauthAccessTokenId(),
                        'oauth_client_id' => $tokenInfo->getOauthClientId(),
                        'oauth_user_id' => $tokenInfo->getOauthUserId(),
                        'oauth_scopes' => $tokenInfo->getOauthScopes(),
                    ];

                    $request->merge(['tokenInfo' => $tokenInfoArray]);

                } catch (\Exception $e) {

//                    dd($e->getMessage(), get_class($e));
                }

            }

        }
        catch (InvalidTokenException $e) {
            ## do nothing
        }
    }


}
