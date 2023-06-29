<?php

use App\Http\Controllers\Admin\EndpointController;
use App\Http\Controllers\Admin\SiteController;
use App\Http\Controllers\ProfileController;
use App\Models\Endpoint;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('sites', [SiteController::class, 'index'])->name('sites.index');
    Route::get('sites/create', [SiteController::class, 'create'])->name('sites.create');
    Route::get('sites/{site}/edit/', [SiteController::class, 'edit'])->name('sites.edit');
    Route::post('sites', [SiteController::class, 'store'])->name('sites.store');
    Route::put('sites/{site}', [SiteController::class, 'update'])->name('sites.update');
    Route::delete('sites/{site}', [SiteController::class, 'destroy'])->name('sites.destroy');

    Route::resource('/sites/{site}/endpoints', EndpointController::class);
});

require __DIR__.'/auth.php';
