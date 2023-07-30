<?php
namespace App\Hydrators;

use App\Entities\UserEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Support\Facades\Storage;

/**
 * Class UserHydrator
 * @package App\Hydrators
 */
class UserHydrator
{

    /**
     * @var UserEntity|null
     */
    private ?UserEntity $userEntity;

    /**
     * @param array $userArray
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromArray(array $userArray) :UserHydrator
    {
        $this->userEntity = $this->arrayToEntity($userArray);

        return $this;
    }

    /**
     * @param UserEntity $userEntity
     * @return UserHydrator
     */
    public function fromEntity(UserEntity $userEntity) :UserHydrator
    {
        $this->userEntity = $userEntity;

        return $this;
    }

    /**
     * @param UserModel $userModel
     * @return UserHydrator
     * @throws CorruptedDataException
     */
    public function fromModel(UserModel $userModel) :UserHydrator
    {
        $this->userEntity = $this->modelToEntity($userModel);

        return $this;
    }

    /**
     * @return UserEntity|null
     */
    public function toEntity(): ?UserEntity
    {
        return $this->userEntity;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->entityToArray($this->userEntity);
    }

    /**
     * @param UserEntity $userEntity
     * @return UserModel
     */
    private function entityToModel(UserEntity $userEntity): UserModel
    {
        return (new UserModel())->fill(
            $this->entityToArray($userEntity)
        );
    }


    /**
     * @param UserModel $userModel
     * @return UserEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(UserModel $userModel): UserEntity
    {
        $array = $userModel->toArray();

        $array['password'] = $userModel->password;

        return $this->arrayToEntity($array);
    }

    /**
     * @param UserEntity $userEntity
     * @return array
     */
    private function entityToArray(UserEntity $userEntity): array
    {

        if($userEntity->hasFirstName()) {
            $array['first_name'] = $userEntity->getFirstName();
        }

        if($userEntity->hasLastName()) {
            $array['last_name'] = $userEntity->getLastName();
        }


        if($userEntity->hasId()) {
            $array['id'] = $userEntity->getId();
        }

        if(!is_null($userEntity->getAvatar())) {
            $array['avatar'] = $userEntity->getAvatar();
        }
        else {
            $array['avatar'] = null;
        }

        if(!is_null($userEntity->getPassword())) {
            $array['password'] = $userEntity->getPassword();
        }

        if(!is_null($userEntity->isSuperAdmin())) {
            $array['is_super_admin'] = $userEntity->isSuperAdmin();
        }

        if(!is_null($userEntity->getStatus())) {
            $array['status'] = $userEntity->getStatus();
        }

        if(!is_null($userEntity->getYearMonth())) {
            $array['year_month'] = $userEntity->getYearMonth();
        }

        if(!is_null($userEntity->getYearMonthDay())) {
            $array['year_month_day'] = $userEntity->getYearMonthDay();
        }

        if(!is_null($userEntity->getYearWeek())) {
            $array['year_week'] = $userEntity->getYearWeek();
        }

        if(!empty($userEntity->getAppFields())) {
            $array['app_fields'] = $userEntity->getAppFields();
        }

        if(!is_null($userEntity->getUserIdentifiers())) {

            /** @var UserIdentifierHydrator $userIdentifierHydrator */
            $userIdentifierHydrator = resolve(UserIdentifierHydrator::class);

            $array['user_identifiers'] = $userIdentifierHydrator
                ->fromArrayOfEntities($userEntity->getUserIdentifiers())
                ->toArrayOfArrays();
        }

        if(!is_null($userEntity->getRoles())) {
            /** @var RoleHydrator $roleHydrator */
            $roleHydrator = resolve(RoleHydrator::class);

            $array['roles'] = $roleHydrator->fromArrayOfEntities($userEntity->getRoles())->toArrayOfArrays();
        }

        return $array;
    }

    /**
     * @param array $userArray
     * @return UserEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $userArray): UserEntity
    {
        $entity = new UserEntity();

        if(!empty($userArray['first_name'])) {
            $entity->setFirstName($userArray['first_name']);
        }
        if(!empty($userArray['last_name'])) {
            $entity->setLastName($userArray['last_name']);
        }

        if(!empty($userArray['app_fields'])) {
            $entity->setAppFields($userArray['app_fields']);
        }

        if(array_key_exists('user_identifiers', $userArray)) {
            /** @var UserIdentifierHydrator $userIdentifierHydrator */
            $userIdentifierHydrator = resolve(UserIdentifierHydrator::class);

            foreach ($userArray['user_identifiers'] as $userIdentifierArray) {
                $userIdentifierEntity = $userIdentifierHydrator->fromArray($userIdentifierArray)->toEntity();
                $entity->addUserIdentifier($userIdentifierEntity);
            }
        }

        if(array_key_exists('roles', $userArray) && !empty($userArray['roles'])) {
            /** @var RoleHydrator $roleHydrator */
            $roleHydrator = resolve(RoleHydrator::class);

            foreach ($userArray['roles'] as $roleArray) {

                if(is_array($roleArray)) {
                    $entity->addRole($roleHydrator->fromArray($roleArray)->toEntity());
                }
                elseif (is_int($roleArray)) {
                    $entity->addRole($roleHydrator->fromArray(
                        RoleModel::query()->findOrFail($roleArray)->toArray()
                    )->toEntity());
                }
            }
        }

        if(array_key_exists('userRoles', $userArray) && !empty($userArray['userRoles'])) {
            /** @var RoleHydrator $roleHydrator */
            $roleHydrator = resolve(RoleHydrator::class);

            foreach ($userArray['userRoles'] as $roleArray) {

                if(is_array($roleArray)) {
                    $entity->addRole($roleHydrator->fromArray($roleArray)->toEntity());
                }
                elseif (is_int($roleArray)) {
                    $entity->addRole($roleHydrator->fromArray(
                        RoleModel::query()->findOrFail($roleArray)->toArray()
                    )->toEntity());
                }
            }
        }

        if(array_key_exists('id', $userArray) && !empty($userArray['id'])) {
            $entity->setId($userArray['id']);
        }

        if(array_key_exists('status', $userArray) && !empty($userArray['status'])) {
            $entity->setStatus($userArray['status']);
        }

        if(array_key_exists('password', $userArray) && !empty($userArray['password'])) {
            $entity->setPassword($userArray['password']);
        }

        if(array_key_exists('is_super_admin', $userArray) ) {
            $entity->setIsSuperAdmin($userArray['is_super_admin']);
        }

        if(array_key_exists('year_month', $userArray) ) {
            $entity->setYearMonth($userArray['year_month']);
        }

        if(array_key_exists('year_month_day', $userArray) ) {
            $entity->setYearMonthDay($userArray['year_month_day']);
        }

        if(array_key_exists('year_week', $userArray) ) {
            $entity->setYearWeek($userArray['year_week']);
        }

        if(array_key_exists('avatar', $userArray) && !empty($userArray['avatar'])) {
            $entity->setAvatar(Storage::url($userArray['avatar']));
        }

        return $entity;
    }

}
