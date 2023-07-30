<?php
namespace App\Actions\Client;

use App\Lib\ListView\ListCriteria;
use App\Lib\ListView\PaginatedEntityList;
use App\Repos\ClientRepository;

/**
 * Class ListClientAction
 * @package App\Client
 */
class ListClientAction
{
    /**
     * @var ClientRepository
     */
    private ClientRepository $clientRepository;

    /**
     * ListClientAction constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param ListCriteria $listCriteria
     * @return PaginatedEntityList
     */
    public function __invoke(ListCriteria $listCriteria)
    {
        return $this->clientRepository->listClients($listCriteria);
    }

}
