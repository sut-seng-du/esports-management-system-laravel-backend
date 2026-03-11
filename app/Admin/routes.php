<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\SeatController;
use App\Admin\Controllers\InventoryController;
Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('seats', SeatController::class);
    $router->resource('inventories', InventoryController::class);

});
