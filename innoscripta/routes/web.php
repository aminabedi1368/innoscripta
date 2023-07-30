<?php
use App\Http\Controllers\Web\SocialLoginController;
use App\Managers\ReportManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\News\NewsController;

//Route::get('/fetch-news', [NewsController::class, 'fetchAndStoreNews'])->name('news.fetch');

Route::get('/', function(ReportManager $reportManager) {

    return view('admin.dashboard')
        ->with('report_monthly', $reportManager->userRegisterPerMonth())
        ->with('report_daily', $reportManager->userRegisterPerDay())
        ->with('report_weekly', $reportManager->userRegisterPerWeek());
})->middleware('oauth.admin')->name('admin.dashboard');


Route::get('/login', function() {
    return view('admin.login');
})->name('admin.login_form');

Route::get('/hi', function() {
    dd(request());
})->name('admin.hi');

//Route::get('/debug-sentry', function () {
//    throw new Exception('My first Sentry error!');
//});

//Route::delete('/upvest/wallet', function () {
//    return response()->noContent();
//});


Route::get('/logout', 'App\Http\Controllers\Web\Admin\LoginController@logoutAdmin')->name('admin.logout');


Route::get('/login/google', [SocialLoginController::class, 'redirectToProvider']);
Route::get('/login/google/callback', [SocialLoginController::class, 'handleProviderCallback']);



Route::post('/login', 'App\Http\Controllers\Web\Admin\LoginController@loginAdmin')
    ->name('admin.login_post');

Route::prefix('tokens')->middleware(['oauth.admin'])->group(function () {

    Route::get('/{user_id}', 'App\Http\Controllers\Web\Admin\TokenController@listUserTokens')
        ->name('admin.token.list_user_tokens');

    Route::get('/{id}/revoke', 'App\Http\Controllers\Web\Admin\TokenController@revokeAccessToken')
        ->name('admin.token.revoke_access_token');
});


Route::prefix('projects')->middleware(['oauth.admin'])->group(function () {

    Route::get('/create', 'App\Http\Controllers\Web\Admin\ProjectController@createForm')
        ->name('admin.project.create_form');

    Route::post('/create', 'App\Http\Controllers\Web\Admin\ProjectController@storeProject')
        ->name('admin.project.store');

    Route::get('/edit/{id}', 'App\Http\Controllers\Web\Admin\ProjectController@editForm')
        ->name('admin.project.edit_form');

    Route::put('/edit/{id}', 'App\Http\Controllers\Web\Admin\ProjectController@updateProject')
        ->name('admin.project.update_project');

    Route::get('/delete/{id}', 'App\Http\Controllers\Web\Admin\ProjectController@deleteProject')
        ->name('admin.project.delete_project');

    Route::get('/{project_id}/scopes', 'App\Http\Controllers\Web\Admin\ScopeController@listProjectScopes')
        ->name('admin.scope.list_project_scopes');

    Route::get('/', 'App\Http\Controllers\Web\Admin\ProjectController@listProjects')
        ->name('admin.project.list_projects');
});



Route::prefix('clients')->middleware(['oauth.admin'])->group(function () {

    Route::get('/{project_id}/create', 'App\Http\Controllers\Web\Admin\ClientController@createForm')
        ->name('admin.client.create_form');

    Route::post('/store', 'App\Http\Controllers\Web\Admin\ClientController@storeClient')
        ->name('admin.client.store');


    Route::get('/{id}/edit', 'App\Http\Controllers\Web\Admin\ClientController@editForm')
        ->name('admin.client.edit_form');

    Route::put('/{id}/edit', 'App\Http\Controllers\Web\Admin\ClientController@updateClient')
        ->name('admin.client.update_client');

    Route::get('/{id}/delete', 'App\Http\Controllers\Web\Admin\ClientController@deleteClient')
        ->name('admin.client.delete_client');

    Route::get('/{project_id}', 'App\Http\Controllers\Web\Admin\ClientController@listProjectClients')
        ->name('admin.client.list_project_clients');
});


Route::prefix('roles')->middleware(['oauth.admin'])->group(function () {

    Route::get('/{project_id}/create', 'App\Http\Controllers\Web\Admin\RoleController@createForm')
        ->name('admin.role.create_form');

    Route::get('/{id}/edit', 'App\Http\Controllers\Web\Admin\RoleController@editForm')
        ->name('admin.role.edit_form');

    Route::get('/{id}/delete', 'App\Http\Controllers\Web\Admin\RoleController@deleteRole')
        ->name('admin.role.delete_role');

    Route::put('/{id}/edit', 'App\Http\Controllers\Web\Admin\RoleController@updateRole')
        ->name('admin.role.update_role');

    Route::post('create', 'App\Http\Controllers\Web\Admin\RoleController@storeRole')
        ->name('admin.role.store_role');


    Route::get('/{role_id}/scopes', 'App\Http\Controllers\Web\Admin\ScopeController@listRoleScopes')
        ->name('admin.scope.list_role_scopes');

    Route::get('/{project_id}', 'App\Http\Controllers\Web\Admin\RoleController@listRoles')
        ->name('admin.role.list_project_roles');
});



Route::prefix('scopes')->middleware(['oauth.admin'])->group(function () {

    Route::get('/{project_id}/create', 'App\Http\Controllers\Web\Admin\ScopeController@createForm')
        ->name('admin.scope.create_form');


    Route::get('/{id}/edit', 'App\Http\Controllers\Web\Admin\ScopeController@editForm')
        ->name('admin.scope.edit_form');

    Route::put('/{id}/edit', 'App\Http\Controllers\Web\Admin\ScopeController@updateScope')
        ->name('admin.scope.update_scope');

    Route::post('/{project_id}/create', 'App\Http\Controllers\Web\Admin\ScopeController@storeScope')
        ->name('admin.scope.store_scope');

    Route::get('/{id}/delete', 'App\Http\Controllers\Web\Admin\ScopeController@deleteScope')
        ->name('admin.scope.delete_scope');


    Route::post('/add_scope_to_role', 'App\Http\Controllers\Web\Admin\ScopeController@addScopeToRole')
        ->name('admin.scope.add_scope_to_role');

    Route::get('/remove_scope_from_role/{role_id}/{scope_id}', 'App\Http\Controllers\Web\Admin\ScopeController@removeScopeFromRole')
        ->name('admin.scope.remove_scope_from_role');

});



Route::prefix('users')->middleware(['oauth.admin'])->group(function () {

    Route::get('/create', 'App\Http\Controllers\Web\Admin\UserController@createForm')
        ->name('admin.user.create_form');

    Route::post('/create', 'App\Http\Controllers\Web\Admin\UserController@storeUser')
        ->name('admin.user.store_user');

    Route::get('/edit/{id}', 'App\Http\Controllers\Web\Admin\UserController@editForm')
        ->name('admin.user.edit_form');

    Route::put('/edit/{id}', 'App\Http\Controllers\Web\Admin\UserController@updateUser')
        ->name('admin.user.update_user');

    Route::get('/', 'App\Http\Controllers\Web\Admin\UserController@listUsers')
        ->name('admin.user.list_users');

    Route::get('/{id}', 'App\Http\Controllers\Web\Admin\UserController@showUser')
        ->name('admin.user.show_user');

    Route::get('/{id}/delete_user', 'App\Http\Controllers\Web\Admin\UserController@deleteUser')
        ->name('admin.user.delete_user');

    Route::put('/{id}/change_password', 'App\Http\Controllers\Web\Admin\UserController@updateUserPassword')
        ->name('admin.user.change_password');

    Route::post('/{id}/upload_avatar', 'App\Http\Controllers\Web\Admin\UserController@uploadUserAvatar')
        ->name('admin.user.upload_avatar');

    Route::get('/{id}/roles', 'App\Http\Controllers\Web\Admin\UserController@listUserRoles')
        ->name('admin.user.list_user_roles');

    Route::get('/{project_id}/list_project_roles', 'App\Http\Controllers\Web\Admin\UserController@listProjectRoles')
        ->name('admin.user.list_project_roles');

    Route::post('/add_role_to_user', 'App\Http\Controllers\Web\Admin\UserController@addRoleToUser')
        ->name('admin.user.add_role_to_user');

    Route::get('/remove_user_role/{user_id}/{role_id}', 'App\Http\Controllers\Web\Admin\UserController@removeUserRole')
        ->name('admin.user.remove_user_role');
});




Route::prefix('user_identifiers')->middleware(['oauth.admin'])->group(function () {

    Route::get('/{user_id}/create', 'App\Http\Controllers\Web\Admin\UserIdentifierController@createForm')
        ->name('admin.user_identifier.create_form');

    Route::post('/create', 'App\Http\Controllers\Web\Admin\UserIdentifierController@storeUserIdentifier')
        ->name('admin.user_identifier.store_user_identifier');

    Route::get('/{id}/delete_identifier', 'App\Http\Controllers\Web\Admin\UserIdentifierController@deleteUserIdentifier')
        ->name('admin.user_identifier.delete_user_identifier');

    ## edit route
    Route::get('/{user_identifier_id}', 'App\Http\Controllers\Web\Admin\UserIdentifierController@editForm')
        ->name('admin.user_identifier.edit_user_identifier_form');

    Route::put('/{user_identifier_id}', 'App\Http\Controllers\Web\Admin\UserIdentifierController@updateUserIdentifier')
        ->name('admin.user_identifier.update_user_identifier');

});



Route::prefix('settings')->middleware(['oauth.admin'])->group(function () {

    Route::get('/create', 'App\Http\Controllers\Web\Admin\SettingController@createForm')
        ->name('admin.setting.create_form');

    Route::get('/keys', 'App\Http\Controllers\Web\Admin\SettingController@listSettings')
        ->name('admin.setting.list_settings');

    Route::get('/icons', 'App\Http\Controllers\Web\Admin\SettingController@listIcons')
        ->name('admin.setting.list_icons');

    Route::post('/icons', 'App\Http\Controllers\Web\Admin\SettingController@uploadIcon')
        ->name('admin.setting.upload_icon');

    Route::get('/{id}/edit', 'App\Http\Controllers\Web\Admin\SettingController@editForm')
        ->name('admin.setting.edit_form');

    Route::put('/{id}/edit', 'App\Http\Controllers\Web\Admin\SettingController@updateSetting')
        ->name('admin.setting.update_settings');

    Route::get('/public_private_key', 'App\Http\Controllers\Web\Admin\SettingController@publicPrivateKeyForm')
        ->name('admin.setting.form_public_private_keys');

    Route::put('/public_private_key', 'App\Http\Controllers\Web\Admin\SettingController@updatePublicPrivateKey')
        ->name('admin.setting.update_public_private_keys');

    Route::post('/generate_public_private_key', 'App\Http\Controllers\Web\Admin\SettingController@generatePublicPrivateKeyPairs')
        ->name('admin.setting.generate_public_private_key');
//

});


Route::prefix('bad_logins')->middleware(['oauth.admin'])->group(function () {

    Route::get('/', 'App\Http\Controllers\Web\Admin\BadLoginController@listBadLogins')
        ->name('admin.bad_logins.list_bad_logins');

});
