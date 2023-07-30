<?php
namespace App\Http\Controllers\Api\Client;

use App\Actions\Client\DeleteClientAction;
use Illuminate\Http\Response;

/**
 * Class DeleteClientApi
 * @package App\Http\Controllers\Api\Client
 */
class DeleteClientApi
{
    /**
     * @var DeleteClientAction
     */
    private DeleteClientAction $deleteClientAction;

    /**
     * DeleteClientApi constructor.
     * @param DeleteClientAction $deleteClientAction
     */
    public function __construct(DeleteClientAction $deleteClientAction)
    {
        $this->deleteClientAction = $deleteClientAction;
    }

    /**
     * @param int | ClientEntity $client
     * @return Response
     */
    public function __invoke(int $id)
    {
        $this->deleteClientAction->__invoke($id);

        return response()->noContent();
    }

}
