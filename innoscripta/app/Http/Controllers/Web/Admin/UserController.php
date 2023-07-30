<?php
namespace App\Http\Controllers\Web\Admin;

use App\Constants\UserStatus;
use App\Models\ProjectModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 * Class UserController
 * @package App\Http\Controllers\Web\Admin
 */
class UserController
{

    /**
     * @return View
     */
    public function createForm(): View
    {
        return view('admin.user.create_form');
    }

    /**
     * @return RedirectResponse
     * @throws Exception
     */
    public function storeUser(): RedirectResponse
    {
        $data = request()->all();
        $data['password'] = Hash::make(request('password'));
        $data['status'] = UserStatus::ACTIVE;

        if(!array_key_exists('app_fields', $data)) {
            $data['app_fields'] = ['user_unique_id' => Uuid::uuid4()];
        }

        $data['year_month'] = get_year_jalali() . '-' . get_month_jalali();
        $data['year_month_day'] = get_year_jalali() . '-' . get_month_jalali() . '-' . get_month_day_jalali();
        $data['year_week'] = get_year_jalali() . '-' . get_week_jalali();


        UserModel::query()->create($data);

        return redirect()->route('admin.user.list_users')->with('success_message', 'user created');
    }

    /**
     * @param int $id
     * @return View
     */
    public function editForm(int $id): View
    {
        $user = UserModel::query()->findOrFail($id);

        return view('admin.user.edit_form')->with('user', $user);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateUser(int $id): RedirectResponse
    {
        $user = UserModel::query()->findOrFail($id);

        $user->update(request()->only('first_name', 'last_name', 'status', 'is_super_admin'));

        return redirect()->route('admin.user.list_users');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function updateUserPassword(int $id): RedirectResponse
    {
        $password = request('password');

        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail($id);

        $user->password = Hash::make($password);
        $user->save();

        return redirect()->route('admin.user.list_users')->with('success_message', 'user password updated successfully');
    }

    /**
     * @return View
     */
    public function listUsers(): View
    {
        $users = UserModel::query()->paginate(
            request('per_page', 10)
        );

        return view('admin.user.list_users')->with('users', $users);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function deleteUser(int $id): RedirectResponse
    {
        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail($id);

        if($user->userIdentifiers()->exists()) {
            return redirect()->back()->withErrors(['message' => 'cant delete this user']);
        }
        else {
            $user->delete();
            return redirect()->back()->with('success_message', 'user deleted successfully');
        }
    }

    /**
     * @param int $id
     * @return View
     */
    public function showUser(int $id): View
    {
        $user = UserModel::query()->with(['userIdentifiers'])->findOrFail($id);

        return view('admin.user.show_user')->with('user', $user);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function uploadUserAvatar(int $id): RedirectResponse
    {
        /** @var UserModel $user */
        $user = UserModel::query()->findOrFail($id);

        $path = request()->file('avatar')->store('/public/avatar');

        $user->avatar = $path;
        $user->save();

        return redirect()->back();
    }


    /**
     * @param int $id
     * @return View
     */
    public function listUserRoles(int $id): View
    {
        /** @var UserModel $user */
        $user = UserModel::query()->with('roles')->findOrFail($id);

        $userRoleIds = $user->roles->pluck('id')->toArray();

        $projects = ProjectModel::query()->get();

        return view('admin.user.user_roles')
            ->with('user', $user)
            ->with('userRoleIds', $userRoleIds)
            ->with('projects', $projects);
    }

    /**
     * @param int $project_id
     * @return JsonResponse
     */
    public function listProjectRoles(int $project_id): JsonResponse
    {
        $roles = RoleModel::query()->where('project_id', $project_id)->get()->toArray();

        return response()->json($roles);
    }

    /**
     * @return RedirectResponse
     */
    public function addRoleToUser(): RedirectResponse
    {
        $role_id = request('role_id');
        $user_id = request('user_id');

        UserRoleModel::query()->create([
            'role_id' => $role_id,
            'user_id' => $user_id
        ]);

        return redirect()->route('admin.user.list_user_roles', ['id' => $user_id]);
    }


    /**
     * @param int $role_id
     * @param int $user_id
     * @return RedirectResponse
     */
    public function removeUserRole(int $user_id, int $role_id): RedirectResponse
    {
        UserRoleModel::query()
            ->where('role_id', $role_id)
            ->where('user_id', $user_id)
            ->delete();

        return redirect()->back();
    }

}
