<?php
use Illuminate\Support\Facades\Route;

$authM = 'oauth';
$authadminM = 'oauth.admin';

Route::get('/news', 'App\Http\Controllers\Api\News\NewsController@__invoke');

// no token
Route::prefix('token')->middleware([])->group(function () {
    Route::post('/', 'App\Http\Controllers\Api\Token\IssueTokenApi@__invoke');
    Route::get('/token_info/{access_token}', 'App\Http\Controllers\Api\Token\GetTokenInfoApi@__invoke');
    Route::delete('/revoke_token/{access_token}', 'App\Http\Controllers\Api\Token\RevokeUserTokenApi@__invoke');
    Route::delete('/revoke_token', 'App\Http\Controllers\Api\Token\RevokeMyTokenApi@__invoke');
});

// admin
Route::prefix('projects')->middleware([$authadminM])->group(function () {
    Route::post('/', 'App\Http\Controllers\Api\Project\CreateProjectApi@__invoke');
    Route::get('/{id}', 'App\Http\Controllers\Api\Project\ShowProjectApi@__invoke');
    Route::get('/', 'App\Http\Controllers\Api\Project\ListProjectApi@__invoke');
    Route::put('/{id}', 'App\Http\Controllers\Api\Project\UpdateProjectApi@__invoke');
    Route::delete('/{id}', 'App\Http\Controllers\Api\Project\DeleteProjectApi@__invoke');

    Route::get('/{id}/clients', 'App\Http\Controllers\Api\Client\ListClientByProjectIdApi@__invoke');

});

// admin
Route::prefix('roles')->middleware([$authadminM])->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\Role\ListRoleApi@__invoke');
    Route::post('/', 'App\Http\Controllers\Api\Role\CreateRoleApi@__invoke');
    Route::post('/add_role_to_user', 'App\Http\Controllers\Api\Role\AddRoleToUserApi@__invoke');
    Route::post('/add_multiple_roles_to_user', 'App\Http\Controllers\Api\Role\AddMultipleRolesToUserApi@__invoke');
    Route::post('/remove_multiple_roles_from_user', 'App\Http\Controllers\Api\Role\RemoveMultipleRolesFromUserApi@__invoke');
    Route::delete('/{id}', 'App\Http\Controllers\Api\Role\DeleteRoleApi@__invoke')->where('id', '[0-9]+');
    Route::put('/{id}', 'App\Http\Controllers\Api\Role\PutRoleApi@__invoke')->where('id', '[0-9]+');
    Route::patch('/{id}', 'App\Http\Controllers\Api\Role\PatchRoleApi@__invoke')->where('id', '[0-9]+');
    Route::get('/{id}', 'App\Http\Controllers\Api\Role\ShowRoleApi@__invoke')->where('id', '[0-9]+');
});

// admin
Route::prefix('clients')->middleware([$authadminM])->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\Client\ListClientApi@__invoke');
    Route::post('/', 'App\Http\Controllers\Api\Client\CreateClientApi@__invoke');
    Route::delete('/{id}', 'App\Http\Controllers\Api\Client\DeleteClientApi@__invoke');
    Route::put('/{id}', 'App\Http\Controllers\Api\Client\UpdateClientApi@__invoke');
    Route::get('/{id}', 'App\Http\Controllers\Api\Client\ShowClientApi@__invoke');
});

Route::get('/clients/{project_slug}/list', 'App\Http\Controllers\Api\Client\ListClientByProjectApi@__invoke');

// admin
Route::prefix('scopes')->middleware([$authadminM])->group(function () {
    Route::get('/', 'App\Http\Controllers\Api\Scope\ListScopeApi@__invoke');
    Route::post('/', 'App\Http\Controllers\Api\Scope\CreateScopeApi@__invoke');
    Route::post('/add_scope_to_role', 'App\Http\Controllers\Api\Scope\AddScopeToRoleApi@__invoke');
    Route::post('/add_multiple_scopes_to_role', 'App\Http\Controllers\Api\Scope\AddMultipleScopesToRoleApi@__invoke');
    Route::post('/remove_multiple_scopes_from_role', 'App\Http\Controllers\Api\Scope\RemoveMultipleScopesFromRoleApi@__invoke');
    Route::delete('/{id}', 'App\Http\Controllers\Api\Scope\DeleteScopeApi@__invoke');
    Route::put('/{id}', 'App\Http\Controllers\Api\Scope\PutScopeApi@__invoke');
    Route::patch('/{id}', 'App\Http\Controllers\Api\Scope\PatchScopeApi@__invoke');
    Route::get('/{id}', 'App\Http\Controllers\Api\Scope\ShowScopeApi@__invoke');
});

// user or admin
Route::prefix('users')->group(function () use ($authM, $authadminM) {

    // admin
    Route::get('/', 'App\Http\Controllers\Api\User\ListUserApi@__invoke')->middleware([$authadminM]);

    // user || admin
    Route::put('/change-password', 'App\Http\Controllers\Api\User\ChangeMyPasswordApi@__invoke')
        ->middleware([$authM]);

    // admin
    Route::delete('/{id}', 'App\Http\Controllers\Api\User\DeleteUserApi@__invoke')
        ->middleware([$authadminM]);

    // user || admin
    Route::put('/{id}', 'App\Http\Controllers\Api\User\UpdateUserApi@__invoke')->middleware([$authM]);

    // admin
    Route::post('/{id}/avatar', 'App\Http\Controllers\Api\User\UploadUserAvatarByAdminApi@__invoke')
        ->middleware([$authadminM]);

    Route::delete('/{id}/avatar', 'App\Http\Controllers\Api\User\UploadUserAvatarByAdminApi@__invoke')
        ->middleware([$authadminM]);

    // user
    Route::post('/avatar', 'App\Http\Controllers\Api\User\UploadUserAvatarApi@__invoke')->middleware([$authM]);

    // user
    Route::get('/fetch-news', 'App\Http\Controllers\Api\News\fetchAndStoreNewsApi@__invoke')->middleware([$authM]);
    Route::get('/history-search', 'App\Http\Controllers\Api\News\HistoryFetchNewsApi@__invoke')->middleware([$authM]);

    // admin
    Route::get('/{id}', 'App\Http\Controllers\Api\User\ShowUserApi@__invoke')->middleware([$authadminM]);

    Route::patch('/{id}', 'App\Http\Controllers\Api\User\PatchUserApi@__invoke')->middleware([$authadminM]);


    // no token
    Route::post('/forget-password', 'App\Http\Controllers\Api\User\ForgetPasswordApi@__invoke');

    // no token
    Route::post('/', 'App\Http\Controllers\Api\User\CreateUserApi@__invoke');
});


Route::prefix('user_identifiers')->middleware([])->group(function () use ($authM, $authadminM) {

    // user || admin, if user check identifiers are for him
    Route::get('/mine', 'App\Http\Controllers\Api\UserIdentifier\ListUserIdentifiersApi@__invoke')
        ->middleware([$authM]);

    Route::get('/', 'App\Http\Controllers\Api\UserIdentifier\ListAllUserIdentifiersApi@__invoke')
        ->middleware([$authadminM]);

    Route::post('/', 'App\Http\Controllers\Api\UserIdentifier\CreateUserIdentifierApi@__invoke')
        ->middleware([$authM]);


    Route::post('/by_admin', 'App\Http\Controllers\Api\UserIdentifier\CreateUserIdentifierByAdminApi@__invoke')
    ->middleware([$authadminM]);

    Route::delete('/{id}', 'App\Http\Controllers\Api\UserIdentifier\DeleteUserIdentifierApi@__invoke')
        ->middleware([$authM]);

    // no token
    Route::post('/verify', 'App\Http\Controllers\Api\UserIdentifier\VerifyUserIdentifierApi@__invoke');

    // no token
    Route::post(
        '/send_verification_code',
        'App\Http\Controllers\Api\UserIdentifier\SendVerificationCodeToUserIdentifierApi@__invoke'
    );

    Route::get('/{id}', 'App\Http\Controllers\Api\UserIdentifier\ShowUserIdentifierApi@__invoke')
        ->middleware([$authM]);

    // admin
    Route::put('/{id}', 'App\Http\Controllers\Api\UserIdentifier\ChangeUserIdentifierIsVerifiedApi@__invoke')
        ->middleware([$authadminM]);
});


Route::prefix('stats')->middleware([])->group(function () {

    Route::get('/', 'App\Http\Controllers\Api\IndexController@stats');
});
