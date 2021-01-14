<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['reset' => false, 'register' => false]);

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'supplier'], function () {
    // Items
    Route::get('/items', [App\Http\Controllers\ItemsController::class, 'index'])
        ->name('masterItems');
    Route::get('/items/create', [App\Http\Controllers\ItemsController::class, 'create'])
        ->name('createItems');
    Route::post('/items/store', [App\Http\Controllers\ItemsController::class, 'store'])
        ->name('storeItems');
    Route::get('/items/edit/{id}', [App\Http\Controllers\ItemsController::class, 'edit']);
    Route::put('/items/update/{id}', [App\Http\Controllers\ItemsController::class, 'update']);
    Route::get('/items/delete/{id}', [App\Http\Controllers\ItemsController::class, 'delete']);

    // Customer
    Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])
        ->name('masterCustomer');
    Route::get('/customer/create', [App\Http\Controllers\CustomerController::class, 'create'])
        ->name('createCustomer');
    Route::post('/customer/store', [App\Http\Controllers\CustomerController::class, 'store'])
        ->name('storeCustomer');
    Route::get('/customer/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit']);
    Route::put('/customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update']);
    Route::get('/customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete']);

    // Supplier
    Route::get('/supplier', [App\Http\Controllers\SupplierController::class, 'index'])
        ->name('masterSupplier');
    Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'create'])
        ->name('createSupplier');
    Route::post('/supplier/store', [App\Http\Controllers\SupplierController::class, 'store'])
        ->name('storeSupplier');
    Route::get('/supplier/edit/{id}', [App\Http\Controllers\SupplierController::class, 'edit']);
    Route::put('/supplier/update/{id}', [App\Http\Controllers\SupplierController::class, 'update']);
    Route::get('/supplier/delete/{id}', [App\Http\Controllers\SupplierController::class, 'delete']);

    // Sales
    Route::get('/sales', [App\Http\Controllers\SalesController::class, 'index'])
        ->name('masterSales');
    Route::get('/sales/create', [App\Http\Controllers\SalesController::class, 'create'])
        ->name('createSales');
    Route::post('/sales/store', [App\Http\Controllers\SalesController::class, 'store'])
        ->name('storeSales');
    Route::get('/sales/edit/{id}', [App\Http\Controllers\SalesController::class, 'edit']);
    Route::put('/sales/update/{id}', [App\Http\Controllers\SalesController::class, 'update']);
    Route::get('/sales/delete/{id}', [App\Http\Controllers\SalesController::class, 'delete']);

    // Check Data
    Route::get('/check-include', [App\Http\Controllers\PublicController::class, 'checkInclude'])
        ->name('checkInclude');
    Route::get('/check-exclude', [App\Http\Controllers\PublicController::class, 'checkExclude'])
        ->name('checkExclude');
    Route::get('/check-price', [App\Http\Controllers\PublicController::class, 'checkPrice'])
        ->name('checkPrice');

    // Transaction

    // Purchase
    Route::get('/purchase', [App\Http\Controllers\TransactionController::class, 'indexPurchase'])
        ->name('masterPurchase');
    Route::get('/purchase/create', [App\Http\Controllers\TransactionController::class, 'createPurchase'])
        ->name('createPurchase');
    Route::post('/purchase/store', [App\Http\Controllers\TransactionController::class, 'storePurchase'])
        ->name('storePurchase');
    Route::get('/purchase/edit/{id}', [App\Http\Controllers\TransactionController::class, 'editPurchase']);
    Route::put('/purchase/update/{id}', [App\Http\Controllers\TransactionController::class, 'updatePurchase']);
    Route::get('/purchase/delete/{id}', [App\Http\Controllers\TransactionController::class, 'deletePurchase']);
});

Route::group(['middleware' => 'almaas'], function () {
    //Items
    Route::get('/items-almaas', [App\Http\Controllers\ItemsController::class, 'indexAlmaas'])
        ->name('masterItemsAlmaas');
    Route::get('/items-almaas/create', [App\Http\Controllers\ItemsController::class, 'createAlmaas'])
        ->name('createItemsAlmaas');
    Route::post('/items-almaas/store', [App\Http\Controllers\ItemsController::class, 'storeAlmaas'])
        ->name('storeItemsAlmaas');
    Route::get('/items-almaas/edit/{id}', [App\Http\Controllers\ItemsController::class, 'editAlmaas']);
    Route::put('/items-almaas/update/{id}', [App\Http\Controllers\ItemsController::class, 'updateAlmaas']);
    Route::get('/items-almaas/delete/{id}', [App\Http\Controllers\ItemsController::class, 'deleteAlmaas']);
});


// Units
Route::get('/units', [App\Http\Controllers\UnitsController::class, 'index'])
    ->name('masterUnits');
Route::get('/units/create', [App\Http\Controllers\UnitsController::class, 'create'])
    ->name('createUnits');
Route::post('/units/store', [App\Http\Controllers\UnitsController::class, 'store'])
    ->name('storeUnits');
Route::get('/units/edit/{id}', [App\Http\Controllers\UnitsController::class, 'edit']);
Route::put('/units/update/{id}', [App\Http\Controllers\UnitsController::class, 'update']);
Route::get('/units/delete/{id}', [App\Http\Controllers\UnitsController::class, 'delete']);
