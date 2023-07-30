<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\ShowClientAction;
use App\Hydrators\ClientHydrator;
use Illuminate\Http\JsonResponse;

/**
 * Class ShowClientApi
 * @package App\Http\Controllers\Api\Client
 */
class ShowClientApi
{
    /**
     * @var ShowClientAction
     */
    private ShowClientAction $showClientAction;

    /**
     * @var ClientHydrator
     */
    private ClientHydrator $clientHydrator;

    /**
     * ShowClientApi constructor.
     * @param ShowClientAction $showClientAction
     * @param ClientHydrator $clientHydrator
     */
    public function __construct(ShowClientAction $showClientAction, ClientHydrator $clientHydrator)
    {
        $this->showClientAction = $showClientAction;
        $this->clientHydrator = $clientHydrator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id)
    {
        $client = $this->showClientAction->__invoke($id);

        return response()->json($this->clientHydrator->fromEntity($client)->toArray());
    }

}
