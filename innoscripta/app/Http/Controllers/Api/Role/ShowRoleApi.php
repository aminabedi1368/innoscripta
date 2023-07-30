<?php
namespace App\Http\Controllers\Api\Role;

use App\Actions\Role\ShowSingleRoleAction;
use App\Hydrators\RoleHydrator;
use Illuminate\Http\JsonResponse;

/**
 * Class ShowRoleApi
 * @package App\Http\Controllers\Api
 */
class ShowRoleApi
{
    /**
     * @var ShowSingleRoleAction
     */
    private ShowSingleRoleAction $showSingleRowAction;
    /**
     * @var RoleHydrator
     */
    private RoleHydrator $roleHydrator;

    /**
     * ShowRoleApi constructor.
     * @param ShowSingleRoleAction $showSingleRowAction
     * @param RoleHydrator $roleHydrator
     */
    public function __construct(ShowSingleRoleAction $showSingleRowAction, RoleHydrator $roleHydrator)
    {
        $this->showSingleRowAction = $showSingleRowAction;
        $this->roleHydrator = $roleHydrator;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $roleEntity = $this->showSingleRowAction->__invoke($id);

        return response()->json($this->roleHydrator->fromEntity($roleEntity)->toArray());
    }


}
