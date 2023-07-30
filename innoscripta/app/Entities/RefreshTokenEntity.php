<?php
namespace App\Entities;

use Carbon\Carbon;
use DateTimeImmutable;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * Class RefreshTokenEntity
 * @package App\Entities
 */
class RefreshTokenEntity implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;

    /**
     * @var string|null
     */
    private ?string $id;

    /**
     * @var string|null
     */
    private ?string $access_token_id = null;

    /**
     * @var bool
     */
    private bool $is_revoked;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @var Carbon
     */
    private Carbon $expires_at;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return RefreshTokenEntity
     */
    public function setId(?string $id): RefreshTokenEntity
    {
        $this->id = $id;
        $this->identifier = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccessTokenId(): ?string
    {
        return $this->access_token_id;
    }

    /**
     * @param string|null $access_token_id
     * @return RefreshTokenEntity
     */
    public function setAccessTokenId(?string $access_token_id): RefreshTokenEntity
    {
        $this->access_token_id = $access_token_id;
        return $this;
    }


    /**
     * @param AccessTokenEntityInterface $accessToken
     * @return $this
     */
    public function setAccessToken(AccessTokenEntityInterface $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->access_token_id = $accessToken->getIdentifier();

        return $this;
    }

    /**
     * @return bool
     */
    public function isRevoked(): bool
    {
        return $this->is_revoked;
    }

    /**
     * @param bool $is_revoked
     * @return RefreshTokenEntity
     */
    public function setIsRevoked(bool $is_revoked): RefreshTokenEntity
    {
        $this->is_revoked = $is_revoked;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @param Carbon $created_at
     * @return RefreshTokenEntity
     */
    public function setCreatedAt(Carbon $created_at): RefreshTokenEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expires_at;
    }

    /**
     * @param Carbon $expires_at
     * @return RefreshTokenEntity
     */
    public function setExpiresAt(Carbon $expires_at): RefreshTokenEntity
    {
        $this->expires_at = $expires_at;
        $this->expiryDateTime = $expires_at->toDateTimeImmutable();

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccessTokenEntityLoaded()
    {
        return !empty($this->accessToken);
    }

    /**
     * Get the token's expiry date time.
     *
     * @return DateTimeImmutable
     */
    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param DateTimeImmutable $dateTime
     * @return RefreshTokenEntity
     */
    public function setExpiryDateTime(DateTimeImmutable $dateTime)
    {
        $this->expiryDateTime = $dateTime;
        $this->expires_at = Carbon::instance($dateTime);

        return $this;
    }


}
