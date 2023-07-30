<?php
namespace App\Lib\OAuth;

use App\Entities\AccessTokenEntity;
use App\Exceptions\Auth\InvalidUserCredentialsException;
use App\Exceptions\CorruptedDataException;
use App\Repos\AccessTokenRepository;
use DateInterval;
use DateTimeImmutable;
use DeviceDetector\DeviceDetector;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\RequestEvent;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class OauthPasswordGrant
 * @package Azki\Lib\OAuth
 */
class OauthPasswordGrant extends PasswordGrant
{
    /**
     * @var DeviceDetector
     */
    private DeviceDetector $deviceDetector;

    /**
     * OauthPasswordGrant constructor.
     * @param UserRepositoryInterface $userRepository
     * @param RefreshTokenRepositoryInterface $refreshTokenRepository
     * @param DeviceDetector $deviceDetector
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository,
        DeviceDetector $deviceDetector
    )
    {
        parent::__construct($userRepository, $refreshTokenRepository);
        $this->deviceDetector = $deviceDetector;
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseTypeInterface $responseType
     * @param DateInterval $accessTokenTTL
     * @return ResponseTypeInterface
     * @throws CorruptedDataException
     * @throws InvalidUserCredentialsException
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    ): ResponseTypeInterface
    {
        // Validate request
        $client = $this->validateClient($request);

        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request, $this->defaultScope));
        $user = $this->validateUser($request, $client);

        // Finalize the requested scopes
        $finalizedScopes = $this->scopeRepository->finalizeScopes(
            $scopes,
            $this->getIdentifier(),
            $client,
            $user->getIdentifier()
        );

        // Issue and persist new access token
        $accessToken = $this->issueAccessToken(
            $accessTokenTTL,
            $client,
            $user->getIdentifier(),
            $finalizedScopes,
            $request
        );
        $this->getEmitter()->emit(new RequestEvent(RequestEvent::ACCESS_TOKEN_ISSUED, $request));
        $responseType->setAccessToken($accessToken);

        // Issue and persist new refresh token if given
        $refreshToken = $this->issueRefreshToken($accessToken);

        if ($refreshToken !== null) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::REFRESH_TOKEN_ISSUED, $request));
            $responseType->setRefreshToken($refreshToken);
        }

        request()->merge(['user' => $user]);

        return $responseType;
    }


    /**
     * Issue an access token.
     *
     * @param DateInterval $accessTokenTTL
     * @param ClientEntityInterface $client
     * @param string|null $userIdentifier
     * @param ScopeEntityInterface[] $scopes
     *
     * @param ServerRequestInterface|null $request
     * @return AccessTokenEntityInterface
     * @throws CorruptedDataException
     * @throws OAuthServerException
     * @throws UniqueTokenIdentifierConstraintViolationException
     * @throws InvalidUserCredentialsException
     */
    protected function issueAccessToken(
        DateInterval $accessTokenTTL,
        ClientEntityInterface $client,
        $userIdentifier,
        array $scopes = [],
        ServerRequestInterface $request = null
    ): AccessTokenEntityInterface
    {
        $maxGenerationAttempts = self::MAX_RANDOM_TOKEN_GENERATION_ATTEMPTS;

        /** @var AccessTokenRepository $accessTokenRepository */
        $accessTokenRepository = $this->accessTokenRepository;

        /** @var AccessTokenEntity $accessToken */
        $accessToken = $accessTokenRepository->getNewToken(
            $client,
            $scopes,
            $userIdentifier,
            $request->getParsedBody()['username']
        );

        $accessToken->setExpiryDateTime((new DateTimeImmutable())->add($accessTokenTTL));
        $accessToken->setPrivateKey($this->privateKey);
        $accessToken->setDeviceType($this->deviceDetector->getDeviceName());
        $accessToken->setDeviceOs($this->deviceDetector->getOs() ?? get_user_os());
        $accessToken->setIp(get_user_ip());
        $accessToken->setUserIdentifier($userIdentifier);


        while ($maxGenerationAttempts-- > 0) {
            $accessToken->setIdentifier($this->generateUniqueIdentifier());
            try {
                $this->accessTokenRepository->persistNewAccessToken($accessToken);

                return $accessToken;
            } catch (UniqueTokenIdentifierConstraintViolationException $e) {
                if ($maxGenerationAttempts === 0) {
                    throw $e;
                }
            }
        }
    }

}
