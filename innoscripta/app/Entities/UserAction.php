<?php
namespace App\Entities;

use Carbon\Carbon;

/**
 * Class UserAction
 * @package App\Entities
 */
class UserAction
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
    private ?UserEntity $userEntity;

    /**
     * @var string
     */
    private string $action;

    /**
     * @var array|null
     */
    private ?array $action_data;

    /**
     * @var Carbon
     */
    private Carbon $created_at;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserAction
     */
    public function setId(?int $id): UserAction
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
     * @return UserAction
     */
    public function setUserId(int $user_id): UserAction
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
     * @return UserAction
     */
    public function setUserEntity(?UserEntity $userEntity): UserAction
    {
        $this->userEntity = $userEntity;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return UserAction
     */
    public function setAction(string $action): UserAction
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getActionData(): ?array
    {
        return $this->action_data;
    }

    /**
     * @param array|null $action_data
     * @return UserAction
     */
    public function setActionData(?array $action_data): UserAction
    {
        $this->action_data = $action_data;
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
     * @return UserAction
     */
    public function setCreatedAt(Carbon $created_at): UserAction
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUserEntityLoaded()
    {
        return !empty($this->userEntity);
    }

}
