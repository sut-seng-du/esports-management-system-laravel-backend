<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\SeatController;
use App\Admin\Controllers\InventoryController;
use App\Admin\Controllers\RecordController;
Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->post('/records/manage-inventory-stock', 'RecordController@manageInventoryStock')->name('manage-inventory-stock');
    $router->post('/records/{id}/manage-inventory-stock', 'RecordController@manageInventoryStock')->name('manage-inventory-stock-by-id');
    $router->resource('seats', SeatController::class);
    $router->resource('inventories', InventoryController::class);
    $router->resource('records', RecordController::class);

});
