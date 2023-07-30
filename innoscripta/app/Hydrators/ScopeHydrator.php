<?php
namespace App\Hydrators;

use App\Entities\ProjectEntity;
use App\Entities\ScopeEntity;
use App\Models\ScopeModel;

/**
 * Class ScopeHydrator
 * @package App\Hydrators
 */
class ScopeHydrator
{

    /**
     * @var ScopeEntity|null
     */
    private ?ScopeEntity $scopeEntity;

    /**
     * @var ScopeEntity[]|null
     */
    private ?array $entities;

    /**
     * @param array $scopeArray
     * @return $this
     */
    public function fromArray(array $scopeArray): ScopeHydrator
    {
        $this->scopeEntity = $this->arrayToEntity($scopeArray);

        return $this;
    }

    /**
     * @param ScopeEntity $scopeEntity
     * @return ScopeHydrator
     */
    public function fromEntity(ScopeEntity $scopeEntity): ScopeHydrator
    {
        $this->scopeEntity = $scopeEntity;

        return $this;
    }

    /**
     * @param ScopeModel $scopeModel
     * @return $this
     */
    public function fromModel(ScopeModel $scopeModel): ScopeHydrator
    {
        $this->scopeEntity = $this->modelToEntity($scopeModel);

        return $this;
    }

    /**
     * @return ScopeEntity|null
     */
    public function toEntity(): ?ScopeEntity
    {
        return $this->scopeEntity;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->entityToArray($this->scopeEntity);
    }

    /**
     * @param array $entities
     * @return $this
     */
    public function fromArrayOfEntities(array $entities): ScopeHydrator
    {
        foreach ($entities as $entity) {
            if(!$entity instanceof ScopeEntity) {
                throw new \InvalidArgumentException('entities should be instance of ScopeEntity Class');
            }
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @param array $arrays
     * @return $this
     */
    public function fromArrayOfArrays(array $arrays): ScopeHydrator
    {
        $entities = [];

        foreach ($arrays as $array) {
            if(!is_array($array)) {
                throw new \InvalidArgumentException('each array item should be a scope array itself');
            }
            $entities[] = $this->arrayToEntity($array);
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
     * @return ScopeEntity[]|null
     */
    public function toArrayOfEntities(): ?array
    {
        return $this->entities;
    }

    /**
     * @param ScopeEntity $scopeEntity
     * @return ScopeModel
     */
    private function entityToModel(ScopeEntity $scopeEntity): ScopeModel
    {
        return (new ScopeModel())->fill(
            $this->entityToArray($scopeEntity)
        );
    }


    /**
     * @param ScopeModel $scopeModel
     * @return ScopeEntity
     */
    private function modelToEntity(ScopeModel $scopeModel): ScopeEntity
    {
        $array = $scopeModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param ScopeEntity $scopeEntity
     * @return array
     */
    private function entityToArray(ScopeEntity $scopeEntity): array
    {
        $array = [
            'name' => $scopeEntity->getName(),
            'slug' => $scopeEntity->getSlug(),
            'project_id' => $scopeEntity->getProjectId()
        ];

        if($scopeEntity->hasProject()) {
            $array['project'] = (new ProjectHydrator())->fromEntity($scopeEntity->getProjectEntity())->toArray();
        }

        if($scopeEntity->hasDescription()) {
            $array['description'] = $scopeEntity->getDescription();
        }

        if($scopeEntity->hasId()) {
            $array['id'] = $scopeEntity->getId();
        }

        return $array;
    }

    /**
     * @param array $scopeArray
     * @return ScopeEntity
     */
    private function arrayToEntity(array $scopeArray): ScopeEntity
    {
        $entity = (new ScopeEntity())
            ->setName($scopeArray['name'])
            ->setSlug($scopeArray['slug'])
            ->setProjectId($scopeArray['project_id'])
            ->setDescription($scopeArray['description']);

        if(array_key_exists('id', $scopeArray) && !empty($scopeArray['id'])) {
            $entity->setId($scopeArray['id']);
        }

        if(array_key_exists('project', $scopeArray) && !empty($scopeArray['project'])) {

            $projectEntity = null;
            if(is_array($scopeArray['project'])) {
                $projectEntity = (new ProjectHydrator())->fromArray($scopeArray['project'])->toEntity();
            }
            elseif ($scopeArray['project'] instanceof ProjectEntity) {
                $projectEntity = $scopeArray['project'];
            }

            $entity->setProjectEntity($projectEntity);
        }

        return $entity;
    }

}
