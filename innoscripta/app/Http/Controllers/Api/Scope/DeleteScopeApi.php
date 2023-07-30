<?php
namespace App\Http\Controllers\Api\Scope;

use App\Actions\Scope\DeleteScopeAction;
use Illuminate\Http\Response;

/**
 * Class DeleteScopeApi
 * @package App\Http\Controllers\Api\Scope
 */
class DeleteScopeApi
{

    /**
     * @var DeleteScopeAction
     */
    private DeleteScopeAction $deleteScopeAction;

    /**
     * DeleteScopeApi constructor.
     * @param DeleteScopeAction $deleteScopeAction
     */
    public function __construct(DeleteScopeAction $deleteScopeAction)
    {
        $this->deleteScopeAction = $deleteScopeAction;
    }


    /**
     * @param integer $id
     * @return Response
     */
    public function __invoke(int $id)
    {
        $this->deleteScopeAction->__invoke($id);

        return response()->noContent();
    }

}
