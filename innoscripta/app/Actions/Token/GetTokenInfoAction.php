<?php
namespace App\Actions\Token;

use App\Exceptions\CorruptedDataException;
use App\Exceptions\Token\InvalidTokenException;
use App\Lib\TokenInfoVO;
use App\Repos\AccessTokenRepository;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResourceServer;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

/**
 * Class GetTokenInfoAction
 * @package App\Actions\Token
 */
class GetTokenInfoAction
{
    /**
     * @var ResourceServer
     */
    private ResourceServer $resourceServer;

    /**
     * @var AccessTokenRepository
     */
    private AccessTokenRepository $tokenRepo;

    /**
     * GetTokenInfoAction constructor.
     * @param ResourceServer $resourceServer
     * @param AccessTokenRepository $tokenRepo
     */
    public function __construct(
        ResourceServer $resourceServer,
        AccessTokenRepository $tokenRepo
    )
    {
        $this->resourceServer = $resourceServer;
        $this->tokenRepo = $tokenRepo;
    }

    /**
     * @param string $access_token
     * @return TokenInfoVO
     * @throws InvalidTokenException
     * @throws CorruptedDataException
     */
    public function __invoke(string $access_token): TokenInfoVO
    {
        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $request = request();
        $request->headers->set('Authorization', 'Bearer '. $access_token);

        $psrRequest = $psrHttpFactory->createRequest($request);

        try {
            $serverRequest = $this->resourceServer->validateAuthenticatedRequest($psrRequest);

            ### attributes
//            array:4 [
//                  "oauth_access_token_id" => "b7ec0bf6723882f291723960213925909d2fd739407fa13f77d9177ad5f5cd557f15bb7c2d2a2729"
//                  "oauth_client_id" => "pdtd5lGQs6kEHSdDQb3B"
//                  "oauth_user_id" => ""
//                  "oauth_scopes" => []
//            ]
//            $request->merge(['oauth_access_token_id' => $serverRequest->getAttribute('oauth_access_token_id')]);


            $user_entity = $this->tokenRepo->getUserEntityByActiveToken(
                $serverRequest->getAttribute('oauth_access_token_id'),
            );

            $attributes = $serverRequest->getAttributes();
            $attributes['user_entity'] = $user_entity;

            return TokenInfoVO::fromArray($attributes);

        } catch (OAuthServerException $e) {
            throw new InvalidTokenException($access_token);
        }
    }

}
