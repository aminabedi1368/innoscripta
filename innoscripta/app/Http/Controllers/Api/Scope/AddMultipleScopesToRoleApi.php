<?php
namespace App\Http\Controllers\Api\Scope;

use App\Exceptions\OneOrMoreScopeWasNotFoundException;
use App\Exceptions\RoleScopeRelationAlreadyExistsException;
use App\Models\RoleModel;
use App\Models\ScopeModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;

/**
 * Class AddMultipleScopesToRoleApi
 * @package App\Http\Controllers\Api\Role
 */
class AddMultipleScopesToRoleApi
{

    /**
     * @json input : {"scope_ids": [10,12,13,15,17], "role_id": 12}
     * @throws OneOrMoreScopeWasNotFoundException
     * @throws RoleScopeRelationAlreadyExistsException
     */
    public function __invoke(): Response
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail(request('role_id'));

        $scopes = ScopeModel::query()->whereIn('id', request('scope_ids'))->get();

        if($scopes->count() != count(request('scope_ids'))) {
            throw new OneOrMoreScopeWasNotFoundException;
        }

        try {
            $role->scopes()->attach(request('scope_ids'));
        }
        catch (QueryException $e) {
            if(str_contains($e->getMessage(), 'Duplicate')) {
                throw new RoleScopeRelationAlreadyExistsException;
            }
        }

        return response()->noContent();
    }

}
