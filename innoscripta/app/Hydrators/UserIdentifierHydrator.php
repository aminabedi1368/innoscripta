<?php
namespace App\Hydrators;

use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\UserIdentifierModel;
use Carbon\Carbon;

/**
 * Class UserIdentifierHydrator
 * @package App\Hydrators
 */
class UserIdentifierHydrator
{

    /**
     * @var UserIdentifierEntity|null
     */
    private ?UserIdentifierEntity $userIdentifierEntity;

    /**
     * @var UserIdentifierEntity[]|null
     */
    private ?array $entities;

    /**
     * @param array $userArray
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromArray(array $userArray)
    {
        $this->userIdentifierEntity = $this->arrayToEntity($userArray);

        return $this;
    }

    /**
     * @param UserIdentifierEntity $userEntity
     * @return UserIdentifierHydrator
     */
    public function fromEntity(UserIdentifierEntity $userEntity)
    {
        $this->userIdentifierEntity = $userEntity;

        return $this;
    }

    /**
     * @param UserIdentifierModel $userIdentifierModel
     * @return UserIdentifierHydrator
     * @throws CorruptedDataException
     */
    public function fromModel(UserIdentifierModel $userIdentifierModel)
    {
        $this->userIdentifierEntity = $this->modelToEntity($userIdentifierModel);

        return $this;
    }

    /**
     * @return UserIdentifierEntity|null
     */
    public function toEntity()
    {
        return $this->userIdentifierEntity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityToArray($this->userIdentifierEntity);
    }

    /**
     * @param UserIdentifierEntity $userEntity
     * @return UserIdentifierModel
     */
    private function entityToModel(UserIdentifierEntity $userEntity)
    {
        return (new UserIdentifierModel())->fill(
            $this->entityToArray($userEntity)
        );
    }


    /**
     * @param UserIdentifierModel $userIdentifierModel
     * @return UserIdentifierEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(UserIdentifierModel $userIdentifierModel)
    {
        $array = $userIdentifierModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param UserIdentifierEntity $userIdentifierEntity
     * @return array
     */
    private function entityToArray(UserIdentifierEntity $userIdentifierEntity)
    {
        $array = [
            'type' => $userIdentifierEntity->getType(),
            'value' => $userIdentifierEntity->getValue(),
            'user_id' => $userIdentifierEntity->getUserId(),
            'is_verified' => $userIdentifierEntity->isVerified()
        ];

        if($userIdentifierEntity->isPersisted()) {
            $array['id'] = $userIdentifierEntity->getId();
            $array['created_at'] = $userIdentifierEntity->getCreatedAt();
            $array['updated_at'] = $userIdentifierEntity->getUpdatedAt();
        }

        if($userIdentifierEntity->isUserEntityLoaded()) {
            /** @var UserHydrator $userHydrator */
            $userHydrator = resolve(UserHydrator::class);

            $array['user'] = $userHydrator->fromEntity($userIdentifierEntity->getUserEntity())->toArray();
        }

        return $array;
    }

    /**
     * @param array $array
     * @return UserIdentifierEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $array)
    {
        $entity = (new UserIdentifierEntity())
            ->setType($array['type'])
            ->setValue($array['value'])
            ->setUserId($array['user_id']);

        if(array_key_exists('id', $array) && !empty($array['id'])) {
            $entity->setId($array['id']);
        }

        if(array_key_exists('is_verified', $array) && !empty($array['is_verified'])) {
            $entity->setIsVerified($array['is_verified']);
        }
        else {
            $entity->setIsVerified(false);
        }

        if(array_key_exists('created_at', $array) && !empty($array['created_at'])) {
            $entity->setCreatedAt(Carbon::parse($array['created_at']));
        }
        if(array_key_exists('updated_at', $array) && !empty($array['updated_at'])) {
            $entity->setUpdatedAt(Carbon::parse($array['updated_at']));
        }
        $entity->setUserEntity($this->extractUserEntityFromArray($array));

        return $entity;
    }

    /**
     * @param array $array
     * @return UserEntity|null
     * @throws CorruptedDataException]
     */
    private function extractUserEntityFromArray(array $array)
    {
        if(
            array_key_exists('user', $array) &&
            !empty($array['user'])
        ) {

            if($array['user'] instanceof UserEntity) {
                return $array['user'];
            }
            elseif (is_array($array['user'])) {
                /** @var UserHydrator $userHydrator */
                $userHydrator = resolve(UserHydrator::class);
                return $userHydrator->fromArray($array['user'])->toEntity();
            }
            else {
                throw new CorruptedDataException;
            }
        }

        return null;
    }

    /**
     * @param UserIdentifierModel[] $models
     * @return UserIdentifierHydrator
     * @throws CorruptedDataException
     */
    public function fromArrayOfModels(array $models)
    {
        $entities = [];

        foreach ($models as $model) {
            $entities[] = $this->modelToEntity($model);
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @param array $arrays
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromArrayOfArrays(array $arrays)
    {
        $entities = [];

        foreach ($arrays as $array) {
            $entities[] = $this->arrayToEntity($array);
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @param UserIdentifierEntity[] $entities
     * @return $this
     */
    public function fromArrayOfEntities(array $entities)
    {
        $this->entities = $entities;

        return $this;
    }

    /**
     * @return UserIdentifierEntity[]
     */
    public function toArrayOfEntities()
    {
        return $this->entities;
    }

    /**
     * @return UserIdentifierModel[]
     */
    public function toArrayOfModels()
    {
        $ret = [];

        foreach ($this->entities as $entity) {
            $ret[] =$this->entityToModel($entity);
        }

        return $ret;
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


}
