<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\AccessTokenModel;
use App\Models\ProjectModel;
use App\Models\RoleModel;
use App\Models\RoleScopeModel;
use App\Models\ScopeModel;
use App\Validators\ScopeValidator;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class ScopeController
 * @package App\Http\Controllers\Web\Admin
 */
class ScopeController
{
    /**
     * @var ScopeValidator
     */
    private ScopeValidator $scopeValidator;

    /**
     * ScopeController constructor.
     * @param ScopeValidator $scopeValidator
     */
    public function __construct(ScopeValidator $scopeValidator)
    {
        $this->scopeValidator = $scopeValidator;
    }

    /**
     * @param int $project_id
     * @return View
     */
    public function createForm(int $project_id)
    {
        /** @var ProjectModel $project */
        $project = ProjectModel::query()->findOrFail($project_id);

        return view('admin.scope.create_form')->with('project', $project);
    }

    /**
     * @param int $id
     * @return View
     */
    public function editForm(int $id)
    {
        $scope = ScopeModel::query()->findOrFail($id);

        return view('admin.scope.edit_form')->with('scope', $scope);
    }


    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateScope(int $id)
    {
        /** @var ScopeModel $scope */
        $scope = ScopeModel::query()->findOrFail($id);

        $scope->update(request()->only('name', 'description'));

        return redirect()->route('admin.scope.list_project_scopes', ['project_id' => $scope->project_id ]);
    }


    /**
     * @param int $project_id
     * @return RedirectResponse
     */
    public function storeScope(int $project_id)
    {
        $data = array_merge(
            request()->only('name', 'slug', 'description'),
            ['project_id' => $project_id]
        );

        ScopeModel::query()->create($data);

        return redirect()->route('admin.scope.list_project_scopes', ['project_id' => $project_id ]);
    }

    /**
     * @param int $project_id
     * @return View
     */
    public function listProjectScopes(int $project_id)
    {
        $scopes = ScopeModel::query()->where('project_id', $project_id)->paginate(
            request('per_page', 10)
        );

        $project = ProjectModel::query()->findOrFail($project_id);

        return view('admin.scope.list_project_scopes')->with('scopes', $scopes)->with('project', $project);
    }

    /**
     * @param int $role_id
     * @return View
     */
    public function listRoleScopes(int $role_id)
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail($role_id);

        $sort_field = request('sort', 'id');
        $sort_dir = request('dir', 'desc');

//        $roleScopes = RoleScopeModel::query()->where('role_id', $role_id)
//            ->with(['scope'=> function($query) use($sort_field, $sort_dir) {
//                $query->orderBy($sort_field, $sort_dir);
//            }])->paginate(request('per_page', 10));

        $roleScopes = RoleScopeModel::query()
            ->where('role_scopes.role_id', $role_id)
            ->join('scopes', 'role_scopes.scope_id', '=', 'scopes.id')
            ->orderBy($sort_field, $sort_dir)->paginate(request('per_page', 10));

        $roleScopeIds = RoleScopeModel::query()->where('role_id', $role_id)->get()->pluck('scope_id');

        $projectScopes = ScopeModel::query()
            ->where('project_id', $role->project_id)
            ->get();

        return view('admin.scope.list_role_scopes')
            ->with('roleScopes', $roleScopes)
            ->with('role', $role)
            ->with('roleAllScopeIds', $roleScopeIds->toArray())
            ->with('projectScopes', $projectScopes);
    }

    /**
     * @param int $role_id
     * @param int $scope_id
     *
     * @return RedirectResponse
     */
    public function removeScopeFromRole(int $role_id, int $scope_id)
    {
        RoleScopeModel::query()->where('role_id', $role_id)->where('scope_id', $scope_id)->delete();

        return redirect()->back();
    }


    /**
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function addScopeToRole()
    {
        $this->scopeValidator->validateAddScopeToRole(request()->all());
        RoleScopeModel::query()->create([
            'role_id' => request('role_id'),
            'scope_id' => request('scope_id')
        ]);

        return redirect()->back();
    }


    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteScope(int $id)
    {
        /** @var ScopeModel $scope */
        $scope = ScopeModel::query()->findOrFail($id);
        $scopeSlug = $scope->slug;

        $doesAnyTokenHasThisAccessToken = AccessTokenModel::query()
            ->where('scopes', 'like', "%$scopeSlug%")
            ->exists();

        if($doesAnyTokenHasThisAccessToken) {
            return redirect()->back()->withErrors([
                "message" => "There are tokens with this scope, so you can't delete this scope"
            ]);
        }
        else {
            $scope->delete();
            return redirect()->back();
        }
    }

}
