<?php
namespace App\Actions\Token;

use App\Exceptions\Token\InvalidTokenException;
use App\Exceptions\Token\TokenNotFoundException;
use App\Repos\AccessTokenRepository;

/**
 * Class RevokeTokenAction
 * @package App\Actions\Token
 */
class RevokeTokenAction
{
    /**
     * @var AccessTokenRepository
     */
    private AccessTokenRepository $accessTokenRepository;

    /**
     * @var GetTokenInfoAction
     */
    private GetTokenInfoAction $getTokenInfoAction;

    /**
     * RevokeTokenAction constructor.
     * @param AccessTokenRepository $accessTokenRepository
     * @param GetTokenInfoAction $getTokenInfoAction
     */
    public function __construct(AccessTokenRepository $accessTokenRepository, GetTokenInfoAction $getTokenInfoAction)
    {
        $this->accessTokenRepository = $accessTokenRepository;
        $this->getTokenInfoAction = $getTokenInfoAction;
    }

    /**
     * @param string $access_token
     * @throws InvalidTokenException
     * @throws TokenNotFoundException
     */
    public function __invoke(string $access_token)
    {
        $tokenInfo = $this->getTokenInfoAction->__invoke($access_token);

        $this->accessTokenRepository->revokeAccessToken($tokenInfo->getOauthAccessTokenId());
    }

}
