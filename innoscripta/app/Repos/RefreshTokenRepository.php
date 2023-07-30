<?php
namespace App\Repos;

use App\Entities\RefreshTokenEntity;
use App\Models\RefreshTokenModel;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;

/**
 * Class RefreshTokenRepository
 * @package App\Repos
 */
class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{

    /**
     * @var RefreshTokenModel
     */
    private RefreshTokenModel $refreshTokenModel;

    /**
     * RefreshTokenRepository constructor.
     * @param RefreshTokenModel $refreshTokenModel
     */
    public function __construct(RefreshTokenModel $refreshTokenModel)
    {
        $this->refreshTokenModel = $refreshTokenModel;
    }

    /**
     * @return RefreshTokenEntity
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    /**
     * @param RefreshTokenEntityInterface $refreshTokenEntity
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        /** @var RefreshTokenEntity $refreshTokenEntity */
        $this->refreshTokenModel->fill([
            'id' => $refreshTokenEntity->getIdentifier(),
            'access_token_id' => $refreshTokenEntity->getAccessTokenId(),
            'expires_at' => $refreshTokenEntity->getExpiresAt(),
            'is_revoked' => 0
        ])->save();
    }

    /**
     * @param string $tokenId
     */
    public function revokeRefreshToken($tokenId)
    {
        $refreshToken = RefreshTokenModel::query()->findOrFail($tokenId);

        $refreshToken->update(['is_revoked' => true]);
    }

    /**
     * @param string $tokenId
     * @return bool
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        /** @var RefreshTokenModel $refreshToken */
        $refreshToken = RefreshTokenModel::query()->findOrFail($tokenId);

        return $refreshToken->is_revoked;
    }

}
