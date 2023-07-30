<?php
namespace App\Hydrators;

use App\Entities\RoleEntity;
use App\Entities\ScopeEntity;
use App\Entities\UserEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\RoleModel;
use App\Models\ScopeModel;
use App\Models\UserModel;

/**
 * Class RoleHydrator
 * @package App\Hydrators
 */
class RoleHydrator
{

    /**
     * @var RoleEntity|null
     */
    private ?RoleEntity $roleEntity;

    /**
     * @var RoleEntity[]|null
     */
    private ?array $entities;

    /**
     * @param array $roleArray
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromArray(array $roleArray): RoleHydrator
    {
        $this->roleEntity = $this->arrayToEntity($roleArray);

        return $this;
    }

    /**
     * @param RoleEntity $roleEntity
     * @return RoleHydrator
     */
    public function fromEntity(RoleEntity $roleEntity): RoleHydrator
    {
        $this->roleEntity = $roleEntity;

        return $this;
    }

    /**
     * @param RoleModel $roleModel
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromModel(RoleModel $roleModel): RoleHydrator
    {
        $this->roleEntity = $this->modelToEntity($roleModel);

        return $this;
    }

    /**
     * @return RoleEntity|null
     */
    public function toEntity(): ?RoleEntity
    {
        return $this->roleEntity;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->entityToArray($this->roleEntity);
    }

    /**
     * @param array $roles
     * @return RoleHydrator
     * @throws CorruptedDataException
     */
    public function fromArrayOfArrays(array $roles): RoleHydrator
    {
        $entities = [];

        foreach ($roles as $array) {
            if(!is_array($array)) {
                throw new \InvalidArgumentException('each array item should be role array representation');
            }
            $entities[] = $this->arrayToEntity($array);
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @return RoleEntity[]|null
     */
    public function toArrayOfEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @param RoleEntity $roleEntity
     * @return RoleModel
     */
    private function entityToModel(RoleEntity $roleEntity): RoleModel
    {
        return (new RoleModel())->fill(
            $this->entityToArray($roleEntity)
        );
    }


    /**
     * @param RoleModel $roleModel
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(RoleModel $roleModel): RoleEntity
    {
        $array = $roleModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param array $entities
     * @return $this
     */
    public function fromArrayOfEntities(array $entities): RoleHydrator
    {
        foreach ($entities as $entity) {
            if(!$entity instanceof RoleEntity) {
                throw new \InvalidArgumentException('entities should be instance of RoleEntity Class');
            }
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @return array
     */
    public function toArrayOfArrays(): array
    {
        $res = [];

        foreach ($this->entities as $entity) {
            $res[] = $this->entityToArray($entity);
        }

        return $res;
    }

    /**
     * @param RoleEntity $roleEntity
     * @return array
     */
    private function entityToArray(RoleEntity $roleEntity): array
    {
        $array = [
            'name' => $roleEntity->getName(),
            'slug' => $roleEntity->getSlug(),
            'project_id' => $roleEntity->getProjectId(),
            'description' => $roleEntity->getDescription()
        ];

        /** @var ScopeHydrator $scopeHydrator */
        $scopeHydrator = resolve(ScopeHydrator::class);

        /** @var UserHydrator $userHydrator */
        $userHydrator = resolve(UserHydrator::class);

        if($roleEntity->hasId()) {
            $array['id'] = $roleEntity->getId();
        }

        if($roleEntity->hasScope()) {
            $scopes = [];
            foreach ($roleEntity->getScopes() as $scope) {
                $scopes[] = $scopeHydrator->fromEntity($scope)->toArray();
            }

            $array['scopes'] = $scopes;
        }

        if($roleEntity->hasUser()) {
            $users = [];
            foreach ($roleEntity->getUsers() as $user) {
                $users[] = $userHydrator->fromEntity($user)->toArray();
            }
            $array['users'] = $users;
        }

        if($roleEntity->isProjectEntityLoaded()) {
            $array['project'] = $roleEntity->getProjectEntity();
        }

        return $array;
    }

    /**
     * @param array $roleArray
     * @return RoleEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $roleArray): RoleEntity
    {
        $entity = (new RoleEntity())
            ->setName($roleArray['name'])
            ->setSlug($roleArray['slug'])
            ->setProjectId($roleArray['project_id'])
            ->setDescription(array_key_exists('description', $roleArray) ? $roleArray['description'] : null);

        if(array_key_exists('id', $roleArray) && !empty($roleArray['id'])) {
            $entity->setId($roleArray['id']);
        }

        /** @var ProjectHydrator $projectHydrator */
        $projectHydrator = resolve(ProjectHydrator::class);

        if(array_key_exists('project', $roleArray) && !empty($roleArray['project'])) {
            $entity->setProjectEntity($projectHydrator->fromArray($roleArray['project'])->toEntity());
        }

            /** @var ScopeHydrator $scopeHydrator */
        $scopeHydrator = resolve(ScopeHydrator::class);

        /** @var UserHydrator $userHydrator */
        $userHydrator = resolve(UserHydrator::class);

        $scopes = [];
        $users = [];

        if(array_key_exists('scopes', $roleArray) && !empty($roleArray['scopes'])) {

            foreach ($roleArray['scopes'] as $scope) {
                if(is_array($scope)) {
                    $scopes[] = $scopeHydrator->fromArray($scope)->toEntity();
                }
                elseif ($scope instanceof ScopeEntity) {
                    $scopes[] = $scope;
                }
                elseif ($scope instanceof ScopeModel) {
                    $scopes[] = $scopeHydrator->fromModel($scope)->toEntity();
                }
                elseif (is_string($scope) && is_json($scope)) {
                    $scopes[] = $scopeHydrator->fromArray(json_decode($scope, true))->toEntity();
                }
                elseif (is_int($scope)) {
                    /** @var ScopeModel $scopeModel */
                    $scopeModel = ScopeModel::query()->findOrFail($scope);
                    $scopes[] = $scopeHydrator->fromModel($scopeModel)->toEntity();
                }
                else {
                    throw new CorruptedDataException('Corrupted DATA.....');
                }
            }

        }


        if(array_key_exists('roleScopes', $roleArray) && !empty($roleArray['roleScopes'])) {

            foreach ($roleArray['roleScopes'] as $scope) {
                if(is_array($scope)) {
                    $scopes[] = $scopeHydrator->fromArray($scope)->toEntity();
                }
                elseif ($scope instanceof ScopeEntity) {
                    $scopes[] = $scope;
                }
                elseif ($scope instanceof ScopeModel) {
                    $scopes[] = $scopeHydrator->fromModel($scope)->toEntity();
                }
                elseif (is_string($scope) && is_json($scope)) {
                    $scopes[] = $scopeHydrator->fromArray(json_decode($scope, true))->toEntity();
                }
                elseif (is_int($scope)) {
                    /** @var ScopeModel $scopeModel */
                    $scopeModel = ScopeModel::query()->findOrFail($scope);
                    $scopes[] = $scopeHydrator->fromModel($scopeModel)->toEntity();
                }
                else {
                    throw new CorruptedDataException('Corrupted DATA.....');
                }
            }

        }

        if(array_key_exists('users', $roleArray) && !empty($roleArray['users'])) {
            foreach ($roleArray['users'] as $user) {
                if(is_array($user)) {
                    $users[] = $userHydrator->fromArray($user)->toEntity();
                }
                elseif ($user instanceof UserEntity) {
                    $users[] = $user;
                }
                elseif ($user instanceof UserModel) {
                    $users[] = $userHydrator->fromModel($user)->toEntity();
                }
                elseif (is_string($user) && is_json($user)) {
                    $users[] = $userHydrator->fromArray(json_decode($user, true))->toEntity();
                }
                else {
                    throw new CorruptedDataException('Corrupted DATA.....');
                }
            }

        }

        $entity->setScopes($scopes);
        $entity->setUsers($users);

        return $entity;
    }

}
