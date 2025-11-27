<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\BrandController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');


Route::middleware('auth')->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/profile', 'adminProfile')->name('admin.profile');
        Route::post('/profile/store', 'profileStore')->name('profile.store');
        Route::post('/admin/password/update', 'adminPasswordUpdate')->name('admin.password.update'); 
    });

  //brand route
  Route::resource('brand', BrandController::class)->except(['show']);
    
});