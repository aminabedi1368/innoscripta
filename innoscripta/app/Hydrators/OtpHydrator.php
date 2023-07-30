<?php
namespace App\Hydrators;

use App\Entities\OtpEntity;
use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\OtpModel;
use Carbon\Carbon;

/**
 * Class ProjectHydrator
 * @package App\Hydrators
 */
class OtpHydrator
{
    /**
     * @var OtpEntity|null
     */
    private ?OtpEntity $entity;


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
     * @param OtpEntity $OtpEntity
     * @return OtpHydrator
     */
    public function fromEntity(OtpEntity $OtpEntity)
    {
        $this->entity = $OtpEntity;

        return $this;
    }

    /**
     * @param OtpModel $OtpModel
     * @return $this
     */
    public function fromModel(OtpModel $OtpModel)
    {
        $this->entity = $this->modelToEntity($OtpModel);

        return $this;
    }

    /**
     * @return OtpEntity|null
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
     * @param OtpEntity $entity
     * @return OtpModel
     */
    private function entityToModel(OtpEntity $entity)
    {
        return (new OtpModel())->fill(
            $this->entityToArray($entity)
        );
    }


    /**
     * @param OtpModel $model
     * @return OtpEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(OtpModel $model)
    {
        $array = $model->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param OtpEntity $entity
     * @return array
     */
    private function entityToArray(OtpEntity $entity)
    {
        $array = [
            'user_identifier_id' => $entity->getUserIdentifierId(),
            'user_id' => $entity->getUserId(),
            'code' => $entity->getCode(),
        ];

        if($entity->hasId()) {
            $array['id'] = $entity->getId();
        }

        if($entity->isUserEntityLoaded()) {

            /** @var UserHydrator $userHydrator */
            $userHydrator = resolve(UserHydrator::class);

            $array['user'] = $userHydrator->fromEntity($entity->getUser())->toArray();
        }

        if($entity->isUserIdentifierEntityLoaded()) {

            /** @var UserIdentifierHydrator $userIdentifierHydrator */
            $userIdentifierHydrator = resolve(UserIdentifierHydrator::class);

            $array['user_identifier'] = $userIdentifierHydrator->fromEntity($entity->getUserIdentifier())->toArray();
        }

        return $array;
    }

    /**
     * @param array $array
     * @return OtpEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $array)
    {
        $entity = (new OtpEntity())
            ->setCode($array['code'])
            ->setUserId($array['user_id'])
            ->setExpiresAt(Carbon::parse($array['expires_at']))
            ->setUserIdentifierId($array['user_identifier_id']);

        if(array_key_exists('id', $array) && !empty($array['id'])) {
            $entity->setId($array['id']);
        }

        if(array_key_exists('user', $array) && !empty($array['user'])) {

            /** @var UserHydrator $userHydrator */
            $userHydrator = resolve(UserHydrator::class);


            if($array['user'] instanceof UserEntity) {
                $entity->setUser($array['user']);
            }
            elseif (is_array($array['user'])) {
                $entity->setUser($userHydrator->fromArray($array['user'])->toEntity());
            }
            else {
                throw new CorruptedDataException;
            }
        }

        if(array_key_exists('user_identifier', $array) && !empty($array['user_identifier'])) {
            /** @var UserIdentifierHydrator $userIdentifierHydrator */
            $userIdentifierHydrator = resolve(UserIdentifierHydrator::class);

            if($array['user_identifier'] instanceof UserIdentifierEntity) {
                $entity->setUserIdentifier($array['user_identifier']);
            }
            elseif (is_array($array['user_identifier'])) {
                $entity->setUserIdentifier($userIdentifierHydrator->fromArray($array['user_identifier'])->toEntity());
            }
            else {
                throw new CorruptedDataException;
            }
        }

        return $entity;
    }

}
