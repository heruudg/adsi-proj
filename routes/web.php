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
        'product',
        'inventory_location',
        'bill_of_materials',
        'manufacturing_order',
        'manufacturing_status',
        'raw_material',
        'work_center',
    ];

    foreach ($resources as $name) {
        $controller = str_replace('_', '', ucwords($name, '_')) .  'Controller';
        Route::resource($name, "App\\Http\\Controllers\\Dashboard\\{$controller}");
    }
});


// Route::resource('/routing', controller: RoutingController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
