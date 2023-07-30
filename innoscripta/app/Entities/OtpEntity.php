<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Class OtpEntity
 * @package App\Entities
 */
class OtpEntity
{

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $code;

    /**
     * @var Carbon|null
     */
    private ?Carbon $expires_at = null;

    /**
     * @var Carbon|null
     */
    private ?Carbon $used_at = null;

    /**
     * @var int
     */
    private int $user_identifier_id;

    /**
     * @var int
     */
    private int $user_id;

    /**
     * @var UserIdentifierEntity|null
     */
    private ?UserIdentifierEntity $userIdentifier;

    /**
     * @var UserEntity|null
     */
    private ?UserEntity $user;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return OtpEntity
     */
    public function setId(?int $id): OtpEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return OtpEntity
     */
    public function setCode(string $code): OtpEntity
    {
        $this->code = $code;
        return $this;
    }


    /**
     * @return int
     */
    public function getUserIdentifierId(): int
    {
        return $this->user_identifier_id;
    }

    /**
     * @param int $user_identifier_id
     * @return OtpEntity
     */
    public function setUserIdentifierId(int $user_identifier_id): OtpEntity
    {
        $this->user_identifier_id = $user_identifier_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return OtpEntity
     */
    public function setUserId(int $user_id): OtpEntity
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function getUserIdentifier(): ?UserIdentifierEntity
    {
        return $this->userIdentifier;
    }

    /**
     * @param UserIdentifierEntity|null $userIdentifier
     * @return OtpEntity
     */
    public function setUserIdentifier(?UserIdentifierEntity $userIdentifier): OtpEntity
    {
        $this->userIdentifier = $userIdentifier;
        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity|null $user
     * @return OtpEntity
     */
    public function setUser(?UserEntity $user): OtpEntity
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUserEntityLoaded()
    {
        return !empty($this->user);
    }

    /**
     * @return bool
     */
    public function isUserIdentifierEntityLoaded()
    {
        return !empty($this->userIdentifier);
    }

    /**
     * @return bool
     */
    public function hasId()
    {
        return !empty($this->id);
    }

    /**
     * @return Carbon|null
     */
    public function getExpiresAt(): ?Carbon
    {
        return $this->expires_at;
    }

    /**
     * @param Carbon|null $expires_at
     * @return OtpEntity
     */
    public function setExpiresAt(?Carbon $expires_at): OtpEntity
    {
        $this->expires_at = $expires_at;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getUsedAt(): ?Carbon
    {
        return $this->used_at;
    }

    /**
     * @param Carbon|null $used_at
     * @return OtpEntity
     */
    public function setUsedAt(?Carbon $used_at): OtpEntity
    {
        $this->used_at = $used_at;
        return $this;
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
        return !$this->isPersisted();
    }

    /**
     * @return bool
     */
    public function isUsed()
    {
        return !is_null($this->used_at);
    }

    /**
     * @return bool
     */
    public function isUsable()
    {
        return !empty($this->expires_at) && is_null($this->used_at) && $this->expires_at->isFuture();
    }


}
