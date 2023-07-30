<?php
namespace App\Hydrators;

use App\Entities\ClientEntity;
use App\Models\ClientModel;

/**
 * Class ClientHydrator
 * @package App\Hydrators
 */
class ClientHydrator
{

    /**
     * @var ClientEntity|null
     */
    private ?ClientEntity $clientEntity;

    /**
     * @var ClientEntity[]|null
     */
    private ?array $entities;

    /**
     * @param array $clientArray
     * @return $this
     */
    public function fromArray(array $clientArray)
    {
        $this->clientEntity = $this->arrayToEntity($clientArray);

        return $this;
    }

    /**
     * @param ClientEntity $clientEntity
     * @return ClientHydrator
     */
    public function fromEntity(ClientEntity $clientEntity)
    {
        $this->clientEntity = $clientEntity;

        return $this;
    }

    /**
     * @param ClientModel $clientModel
     * @return $this
     */
    public function fromModel(ClientModel $clientModel)
    {
        $this->clientEntity = $this->modelToEntity($clientModel);

        return $this;
    }

    /**
     * @return ClientEntity|null
     */
    public function toEntity()
    {
        return $this->clientEntity;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->entityToArray($this->clientEntity);
    }

    /**
     * @param array $entities
     * @return $this
     */
    public function fromArrayOfEntities(array $entities)
    {
        foreach ($entities as $entity) {
            if(!$entity instanceof ClientEntity) {
                throw new \InvalidArgumentException('entities should be instance of ClientEntity Class');
            }
        }

        $this->entities = $entities;

        return $this;
    }

    /**
     * @return array
     */
    public function toArrayOfArrays()
    {
        $res = [];

        foreach ($this->entities as $entity) {
            $res[] = $this->entityToArray($entity);
        }

        return $res;
    }

    /**
     * @param array $clients
     * @return $this
     */
    public function fromArrayOfArrays(array $clients)
    {
        $entities = [];

        foreach ($clients as $array) {
            if(! is_array($array)) {
                throw new \InvalidArgumentException('each array item should be a client array representation');
            }
            $entities[] = $this->arrayToEntity($array);
        }

        $this->entities = $entities;
        return $this;
    }

    /**
     * @return ClientEntity[]|null
     */
    public function toArrayOfEntities()
    {
        return $this->entities;
    }

    /**
     * @param ClientEntity $clientEntity
     * @return ClientModel
     */
    private function entityToModel(ClientEntity $clientEntity)
    {
        return (new ClientModel())->fill(
            $this->entityToArray($clientEntity)
        );
    }


    /**
     * @param ClientModel $clientModel
     * @return ClientEntity
     */
    private function modelToEntity(ClientModel $clientModel)
    {
        $array = $clientModel->toArray();

        return $this->arrayToEntity($array);
    }

    /**
     * @param ClientEntity $clientEntity
     * @return array
     */
    private function entityToArray(ClientEntity $clientEntity)
    {
        $array = [
            'name' => $clientEntity->getName(),
            'slug' => $clientEntity->getSlug(),
            'type' => $clientEntity->getType(),
            'project_id' => $clientEntity->getProjectId(),
            'is_active' => $clientEntity->isActive(),
            'client_id' => $clientEntity->getClientId(),
            'client_secret' => $clientEntity->getClientSecret(),
            'oauth_client_type' => $clientEntity->getOauthClientType()
        ];

        if($clientEntity->hasId()) {
            $array['id'] = $clientEntity->getId();
        }
        if($clientEntity->hasRedirectUrl()) {
            $array['redirect_urls'] = $clientEntity->getRedirectUrls();
        }
        return $array;
    }

    /**
     * @param array $clientArray
     * @return ClientEntity
     */
    private function arrayToEntity(array $clientArray)
    {
        $entity = (new ClientEntity())
            ->setName($clientArray['name'])
            ->setSlug($clientArray['slug'])
            ->setType($clientArray['type'])
            ->setProjectId($clientArray['project_id'])
            ->setOauthClientType($clientArray['oauth_client_type']);

        if(array_key_exists('is_active', $clientArray) ) {
            $entity->setIsActive($clientArray['is_active']);
        }
        else {
            $entity->setIsActive(false);
        }

        if(array_key_exists('client_id', $clientArray) ) {
            $entity->setClientId($clientArray['client_id']);
        }

        if(array_key_exists('client_secret', $clientArray) ) {
            $entity->setClientSecret($clientArray['client_secret']);
        }

        if(array_key_exists('id', $clientArray) && !empty($clientArray['id'])) {
            $entity->setId($clientArray['id']);
        }
        if(array_key_exists('redirect_urls', $clientArray) && !empty($clientArray['redirect_urls'])) {
            $entity->setRedirectUrls($clientArray['redirect_urls']);
        }
        return $entity;
    }

}
