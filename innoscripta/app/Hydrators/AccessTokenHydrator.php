<?php
namespace App\Hydrators;

use App\Entities\AccessTokenEntity;
use App\Entities\ClientEntity;
use App\Entities\ScopeEntity;
use App\Entities\UserEntity;
use App\Entities\UserIdentifierEntity;
use App\Exceptions\CorruptedDataException;
use App\Models\AccessTokenModel;
use Carbon\Carbon;

/**
 * Class AccessTokenHydrator
 * @package App\Hydrators
 */
class AccessTokenHydrator
{

    /**
     * @var AccessTokenEntity|null
     */
    private ?AccessTokenEntity $accessTokenEntity;


    /**
     * @param array $array
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromArray(array $array)
    {
        $this->accessTokenEntity = $this->arrayToEntity($array);

        return $this;
    }

    /**
     * @param AccessTokenEntity $AccessTokenEntity
     * @return AccessTokenHydrator
     */
    public function fromEntity(AccessTokenEntity $AccessTokenEntity)
    {
        $this->accessTokenEntity = $AccessTokenEntity;

        return $this;
    }

    /**
     * @param AccessTokenModel $accessTokenModel
     * @return $this
     * @throws CorruptedDataException
     */
    public function fromModel(AccessTokenModel $accessTokenModel)
    {
        $this->accessTokenEntity = $this->modelToEntity($accessTokenModel);

        return $this;
    }

    /**
     * @return AccessTokenEntity|null
     */
    public function toEntity()
    {
        return $this->accessTokenEntity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityToArray($this->accessTokenEntity);
    }

    /**
     * @param AccessTokenEntity $AccessTokenEntity
     * @return AccessTokenModel
     */
    private function entityToModel(AccessTokenEntity $AccessTokenEntity)
    {
        return (new AccessTokenModel())->fill(
            $this->entityToArray($AccessTokenEntity)
        );
    }


    /**
     * @param AccessTokenModel $accessTokenModel
     * @return AccessTokenEntity
     * @throws CorruptedDataException
     */
    private function modelToEntity(AccessTokenModel $accessTokenModel)
    {
        $array = $accessTokenModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param AccessTokenEntity $accessTokenEntity
     * @return array
     */
    private function entityToArray(AccessTokenEntity $accessTokenEntity)
    {
        $array = [
            'client_id' => $accessTokenEntity->getClientEntity(),
            'is_revoked' => $accessTokenEntity->isRevoked(),
            'device_os' => $accessTokenEntity->getDeviceOs(),
            'device_type' => $accessTokenEntity->getDeviceType(),
            'details' => $accessTokenEntity->getDetails(),
            'expires_at' => $accessTokenEntity->getExpiresAt(),
            'user_id'=> $accessTokenEntity->getUserId(),
            'user_identifier_id' => $accessTokenEntity->getUserIdentifierId()
        ];
        if($accessTokenEntity->hasId()) {
            $array['id'] = $accessTokenEntity->getId();
            $array['created_at'] = $accessTokenEntity->getCreatedAt();
            $array['updated_at'] = $accessTokenEntity->getUpdatedAt();
        }

        return $array;
    }

    /**
     * @param array $array
     * @return AccessTokenEntity
     * @throws CorruptedDataException
     */
    private function arrayToEntity(array $array)
    {
        $entity = (new AccessTokenEntity())
            ->setClientId($array['client_id'])
            ->setIsRevoked($array['is_revoked'])
            ->setDeviceOs($array['device_os'])
            ->setDeviceType($array['device_type'])
            ->setDetails($array['details'])
            ->setExpiresAt(Carbon::parse($array['expires_at']))
            ->setUserId($array['user_id']);

        if(array_key_exists('user_identifier_id', $array) && !empty($array['user_identifier_id'])) {
            $entity->setUserIdentifierId($array['user_identifier_id']);
        }
        elseif (array_key_exists('user_identifier', $array) && !empty($array['user_identifier'])) {
            $entity->setUserIdentifierId($array['user_identifier']['id']);
        }

        if(array_key_exists('id', $array) && !empty($array['id'])) {
            $entity->setId($array['id']);
        }
        if(array_key_exists('created_at', $array) && !empty($array['created_at'])) {
            $entity->setCreatedAt(Carbon::parse($array['created_at']));
        }
        if(array_key_exists('updated_at', $array) && !empty($array['updated_at'])) {
            $entity->setUpdatedAt(Carbon::parse($array['updated_at']));
        }
        $entity->setClientEntity($this->extractClientEntityFromArray($array));
        $entity->setUserEntity($this->extractUserEntityFromArray($array));
        $entity->setUserIdentifierEntity($this->extractUserIdentifierEntityFromArray($array));
        $entity->setScopes($this->extractScopeEntitiesFromArray($array));



        return $entity;
    }

    /**
     * @param array $array
     * @return ClientEntity|null
     * @throws CorruptedDataException
     */
    private function extractClientEntityFromArray(array $array)
    {
        if(
            array_key_exists('client', $array) &&
            !empty($array['client'])
        ) {
            if($array['client'] instanceof ClientEntity) {
                return $array['client'];
            }
            elseif (is_array($array['client'])) {
                /** @var ClientHydrator $clientHydrator */
                $clientHydrator = resolve(ClientHydrator::class);
                return $clientHydrator->fromArray($array['client'])->toEntity();
            }
            else {
                throw new CorruptedDataException;
            }
        }

        return null;
    }

    /**
     * @param array $array
     * @return UserEntity|null
     * @throws CorruptedDataException
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
     * @param array $array
     * @return null|ScopeEntity[]
     * @throws CorruptedDataException
     */
    private function extractScopeEntitiesFromArray(array $array)
    {
        if(
            array_key_exists('scopes', $array) &&
            !empty($array['scopes'])
        ) {
            /** @var ScopeHydrator $scopeHydrator */
            $scopeHydrator = resolve(ScopeHydrator::class);

            $scope_entities = [];

            foreach ($array['scopes'] as $scope) {
                if($scope instanceof ScopeEntity) {
                    $scope_entities[] = $scope;
                }
                elseif (is_array($scope)) {
                    $scope_entities[] = $scopeHydrator->fromArray($scope)->toEntity();
                }
                else {
                    throw new CorruptedDataException;
                }
            }

            return $scope_entities;
        }

        return null;
    }

    /**
     * @param array $array
     * @return UserIdentifierEntity|null
     * @throws CorruptedDataException
     */
    private function extractUserIdentifierEntityFromArray(array $array)
    {
        if(
            array_key_exists('user_identifier', $array) &&
            !empty($array['user_identifier'])
        ) {
            if($array['user_identifier'] instanceof UserIdentifierEntity) {
                return $array['user_identifier'];
            }
            elseif (is_array($array['user_identifier'])) {
                /** @var UserIdentifierHydrator $userIdentifierHydrator */
                $userIdentifierHydrator = resolve(UserIdentifierHydrator::class);
                return $userIdentifierHydrator->fromArray($array['user_identifier'])->toEntity();
            }
            else {
                throw new CorruptedDataException;
            }
        }

        return null;
    }

}
