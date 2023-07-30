<?php
namespace App\Http\Controllers\Api\Client;

use App\Hydrators\ClientHydrator;
use App\Repos\ClientRepository;
use Illuminate\Http\JsonResponse;

/**
 * ListClientByProjectIdApi
 */
class ListClientByProjectIdApi
{

    /**
     * ClientRepository
     */
    private ClientRepository $clientRepository;


    /**
     * ClientHydrator
     */
    private ClientHydrator $clientHydrator;

    /**
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository, ClientHydrator $clientHydrator)
    {
        $this->clientRepository = $clientRepository;
        $this->clientHydrator = $clientHydrator;

    }


    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $clients = $this->clientRepository->listClientsByProjectId($id);

        return response()->json($this->clientHydrator->fromArrayOfEntities($clients)->toArrayOfArrays());
    }

}
