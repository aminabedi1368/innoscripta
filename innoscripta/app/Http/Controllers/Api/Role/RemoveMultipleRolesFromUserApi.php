<?php
namespace App\Http\Controllers\Api\Role;

use App\Exceptions\OneOrMoreRoleWasNotFoundException;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use Illuminate\Http\Response;

/**
 * Class RemoveMultipleRolesFromUserApi
 * @package App\Http\Controllers\Api\Role
 */
class RemoveMultipleRolesFromUserApi
{

    /**
     * @json input : {"user_id": 10, "role_ids": [10,11,12,14]}
     * @return Response
     * @throws OneOrMoreRoleWasNotFoundException
     */
    public function __invoke(): Response
    {
        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail(request('user_id'));

        $roles = RoleModel::query()->whereIn('id', request('role_ids'))->get();

        if(count($roles) != count(request('role_ids'))) {
            throw new OneOrMoreRoleWasNotFoundException;
        }

        UserRoleModel::query()
            ->where('user_id', $user->id)
            ->whereIn('role_id', request('role_ids'))
            ->delete();

        return response()->noContent();
    }

}
