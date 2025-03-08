<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Dashboard\RoutingController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name(name: 'dashboard');
});


Route::resource('/routing', controller: RoutingController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
