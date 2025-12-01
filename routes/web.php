<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\backend\SaleController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\PurchaseController;
use App\Http\Controllers\backend\WareHouseController;
use App\Http\Controllers\backend\ReturnPurchaseController;

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

  Route::controller(WareHouseController::class)->group(function(){
    Route::get('/all/warehouse', 'index')->name('all.warehouse'); 
    Route::get('/add/brand', 'create')->name('add.warehouse');
    Route::post('/store/warehouse', 'store')->name('store.warehouse');
    Route::get('/edit/warehouse/{id}', 'edit')->name('edit.warehouse');
    Route::post('/update/warehouse', 'update')->name('update.warehouse');
    Route::get('/delete/warehouse/{id}', 'destroy')->name('delete.warehouse');
});

Route::controller(SupplierController::class)->group(function(){
    Route::get('/all/supplier', 'index')->name('all.supplier'); 
    Route::get('/add/supplier', 'create')->name('add.supplier');
    Route::post('/store/supplier', 'store')->name('store.supplier');
    Route::get('/edit/supplier/{id}', 'edit')->name('edit.supplier');
    Route::post('/update/supplier', 'update')->name('update.supplier');
    Route::get('/delete/supplier/{id}', 'destroy')->name('delete.supplier');

    Route::get('/all/customer', 'allCustomer')->name('all.customer'); 
    Route::get('/add/customer', 'addCustomer')->name('add.customer');
    Route::post('/store/customer', 'storeCustomer')->name('store.customer');
    Route::get('/edit/customer/{id}', 'editCustomer')->name('edit.customer');
    Route::post('/update/customer', 'updateCustomer')->name('update.customer');
    Route::get('/delete/customer/{id}', 'deleteCustomer')->name('delete.customer');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/all/category', 'index')->name('all.category');
    Route::post('/store/category', 'store')->name('store.category'); 
    Route::get('/edit/category/{id}', 'edit');
    Route::post('/update/category', 'update')->name('update.category'); 
    Route::get('/delete/category/{id}', 'destroy')->name('delete.category');

    //product route
     Route::get('/all/product', 'allProduct')->name('all.product');
     Route::get('/add/product', 'addProduct')->name('add.product');
     Route::post('/store/product', 'storeProduct')->name('store.product');
     Route::get('/edit/product/{id}', 'editProduct')->name('edit.product');
     Route::post('/update/product', 'updateProduct')->name('update.product');
     Route::get('/delete/product/{id}', 'deleteProduct')->name('delete.product');
     Route::get('/details/product/{id}', 'detailsProduct')->name('details.product');
});


Route::controller(PurchaseController::class)->group(function(){
    Route::get('/all/purchase', 'allPurchase')->name('all.purchase'); 
    Route::get('/add/purchase', 'addPurchase')->name('add.purchase'); 
    Route::get('/purchase/product/search', 'purchaseProductSearch')->name('purchase.product.search'); 
    Route::post('/store/purchase', 'storePurchase')->name('store.purchase');
    Route::get('/edit/purchase/{id}', 'editPurchase')->name('edit.purchase'); 
    Route::post('/update/purchase/{id}', 'updatePurchase')->name('update.purchase'); 
    Route::get('/delete/purchase/{id}', 'deletePurchase')->name('delete.purchase');
    Route::get('/details/purchase/{id}', 'detailsPurchase')->name('details.purchase'); 
    Route::get('/invoice/purchase/{id}', 'invoicePurchase')->name('invoice.purchase');
});

Route::controller(ReturnPurchaseController::class)->group(function(){
    Route::get('/all/return/purchase', 'index')->name('all.return.purchase');
    Route::get('/add/return/purchase', 'create')->name('add.return.purchase');
    Route::post('/store/return/purchase', 'store')->name('store.return.purchase');
    Route::get('/details/return/purchase/{id}', 'detailsReturnPurchase')->name('details.return.purchase');
    Route::get('/invoice/return/purchase/{id}', 'invoiceReturnPurchase')->name('invoice.return.purchase');
    Route::get('/edit/return/purchase/{id}', 'edit')->name('edit.return.purchase');
    Route::post('/update/return/purchase/{id}', 'update')->name('update.return.purchase');
    Route::get('/delete/return/purchase/{id}', 'destroy')->name('delete.return.purchase');
});

Route::controller(SaleController::class)->group(function(){
    Route::get('/all/sale', 'index')->name('all.sale');
    Route::get('/add/sale', 'create')->name('add.sale');
    Route::post('/store/sale', 'store')->name('store.sale');
    Route::get('/edit/sale/{id}', 'edit')->name('edit.sale');
    Route::post('/update/sale/{id}', 'update')->name('update.sale');
    Route::get('/delete/sale/{id}', 'destroy')->name('delete.sale');
});



    
});