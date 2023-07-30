<?php
namespace App\Actions\Client;

use App\Entities\ClientEntity;
use App\Repos\ClientRepository;

/**
 * Class ShowClientAction
 * @package App\Actions\Client
 */
class ShowClientAction
{
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     * ShowClientAction constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param int $client_id
     * @return ClientEntity
     */
    public function __invoke(int $client_id)
    {
        return $this->clientRepository->findClientById($client_id);
    }

}
