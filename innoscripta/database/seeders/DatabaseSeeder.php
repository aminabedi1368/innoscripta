<?php
namespace Database\Seeders;

use App\Constants\ClientConstants;
use App\Models\ClientModel;
use App\Models\ProjectModel;
use App\Models\RoleModel;
use App\Models\RoleScopeModel;
use App\Models\ScopeModel;
use App\Models\UserIdentifierModel;
use App\Models\UserModel;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class DatabaseSeeder
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $this->createSuperUser();

        $this->createProjectAndAdminClient();

        $this->call([
//            UserSeeder::class,
//            UserIdentifierSeeder::class,
//            ProjectSeeder::class,
//            ClientSeeder::class,
//            RoleSeeder::class,
//            ScopeSeeder::class,
//            BadLoginSeeder::class,
            SettingsSeeder::class,
        ]);

        $this->seedScopes();
        $this->seedRoles();
        $this->addStarScopeToAdminRole();

//        $this->attachScopesToRoles();
    }


    private function seedRoles()
    {
        RoleModel::query()->create([
            'name' => 'admin',
            'slug' => 'admin',
            'project_id' => ProjectModel::query()->first()->id,
            'description' => 'dashboard admin user'
        ]);
    }

    private function addStarScopeToAdminRole()
    {
        RoleScopeModel::query()->create([
            'role_id' => RoleModel::query()->where('slug', 'admin')->first()->id,
            'scope_id' => ScopeModel::query()->where('slug', 'star')->first()->id
        ]);
    }

    private function seedScopes()
    {
        $scopes = explode(',', env('OAUTH_SCOPES'));

        $methods = ['get', 'post', 'patch', 'delete'];
        foreach ($scopes as $scope) {
            foreach ($methods as $method) {

                $name = null;
                switch ($method) {
                    case 'get':
                        $name = "show  $scope";
                        break;

                    case "post":
                        $name = "insert $scope";
                        break;

                    case "patch":
                    case "put":
                        $name = "edite $scope";
                        break;

                    case "delete":
                        $name = "delete $scope";
                        break;
                }

                ScopeModel::query()->create([
                    'name' => $name,
                    'slug' => $scope.'.'.$method,
                    'description' => $scope.'.'.$method.' scope',
                    'project_id' => ProjectModel::query()->first()->id
                ]);
            }
        }

        ScopeModel::query()->create([
            'name' => '*',
            'slug' => 'star',
            'description' => 'all scopes',
            'project_id' => ProjectModel::query()->first()->id
        ]);
    }


    private function createSuperUser()
    {
        /** @var UserModel $userModel */
        $userModel = UserModel::query()->where('is_super_admin', true)->firstOrCreate([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'status' => 'active',
            'password' => Hash::make(env('ROOT_PASSWORD')),
            'is_super_admin' => true,
            'avatar' => 'public/avatar/admin.jpeg',
            'app_fields' => ['username' => env('ROOT_USERNAME')],
            'year_month' => get_year_jalali() . '-' . get_month_jalali(),
            'year_month_day' => get_year_jalali() . '-' . get_month_jalali() . '-' . get_month_day_jalali(),
            'year_week' => get_year_jalali() . '-' . get_week_jalali(),
        ]);

//        $userModel = UserModel::query()->where('is_super_admin', true)->existsOr(function () {
//            UserModel::query()->create([
//                'first_name' => 'Super',
//                'last_name' => 'Admin',
//                'status' => 'active',
//                'password' => Hash::make(env('ROOT_PASSWORD')),
//                'is_super_admin' => true,
//                'avatar' => 'public/avatar/admin.jpeg',
//                'app_fields' => ['username' => env('ROOT_USERNAME')],
//                'year_month' => get_year_jalali() . '-' . get_month_jalali(),
//                'year_month_day' => get_year_jalali() . '-' . get_month_jalali() . '-' . get_month_day_jalali(),
//                'year_week' => get_year_jalali() . '-' . get_week_jalali(),
//            ]);
//        })->firstOrFail();

        UserIdentifierModel::query()->create([
            'type' => 'email',
            'value' => 'aminabedi1368@gmail.com',
            'is_verified' => 1,
            'user_id' => $userModel->id
        ]);
    }

    /**
     * @throws Exception
     */
    private function attachScopesToRoles()
    {
        $roles = RoleModel::query()->get();

        /** @var RoleModel $role */
        foreach ($roles as $role) {

            $number_of_scopes = random_int(3, 10);
            $project_id = $role->project_id;
            $scopes = ScopeModel::query()
                ->where('project_id', $project_id)
                ->inRandomOrder()
                ->take($number_of_scopes)
                ->get();

            $role->scopes()->attach($scopes->pluck('id'));
        }
    }


    private function createProjectAndAdminClient()
    {
        /** @var UserModel $user */
        $user = UserModel::query()->where('is_super_admin', 1)->firstOrFail();

        /** @var ProjectModel $project */
        $project = ProjectModel::query()->create([
            'name' => env("APP_NAME", "User Management System"),
            'slug' =>  Str::slug(env("APP_NAME", "User Management System")),
            'description' => 'MAIN IN HOUSE PROJECT',
            'project_id' => Str::random(20),
            'creator_user_id' => $user->id,
            'is_first_party' => 1
        ]);

        ClientModel::query()->create([
            'name' => 'ADMIN DASHBOARD',
            'slug' => 'admin-dashboard',
            'type' => ClientConstants::CLIENT_TYPE_BACKEND,
            'client_id' => Str::random(20),
            'client_secret' => Str::random(20),
            'oauth_client_type' => ClientConstants::OAUTH_TYPE_CONFIDENTIAL,
            'is_active' => true,
            'project_id' => $project->id,
            'redirect_urls' => json_encode([
                "https://agatizer.com"
            ])
        ]);
    }


}
