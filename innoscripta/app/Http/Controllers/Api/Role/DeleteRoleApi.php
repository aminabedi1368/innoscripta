<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\DeleteRoleAction;
use App\Exceptions\Role\CantDeleteRoleWithRelationsException;
use Illuminate\Http\Response;

/**
 * Class DeleteRoleApi
 * @package App\Http\Controllers\Api
 */
class DeleteRoleApi
{
    /**
     * @var DeleteRoleAction
     */
    private DeleteRoleAction $deleteRoleAction;

    /**
     * DeleteRoleApi constructor.
     * @param DeleteRoleAction $deleteRoleAction
     */
    public function __construct(DeleteRoleAction $deleteRoleAction)
    {
        $this->deleteRoleAction = $deleteRoleAction;
    }

    /**
     * @param int $id
     * @return Response
     * @throws CantDeleteRoleWithRelationsException
     */
    public function __invoke(int $id)
    {
        $this->deleteRoleAction->__invoke($id);

        return response()->noContent();
    }


}
