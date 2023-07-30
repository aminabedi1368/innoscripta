<?php
namespace App\Hydrators;

use App\Entities\SettingEntity;
use App\Models\SettingModel;

/**
 * Class SettingHydrator
 * @package App\Hydrators
 */
class SettingHydrator
{

    /**
     * @var SettingEntity|null
     */
    private ?SettingEntity $entity;

    /**
     * @var array|null
     */
    private ?array $entities;

    /**
     * @param array $array
     * @return $this
     */
    public function fromArray(array $array)
    {
        $this->entity = $this->arrayToEntity($array);

        return $this;
    }

    /**
     * @param SettingEntity $entity
     * @return SettingHydrator
     */
    public function fromEntity(SettingEntity $entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * @param SettingModel $model
     * @return $this
     */
    public function fromModel(SettingModel $model)
    {
        $this->entity = $this->modelToEntity($model);

        return $this;
    }

    /**
     * @return SettingEntity|null
     */
    public function toEntity()
    {
        return $this->entity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityToArray($this->entity);
    }


    /**
     * @param SettingEntity $entity
     * @return SettingModel
     */
    private function entityToModel(SettingEntity $entity)
    {
        return (new SettingModel())->fill(
            $this->entityToArray($entity)
        );
    }


    /**
     * @param SettingModel $model
     * @return SettingEntity
     */
    private function modelToEntity(SettingModel $model)
    {
        $array = $model->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param SettingEntity $entity
     * @return array
     */
    private function entityToArray(SettingEntity $entity)
    {
        $array = [
            'key' => $entity->getKey(),
            'value' => $entity->getValue(),
        ];

        if($entity->hasId()) {
            $array['id'] = $entity->getId();
        }

        return $array;
    }

    /**
     * @param array $array
     * @return SettingEntity
     */
    private function arrayToEntity(array $array)
    {
        $entity = (new SettingEntity())
            ->setKey($array['key'])
            ->setValue($array['value']);

        if(array_key_exists('id', $array) && !empty($array['id'])) {
            $entity->setId($array['id']);
        }

        return $entity;
    }


    /**
     * @param SettingModel[] $listSettingModels
     * @return SettingHydrator
     */
    public function fromArrayOfModels(array $listSettingModels)
    {
        $array = [];

        foreach ($listSettingModels as $model) {
            $array[] = $this->modelToEntity($model);
        }

        $this->entities = $array;

        return $this;
    }


    /**
     * @param array $entities
     * @return SettingHydrator
     */
    public function fromArrayOfEntities(array $entities)
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function fromArrayOfArrays(array $data)
    {
        $array = [];

        foreach ($data as $array) {
            $array[] = $this->arrayToEntity($array);
        }

        $this->entities = $array;

        return $this;
    }

    /**
     * @return array
     */
    public function toArrayOfArrays()
    {
        $ret = [];

        foreach ($this->entities as $entity) {
            $ret[] = $this->entityToArray($entity);
        }

        return $ret;
    }

    /**
     * @return array|null
     */
    public function toArrayOfEntities()
    {
        return $this->entities;
    }

    /**
     * @return array
     */
    public function toArrayOfModels()
    {
        $ret = [];

        foreach ($this->entities as $entity) {
            $ret[] = $this->entityToModel($entity);
        }

        return $ret;
    }

}
