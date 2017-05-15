<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$adminRoute = config('edutalk.admin_route');

$moduleRoute = 'users';

/*
 * Admin route
 * */
Route::group(['prefix' => $adminRoute], function (Router $router) use ($adminRoute, $moduleRoute) {
    Route::group(['prefix' => 'auth'], function (Router $router) use ($adminRoute, $moduleRoute) {
        $router->get($moduleRoute, function () use ($adminRoute, $moduleRoute) {
            return redirect()->to($adminRoute . '/' . $moduleRoute . '/login');
        });

        $router->get('login', 'AuthController@getLogin')->name('admin::auth.login.get');
        $router->post('login', 'AuthController@postLogin')->name('admin::auth.login.post');
        $router->get('logout', 'AuthController@getLogout')->name('admin::auth.logout.get');
    });

    $router->group(['prefix' => 'users'], function (Router $router) {
        $router->get('/', 'UserController@getIndex')
            ->name('admin::users.index.get')
            ->middleware('has-permission:view-users');

        $router->post('/', 'UserController@postListing')
            ->name('admin::users.index.post')
            ->middleware('has-permission:view-users');

        $router->post('update-status/{id}/{status}', 'UserController@postUpdateStatus')
            ->name('admin::users.update-status.post')
            ->middleware('has-permission:edit-other-users');

        $router->post('restore/{id}', 'UserController@postRestore')
            ->name('admin::users.restore.post')
            ->middleware('has-permission:edit-other-users');

        $router->get('create', 'UserController@getCreate')
            ->name('admin::users.create.get')
            ->middleware('has-permission:create-users');

        $router->post('create', 'UserController@postCreate')
            ->name('admin::users.create.post')
            ->middleware('has-permission:create-users');

        $router->get('edit/{id}', 'UserController@getEdit')
            ->name('admin::users.edit.get');
        $router->post('edit/{id}', 'UserController@postEdit')
            ->name('admin::users.edit.post');

        $router->post('update-password/{id}', 'UserController@postUpdatePassword')
            ->name('admin::users.update-password.post');

        $router->delete('delete/{id}', 'UserController@deleteDelete')
            ->name('admin::users.delete.delete')
            ->middleware('has-permission:delete-users');

        $router->delete('force-delete/{id}', 'UserController@deleteForceDelete')
            ->name('admin::users.force-delete.delete')
            ->middleware('has-permission:force-delete-users');
    });
});
