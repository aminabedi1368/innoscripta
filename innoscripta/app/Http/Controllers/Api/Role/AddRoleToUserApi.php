<?php
namespace App\Http\Controllers\Api\Role;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

/**
 * Class AddRoleToUserApi
 * @package App\Http\Controllers\Api\Role
 */
class AddRoleToUserApi
{

    /**
     * @json input : {"user_id": 10, "role_id": 12}
     */
    public function __invoke(): Response
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail(request('role_id'));

        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail(request('user_id'));

        $relationExists = UserRoleModel::query()
                        ->where('role_id', $role->id)
                        ->where('user_id', $user->id)
                        ->exists();

        if(!$relationExists) {
            UserRoleModel::query()->create(['role_id' => $role->id, 'user_id' => $user->id]);
        }

        return response()->noContent();
    }

}
