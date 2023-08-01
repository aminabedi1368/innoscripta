<?php
namespace App\Entities;

use App\Constants\UserIdentifierType;
use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * Class UserEntity
 * @package App\Entities
 */
class UserEntity implements UserEntityInterface
{

    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string|null
     */
    private ?string $first_name = null;

    /**
     * @var string|null
     */
    private ?string $last_name = null;

    /**
     * @var string|null
     */
    private ?string $password = null;

    /**
     * @var string|null
     */
    private ?string $avatar = null;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var UserIdentifierEntity[]
     */
    private array $userIdentifiers = [];

    /**
     * @var bool
     */
//    private bool $is_super_user;
    private bool $is_super_user = false; // Initialize with default value


    /**
     * @var RoleEntity[]
     */
    private array $roles = [];

    /**
     * @var array
     */
    private array $app_fields = [];

    /**
     * @var bool
     */
    private bool $is_super_admin = false;

    /**
     * @var string
     */
    private string $year_month_day;

    /**
     * @var string
     */
    private string $year_month;

    /**
     * @var string
     */
    private string $year_week;


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserEntity
     */
    public function setId(?int $id): UserEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return ($this->id !==  null);
    }

    /**
     * @return bool
     */
    public function isPersisted(): bool
    {
        return $this->hasId();
    }

    /**
     * @return bool
     */
    public function isNotPersisted(): bool
    {
        return !($this->isPersisted());
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return UserEntity
     */
    public function setStatus(string $status): UserEntity
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuperUser(): bool
    {
        return $this->is_super_user;
    }


    /**
     * @param bool $is_super_user
     * @return UserEntity
     */
    public function setIsSuperUser(bool $is_super_user): UserEntity
    {
        $this->is_super_user = $is_super_user;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     * @return UserEntity
     */
    public function setFirstName(?string $first_name): UserEntity
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     * @return UserEntity
     */
    public function setLastName(?string $last_name): UserEntity
    {
        $this->last_name = $last_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return UserEntity
     */
    public function setPassword(?string $password): UserEntity
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    /**
     * @param bool $is_super_admin
     * @return UserEntity
     */
    public function setIsSuperAdmin(bool $is_super_admin): UserEntity
    {
        $this->is_super_admin = $is_super_admin;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @return UserEntity
     */
    public function setAvatar(?string $avatar): UserEntity
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @return array
     */
    public function getAppFields(): array
    {
        return $this->app_fields;
    }

    /**
     * @param array $app_fields
     * @return UserEntity
     */
    public function setAppFields(array $app_fields): UserEntity
    {
        $this->app_fields = $app_fields;
        return $this;
    }

    /**
     * @return UserIdentifierEntity[]
     */
    public function getUserIdentifiers(): array
    {
        return $this->userIdentifiers;
    }

    /**
     * @param UserIdentifierEntity[] $userIdentifiers
     * @return UserEntity
     */
    public function setUserIdentifiers(array $userIdentifiers): UserEntity
    {
        $this->userIdentifiers = $userIdentifiers;
        return $this;
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     */
    public function addUserIdentifier(UserIdentifierEntity $userIdentifierEntity)
    {
        $this->userIdentifiers[$userIdentifierEntity->getId()] = $userIdentifierEntity;
    }

    /**
     * @param int $userIdentifierId
     * @return UserEntity
     */
    public function removeUserIdentifierById(int $userIdentifierId) :UserEntity
    {
        unset($this->userIdentifiers[$userIdentifierId]);

        return $this;
    }

    /**
     * @return RoleEntity[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param RoleEntity[] $roles
     * @return UserEntity
     */
    public function setRoles(array $roles): UserEntity
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @param RoleEntity $roleEntity
     * @return $this
     */
    public function addRole(RoleEntity $roleEntity) :UserEntity
    {
        $this->roles[$roleEntity->getId()] = $roleEntity;

        return $this;
    }

    /**
     * @param int $roleEntityId
     * @return $this
     */
    public function removeRole(int $roleEntityId) :UserEntity
    {
        unset($this->roles[$roleEntityId]);

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIdentifier(): ?int
    {
        return $this->id;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function getEmailUserIdentifier(): ?UserIdentifierEntity
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::EMAIL) {
                    return $userIdentifierEntity;
                }
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasEmailIdentifier(): bool
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::EMAIL) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasNationalCodeIdentifier(): bool
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::NATIONAL_CODE) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function getMobileUserIdentifier(): ?UserIdentifierEntity
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::MOBILE) {
                    return $userIdentifierEntity;
                }
            }
        }

        return null;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function getNationalCodeUserIdentifier(): ?UserIdentifierEntity
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::NATIONAL_CODE) {
                    return $userIdentifierEntity;
                }
            }
        }

        return null;
    }


    /**
     * @return bool
     */
    public function hasMobileIdentifier(): bool
    {
        if(!empty($this->userIdentifiers)) {
            foreach ($this->userIdentifiers as $userIdentifierEntity) {
                if($userIdentifierEntity->getType() === UserIdentifierType::MOBILE) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasFirstName(): bool
    {
        return !empty($this->first_name);
    }

    /**
     * @return bool
     */
    public function hasLastName(): bool
    {
        return !empty($this->last_name);
    }

    /**
     * @param string $year_month_day
     * @return UserEntity
     */
    public function setYearMonthDay(string $year_month_day) :UserEntity
    {
        $this->year_month_day = $year_month_day;

        return $this;
    }

    /**
     * @return string
     */
    public function getYearMonthDay(): string
    {
        return $this->year_month_day;
    }

    /**
     * @return string
     */
    public function getYearMonth(): string
    {
        return $this->year_month;
    }

    /**
     * @param string $year_month
     * @return UserEntity
     */
    public function setYearMonth(string $year_month): UserEntity
    {
        $this->year_month = $year_month;
        return $this;
    }

    /**
     * @return string
     */
    public function getYearWeek(): string
    {
        return $this->year_week;
    }

    /**
     * @param string $year_week
     * @return $this
     */
    public function setYearWeek(string $year_week): UserEntity
    {
        $this->year_week = $year_week;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'password' => $this->getPassword(),
            'avatar' => $this->getAvatar(),
            'status' => $this->getStatus(),
            'userIdentifiers' => $this->getUserIdentifiers(),
            'is_super_user' => $this->isSuperUser(),
            'roles' => $this->getRoles(),
            'app_fields' => $this->getAppFields(),
            'is_super_admin' => $this->isSuperAdmin(),
            'year_month_day' => $this->getYearMonthDay(),
            'year_month' => $this->getYearMonth(),
            'year_week' => $this->getYearWeek(),
        ];
    }

    public static function createFromTokenInfo(array $tokenInfo): ?UserEntity
    {
        $userEntity = new UserEntity();

        if (isset($tokenInfo['id'])) {
            $userEntity->setId((int)$tokenInfo['id']);
        }

        if (isset($tokenInfo['first_name'])) {
            $userEntity->setFirstName($tokenInfo['first_name']);
        }

        if (isset($tokenInfo['last_name'])) {
            $userEntity->setLastName($tokenInfo['last_name']);
        }

        if (isset($tokenInfo['password'])) {
            $userEntity->setPassword($tokenInfo['password']);
        }

        if (isset($tokenInfo['avatar'])) {
            $userEntity->setAvatar($tokenInfo['avatar']);
        }

        if (isset($tokenInfo['status'])) {
            $userEntity->setStatus($tokenInfo['status']);
        }

        if (isset($tokenInfo['is_super_user'])) {
            $userEntity->setIsSuperUser((bool)$tokenInfo['is_super_user']);
        }

        if (isset($tokenInfo['app_fields'])) {
            $userEntity->setAppFields($tokenInfo['app_fields']);
        }

        if (isset($tokenInfo['is_super_admin'])) {
            $userEntity->setIsSuperAdmin((bool)$tokenInfo['is_super_admin']);
        }

        if (isset($tokenInfo['year_month_day'])) {
            $userEntity->setYearMonthDay($tokenInfo['year_month_day']);
        }

        if (isset($tokenInfo['year_month'])) {
            $userEntity->setYearMonth($tokenInfo['year_month']);
        }

        if (isset($tokenInfo['year_week'])) {
            $userEntity->setYearWeek($tokenInfo['year_week']);
        }

        if (isset($tokenInfo['userIdentifiers']) && is_array($tokenInfo['userIdentifiers'])) {
            $userIdentifierEntities = [];
            foreach ($tokenInfo['userIdentifiers'] as $identifier) {
                $userIdentifierEntity = new UserIdentifierEntity();
                $userIdentifierEntity->setType($identifier->getType());
                $userIdentifierEntity->setValue($identifier->getValue());
                $userIdentifierEntities[] = $userIdentifierEntity;
            }
            $userEntity->setUserIdentifiers($userIdentifierEntities);

        }

        if (isset($tokenInfo['roles']) && is_array($tokenInfo['roles'])) {
            foreach ($tokenInfo['roles'] as $role) {
                $roleEntity = new RoleEntity();
                $roleEntity->setId((int)$role->getId());
                $roleEntity->setName($role->getName() ?? '');
                $userEntity->addRole($roleEntity);
            }
        }

        return $userEntity;
    }
}
