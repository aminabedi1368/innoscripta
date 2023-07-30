<?php
namespace App\Http\Controllers\Web\Admin;

use App\Models\ProjectModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Web\Admin
 */
class ProjectController
{


    /**
     * @return View
     */
    public function createForm()
    {
        return view('admin.project.create_form');
    }


    /**
     * return View
     * @param int $id
     * @return View
     */
    public function editForm(int $id)
    {
        return view('admin.project.edit_form')->with('project', ProjectModel::query()->findOrFail($id));
    }

    /**
     * return View
     * @param int $id
     * @return RedirectResponse
     */
    public function updateProject(int $id)
    {
        ProjectModel::query()
            ->where('id', $id)
            ->update(
                request()->only('name', 'slug', 'is_first_party', 'description')
            );

        return redirect()->route('admin.project.list_projects');
    }


    /**
     * return View
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteProject(int $id)
    {
        /** @var ProjectModel $project */
        $project = ProjectModel::query()->findOrFail($id);

        if($project->clients()->exists() || $project->roles()->exists() || $project->scopes()->exists() ) {
            return redirect()->back()->withErrors(['message' => 'cant delete this project']);
        }

        else {
            $project->delete();
            return redirect()->back();
        }
    }


    /**
     * @return RedirectResponse
     */
    public function storeProject()
    {
        /** @var ProjectModel $projectModel */
        $projectModel = ProjectModel::query()->create(
            array_merge(
                request()->only('name', 'slug', 'is_first_party', 'description'),
                [
                    'project_id' => Str::random(20),
                    'creator_user_id' => UserModel::query()->where('is_super_admin', true)->firstOrFail()->id
                ]
            )
        );

        return redirect()->route('admin.project.list_projects');
    }

    /**
     * @return View
     */
    public function listProjects()
    {
        $projects = ProjectModel::query()->with('creatorUser')->paginate();

        return view('admin.project.list_projects')->with('projects', $projects);
    }

}
