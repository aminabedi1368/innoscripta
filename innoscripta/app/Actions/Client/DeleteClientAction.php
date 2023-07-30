<?php
namespace App\Actions\Client;

use App\Repos\ClientRepository;

/**
 * Class DeleteClientAction
 * @package App\Client
 */
class DeleteClientAction
{

    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     *
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param integer $id
     * @return void
     */
    public function __invoke(int $id)
    {
        $this->clientRepository->deleteById($id);
    }

}
