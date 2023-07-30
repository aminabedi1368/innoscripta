<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Class UserIdentifierEntity
 * @package App\Entities
 */
class UserIdentifierEntity
{

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var int
     */
    private int $user_id;

    /**
     * @var UserEntity|null
     */
    private ?UserEntity $userEntity = null;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var string
     */
    private string $value;

    /**
     * @var bool
     */
    private bool $is_verified;

    /**
     * @var Carbon|null
     */
    private ?Carbon $created_at = null;

    /**
     * @var Carbon|null
     */
    private ?Carbon $updated_at = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserIdentifierEntity
     */
    public function setId(?int $id): UserIdentifierEntity
    {
        $this->id = $id;
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
     * @return UserIdentifierEntity
     */
    public function setUserId(int $user_id): UserIdentifierEntity
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
     * @return bool
     */
    public function isUserEntityLoaded()
    {
        return !empty($this->userEntity);
    }

    /**
     * @param UserEntity|null $userEntity
     * @return UserIdentifierEntity
     */
    public function setUserEntity(?UserEntity $userEntity): UserIdentifierEntity
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return UserIdentifierEntity
     */
    public function setType(string $type): UserIdentifierEntity
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return UserIdentifierEntity
     */
    public function setValue(string $value): UserIdentifierEntity
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    /**
     * @return bool
     */
    public function isNotVerified(): bool
    {
        return !$this->is_verified;
    }

    /**
     * @param bool $is_verified
     * @return UserIdentifierEntity
     */
    public function setIsVerified(bool $is_verified): UserIdentifierEntity
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    /**
     * @param Carbon|null $created_at
     * @return UserIdentifierEntity
     */
    public function setCreatedAt(?Carbon $created_at): UserIdentifierEntity
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param Carbon|null $updated_at
     * @return UserIdentifierEntity
     */
    public function setUpdatedAt(?Carbon $updated_at): UserIdentifierEntity
    {
        $this->updated_at = $updated_at;
        return $this;
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
        return !$this->isPersisted();
    }

}
