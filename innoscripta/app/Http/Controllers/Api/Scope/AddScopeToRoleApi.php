<?php
namespace App\Http\Controllers\Api\Scope;

use App\Models\RoleModel;
use App\Models\RoleScopeModel;
use App\Models\ScopeModel;
use Illuminate\Http\Response;

/**
 * Class AddScopeToRoleApi
 * @package App\Http\Controllers\Api\Role
 */
class AddScopeToRoleApi
{

    /**
     * @json input : {"scope_id": 10, "role_id": 12}
     */
    public function __invoke(): Response
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail(request('role_id'));

        /** @var ScopeModel $scope */
        $scope = ScopeModel::query()->findOrFail(request('scope_id'));

        RoleScopeModel::query()->create(['role_id' => $role->id, 'scope_id' => $scope->id]);

        return response()->noContent();
    }

}
