<?php
namespace App\Entities;

use Carbon\Carbon;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * Class AccessTokenEntity
 * @package App\Entities
 */
class AccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait, TokenEntityTrait, EntityTrait;

    /**
     * @var string|null
     */
    private ?string $id;

    /**
     * Client token has no user
     * @var int|null
     */
    private ?int $user_id = null;

    /**
     * @var UserEntity|null
     */
    private ?UserEntity $userEntity;

    /**
     * client token has no user_identifier
     *
     * @var int|null
     */
    private ?int $user_identifier_id = null;

    /**
     * @var UserIdentifierEntity|null
     */
    private ?UserIdentifierEntity $userIdentifierEntity;

    /**
     * @var int
     */
    private int $client_id;

    /**
     * @var ClientEntity|null
     */
    private ?ClientEntity $clientEntity;

    /**
     * @var string|null
     */
    private ?string $device_os = null;

    /**
     * @var string|null
     */
    private ?string $device_type = null;

    /**
     * @var string|null
     */
    private ?string $details;

    /**
     * @var string|null
     */
    private ?string $ip = null;

    /**
     * @var bool
     */
    private bool $is_revoked;

    /**
     * @var Carbon
     */
    private Carbon $expires_at;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @var Carbon
     */
    private Carbon $updated_at;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return AccessTokenEntity
     */
    public function setId(?string $id): AccessTokenEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     * @return AccessTokenEntity
     */
    public function setUserId(?int $user_id): AccessTokenEntity
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function getUserEntity(): ?UserEntity
    {
        return $this->userEntity;
    }

    /**
     * @param UserEntity|null $userEntity
     * @return AccessTokenEntity
     */
    public function setUserEntity(?UserEntity $userEntity): AccessTokenEntity
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserIdentifierId(): ?int
    {
        return $this->user_identifier_id;
    }

    /**
     * @param int|null $user_identifier_id
     * @return AccessTokenEntity
     */
    public function setUserIdentifierId(?int $user_identifier_id): AccessTokenEntity
    {
        $this->user_identifier_id = $user_identifier_id;
        return $this;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function getUserIdentifierEntity(): ?UserIdentifierEntity
    {
        return $this->userIdentifierEntity;
    }

    /**
     * @param UserIdentifierEntity|null $userIdentifierEntity
     * @return AccessTokenEntity
     */
    public function setUserIdentifierEntity(?UserIdentifierEntity $userIdentifierEntity): AccessTokenEntity
    {
        $this->userIdentifierEntity = $userIdentifierEntity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param string|null $ip
     * @return AccessTokenEntity
     */
    public function setIp(?string $ip): AccessTokenEntity
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     * @return AccessTokenEntity
     */
    public function setClientId(int $client_id): AccessTokenEntity
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * @return ClientEntity|null
     */
    public function getClientEntity(): ?ClientEntity
    {
        return $this->clientEntity;
    }

    /**
     * @param ClientEntity|null $clientEntity
     * @return AccessTokenEntity
     */
    public function setClientEntity(?ClientEntity $clientEntity): AccessTokenEntity
    {
        $this->clientEntity = $clientEntity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceOs(): ?string
    {
        return $this->device_os;
    }

    /**
     * @param string|null $deice_os
     * @return AccessTokenEntity
     */
    public function setDeviceOs(?string $deice_os): AccessTokenEntity
    {
        $this->device_os = $deice_os;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getScopes(): ?array
    {
        return $this->scopes;
    }

    /**
     * @param array|null $scopes
     * @return AccessTokenEntity
     */
    public function setScopes(?array $scopes): AccessTokenEntity
    {
        $this->scopes = $scopes;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->device_type;
    }

    /**
     * @param string|null $device_type
     * @return AccessTokenEntity
     */
    public function setDeviceType(?string $device_type): AccessTokenEntity
    {
        $this->device_type = $device_type;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * @param string|null $details
     * @return AccessTokenEntity
     */
    public function setDetails(?string $details): AccessTokenEntity
    {
        $this->details = $details;
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
     * @return AccessTokenEntity
     */
    public function setIsRevoked(bool $is_revoked): AccessTokenEntity
    {
        $this->is_revoked = $is_revoked;
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
     * @return AccessTokenEntity
     */
    public function setExpiresAt(Carbon $expires_at): AccessTokenEntity
    {
        $this->expires_at = $expires_at;
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
     * @return AccessTokenEntity
     */
    public function setCreatedAt(Carbon $created_at): AccessTokenEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon $updated_at
     * @return AccessTokenEntity
     */
    public function setUpdatedAt(Carbon $updated_at): AccessTokenEntity
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUserEntityLoaded()
    {
        return !empty($this->userEntity);
    }

    /**
     * @return bool
     */
    public function isUserIdentifierLoaded()
    {
        return !empty($this->userIdentifierEntity);
    }

    /**
     * @return bool
     */
    public function isClientEntityLoaded()
    {
        return !empty($this->clientEntity);
    }

    /**
     * @return bool
     */
    public function areScopeEntitiesLoaded()
    {
        return !empty($this->scopes);
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return !empty($this->id);
    }

    /**
     * @return bool
     */
    public function isPersisted()
    {
        return $this->hasId();
    }

    /**
     * @return bool
     */
    public function isNotPersisted()
    {
        return !($this->isPersisted());
    }


}
