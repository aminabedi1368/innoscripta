<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\ProjectModel;
use App\Models\RoleModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class RoleController
 * @package App\Http\Controllers\Web\Admin
 */
class RoleController
{

    /**
     * @param int $project_id
     * @return View
     */
    public function createForm(int $project_id)
    {
        $project = ProjectModel::query()->findOrFail($project_id);

        return view('admin.role.create_form')->with('project', $project);
    }


    /**
     * @param int $id
     * @return View
     */
    public function editForm(int $id)
    {
        $role = RoleModel::query()->findOrFail($id);

        return view('admin.role.edit_form')->with('role', $role);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateRole(int $id)
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->findOrFail($id);

        $role->update(request()->only('name', 'slug', 'description'));

        return redirect()->route('admin.role.list_project_roles', ['project_id' => $role->project_id]);
    }


    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteRole(int $id)
    {
        RoleModel::query()->where('id', $id)->delete();

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function storeRole()
    {
        /** @var RoleModel $role */
        $role = RoleModel::query()->create(request()->all());

        return redirect()->route('admin.role.list_project_roles', ['project_id' => $role->project_id]);
    }

    /**
     * @param int $project_id
     * @return View
     */
    public function listRoles(int $project_id)
    {
        $project = ProjectModel::query()->findOrFail($project_id);

        $roles = RoleModel::query()->where('project_id', $project_id)->paginate(
            request('per_page', 10)
        );
        return view('admin.role.list_roles')->with('roles', $roles)->with('project', $project);
    }

}
