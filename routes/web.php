<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name(name: 'dashboard');

    $resources = [
        'user',
        'product',
        'inventory_location',
        'bill_of_material',
        'manufacturing_order',
        'manufacturing_status',
        'raw_material',
        'work_center',
    ];
    Route::post('bill_of_material/{bom_id}/bill_of_material_item', 'App\Http\Controllers\Dashboard\BillOfMaterialItemController@storeBomItem')->name('bill_of_material_item.store');

    Route::post('manufacturing_order/{mfg_id}/start', 'App\Http\Controllers\Dashboard\ManufacturingOrderController@startManufacturing')->name('manufacturing_order_item.start');
    Route::post('manufacturing_order/{mfg_id}/stop', 'App\Http\Controllers\Dashboard\ManufacturingOrderController@stopManufacturing')->name('manufacturing_order_item.start');
    foreach ($resources as $name) {
        $controller = str_replace('_', '', ucwords($name, '_')) .  'Controller';
        Route::resource($name, "App\\Http\\Controllers\\Dashboard\\{$controller}");
    }
});


// Route::resource('/routing', controller: RoutingController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
