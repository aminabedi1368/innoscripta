<?php
namespace App\Hydrators;

use  App\Entities\ClientEntity;
use App\Entities\ProjectEntity;
use App\Entities\RoleEntity;
use App\Entities\ScopeEntity;
use App\Entities\UserEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\ProjectModel;

/**
 * Class ProjectHydrator
 * @package App\Hydrators
 */
class ProjectHydrator
{
    /**
     * @var ProjectEntity|null
     */
    private ?ProjectEntity $projectEntity;

    /**
     * @param array $ProjectArray
     * @return $this
     */
    public function fromArray(array $ProjectArray)
    {
        $this->projectEntity = $this->arrayToEntity($ProjectArray);

        return $this;
    }

    /**
     * @param ProjectEntity $projectEntity
     * @return ProjectHydrator
     */
    public function fromEntity(ProjectEntity $projectEntity)
    {
        $this->projectEntity = $projectEntity;

        return $this;
    }

    /**
     * @param ProjectModel $projectModel
     * @return $this
     */
    public function fromModel(ProjectModel $projectModel)
    {
        $this->projectEntity = $this->modelToEntity($projectModel);

        return $this;
    }

    /**
     * @return ProjectEntity|null
     */
    public function toEntity()
    {
        return $this->projectEntity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityToArray($this->projectEntity);
    }

    /**
     * @param ProjectEntity $projectEntity
     * @return ProjectModel
     */
    private function entityToModel(ProjectEntity $projectEntity)
    {
        return (new ProjectModel())->fill(
            $this->entityToArray($projectEntity)
        );
    }


    /**
     * @param ProjectModel $projectModel
     * @return ProjectEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(ProjectModel $projectModel)
    {
        $array = $projectModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param ProjectEntity $projectEntity
     * @return array
     */
    private function entityToArray(ProjectEntity $projectEntity)
    {
        $array = [
            'name' => $projectEntity->getName(),
            'slug' => $projectEntity->getSlug(),
            'creator_user_id' => $projectEntity->getCreatorUserId()
        ];

        if($projectEntity->hasId()) {
            $array['id'] = $projectEntity->getId();
        }
        if($projectEntity->isUserEntityLoaded()) {
            /** @var UserHydrator $userHydrator */
            $userHydrator = resolve(UserHydrator::class);
            $array['creator_user'] = $userHydrator->fromEntity($projectEntity->getCreatorUser())->toArray();
        }
        if(!empty($projectEntity->getProjectId())) {
            $array['project_id'] = $projectEntity->getProjectId();
        }
        if(!empty($projectEntity->getDescription())) {
            $array['description'] = $projectEntity->getDescription();
        }
        if($projectEntity->areScopesLoaded()) {
            /** @var ScopeHydrator $scopeHydrator */
            $scopeHydrator = resolve(ScopeHydrator::class);
            $array_scopes = $scopeHydrator->fromArrayOfEntities($projectEntity->getScopes())->toArrayOfArrays();

            $array['scopes'] = $array_scopes;
        }
        if($projectEntity->areClientsLoaded()) {
            /** @var ClientHydrator $clientHydrator */
            $clientHydrator = resolve(ClientHydrator::class);
            $array_clients = $clientHydrator->fromArrayOfEntities($projectEntity->getClients())->toArrayOfArrays();

            $array['clients'] = $array_clients;
        }
        if($projectEntity->areRolesLoaded()) {
            /** @var RoleHydrator $roleHydrator */
            $roleHydrator = resolve(RoleHydrator::class);
            $array_roles = $roleHydrator->fromArrayOfEntities($projectEntity->getRoles())->toArrayOfArrays();

            $array['roles'] = $array_roles;
        }

        return $array;
    }

    /**
     * @param array $projectArray
     * @return ProjectEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $projectArray)
    {
        $entity = (new ProjectEntity())
            ->setName($projectArray['name'])
            ->setSlug($projectArray['slug'])
            ->setCreatorUserId($projectArray['creator_user_id']);

        if(array_key_exists('id', $projectArray) && !empty($projectArray['id'])) {
            $entity->setId($projectArray['id']);
        }

        if(array_key_exists('description', $projectArray) && !empty($projectArray['description'])) {
            $entity->setDescription($projectArray['description']);
        }
        $entity = $this->setCreatorUser($entity, $projectArray);
        $entity = $this->setScopes($entity, $projectArray);
        $entity = $this->setClients($entity, $projectArray);
        $entity = $this->setRoles($entity, $projectArray);

        return $entity;
    }

    /**
     * @param ProjectEntity $entity
     * @param array $projectArray
     * @return ProjectEntity
     */
    private function setCreatorUser(ProjectEntity $entity, array $projectArray)
    {
        if(array_key_exists('creator_user', $projectArray) && !empty($projectArray['creator_user'])) {
            /** @var UserHydrator $userHydrator */
            $userHydrator = resolve(UserHydrator::class);

            if($projectArray['creator_user'] instanceof UserEntity) {
                $entity->setCreatorUser($projectArray['creator_user']);
            }
            elseif (is_array($projectArray['creator_user'])) {
                $entity->setCreatorUser($userHydrator->fromArray($projectArray['creator_user'])->toEntity());
            }
            else {
                throw new \InvalidArgumentException(
                    'creator_user field can be one of UserEntity object or its array representation'
                );
            }
        }

        return $entity;
    }

    /**
     * @param ProjectEntity $entity
     * @param array $projectArray
     * @return ProjectEntity
     */
    private function setScopes(ProjectEntity $entity, array $projectArray)
    {
        if(array_key_exists('scopes', $projectArray) && !empty($projectArray['scopes'])) {
            if(is_array($projectArray['scopes']) && array_key_exists(0, $projectArray['scopes'])) {

                if($projectArray['scopes'][0] instanceof ScopeEntity) {
                    $entity->setScopes($projectArray['scopes']);
                }
                elseif (is_array($projectArray['scopes'][0])) {
                    /** @var ScopeHydrator $scopeHydrator */
                    $scopeHydrator = resolve(ScopeHydrator::class);

                    $entity->setScopes($scopeHydrator->fromArrayOfArrays($projectArray['scopes'])->toArrayOfEntities());
                }
                else {
                    throw new \InvalidArgumentException('scopes should be array of array or ScopeEntity');
                }

            }
            else {
                throw new \InvalidArgumentException('scopes should be array of array or ScopeEntity');
            }
        }

        return $entity;
    }

    /**
     * @param ProjectEntity $entity
     * @param array $projectArray
     * @return ProjectEntity
     */
    private function setClients(ProjectEntity $entity, array $projectArray)
    {
        if(array_key_exists('clients', $projectArray) && !empty($projectArray['clients'])) {
            if(is_array($projectArray['clients']) && array_key_exists(0, $projectArray['clients'])) {

                if($projectArray['clients'][0] instanceof ClientEntity) {
                    $entity->setClients($projectArray['clients']);
                }
                elseif (is_array($projectArray['clients'][0])) {
                    /** @var ClientHydrator $clientHydrator */
                    $clientHydrator = resolve(ClientHydrator::class);

                    $entity->setClients($clientHydrator->fromArrayOfArrays($projectArray['clients'])->toArrayOfEntities());
                }
                else {
                    throw new \InvalidArgumentException('clients should be array of array or ClientEntity');
                }

            }
            else {
                throw new \InvalidArgumentException('clients should be array of array or ClientEntity');
            }
        }

        return $entity;
    }


    /**
     * @param ProjectEntity $entity
     * @param array $projectArray
     * @return ProjectEntity
     * @throws CorruptedDataException
     */
    private function setRoles(ProjectEntity $entity, array $projectArray)
    {
        if(array_key_exists('roles', $projectArray) && !empty($projectArray['roles'])) {
            if(is_array($projectArray['roles']) && array_key_exists(0, $projectArray['roles'])) {

                if($projectArray['roles'][0] instanceof RoleEntity) {
                    $entity->setRoles($projectArray['roles']);
                }
                elseif (is_array($projectArray['roles'][0])) {
                    /** @var RoleHydrator $roleHydrator */
                    $roleHydrator = resolve(RoleHydrator::class);

                    $entity->setRoles($roleHydrator->fromArrayOfArrays($projectArray['roles'])->toArrayOfEntities());
                }
                else {
                    throw new \InvalidArgumentException('roles should be array of array or RoleEntity');
                }

            }
            else {
                throw new \InvalidArgumentException('roles should be array of array or RoleEntity');
            }
        }

        return $entity;
    }

}
