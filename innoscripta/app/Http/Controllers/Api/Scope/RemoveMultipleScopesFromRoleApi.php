<?php
namespace App\Http\Controllers\Api\Scope;

use App\Exceptions\OneOrMoreScopeWasNotFoundException;
use App\Models\RoleModel;
use App\Models\RoleScopeModel;
use App\Models\ScopeModel;
use Illuminate\Http\Response;

/**
 * Class RemoveMultipleScopesFromRoleApi
 * @package App\Http\Controllers\Api\Scope
 */
class RemoveMultipleScopesFromRoleApi
{

    /**
     * @return Response
     * @throws OneOrMoreScopeWasNotFoundException
     */
    public function __invoke(): Response
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail(request('role_id'));

        $scopes = ScopeModel::query()->whereIn('id', request('scope_ids'))->get();

        if($scopes->count() != count(request('scope_ids'))) {
            throw new OneOrMoreScopeWasNotFoundException;
        }

        RoleScopeModel::query()
            ->where('role_id', $role->id)
            ->whereIn('scope_id', request('scope_ids'))
            ->delete();

        return response()->noContent();
    }

}
