<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {


    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('/clients', 'ClientController');
    $router->resource('/rules', 'RuleController');
    $router->resource('/users', 'UserController');
    $router->resource('/clients-users', 'ClientUserController');
    $router->resource('/setting', 'SettingController');
    $router->get('/clients-import/index', 'ClientsImportController@index')->name('clients-import');
    $router->post('/clients-import', 'ClientsImportController@store');
});
