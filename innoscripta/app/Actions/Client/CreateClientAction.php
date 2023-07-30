<?php
namespace App\Actions\Client;

use App\Entities\ClientEntity;
use App\Repos\ClientRepository;
use Illuminate\Support\Str;

/**
 * Class CreateClientAction
 * @package App\Client
 */
class CreateClientAction
{

    /**
     * @param ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }


    /**
     *
     * @param ClientEntity $clientEntity
     * @return ClientEntity
     */
    public function __invoke(ClientEntity $clientEntity)
    {
        if(!$clientEntity->hasClientId()) {
            $clientEntity->setClientId(Str::random(20));
            $clientEntity->setClientSecret(Str::random(20));
        }
        return $this->clientRepository->insertClient($clientEntity);
    }
}
