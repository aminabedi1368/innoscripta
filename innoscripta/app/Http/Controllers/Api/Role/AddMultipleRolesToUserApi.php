<?php
namespace App\Http\Controllers\Api\Role;

use App\Exceptions\OneOrMoreRoleWasNotFoundException;
use App\Exceptions\UserRoleRelationAlreadyExistsException;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

/**
 * Class AddMultipleRolesToUserApi
 * @package App\Http\Controllers\Api\Role
 */
class AddMultipleRolesToUserApi
{

    /**
     * @json input : {"user_id": 10, "role_ids": [10,11,12,14]}
     * @throws OneOrMoreRoleWasNotFoundException
     * @throws UserRoleRelationAlreadyExistsException
     */
    public function __invoke(): Response
    {
        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail(request('user_id'));

        $roles = RoleModel::query()->whereIn('id', request('role_ids'))->get();

        if(count($roles) != count(request('role_ids'))) {
            throw new OneOrMoreRoleWasNotFoundException;
        }

        try {
            $user->roles()->attach(request('role_ids'));
        }
        catch (QueryException $e) {

            if(str_contains($e->getMessage(), 'Duplicate')) {
                throw new UserRoleRelationAlreadyExistsException;
            }

        }

        return response()->noContent();
    }

}
