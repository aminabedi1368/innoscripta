<?php
namespace App\Actions\Client;

use App\Entities\ClientEntity;
use App\Repos\ClientRepository;

/**
 * Class UpdateClientAction
 * @package App\Client
 */
class UpdateClientAction
{
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     * UpdateClientAction constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param ClientEntity $clientEntity
     * @return ClientEntity
     */
    public function __invoke(ClientEntity $clientEntity)
    {
        return $this->clientRepository->updateClient($clientEntity);
    }

}
