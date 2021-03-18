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
    Route::resource('items', App\Http\Controllers\ItemsController::class)->except([
        'show'
    ]);

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

    // Marketer
    Route::get('/marketer', [App\Http\Controllers\MarketerController::class, 'index'])
        ->name('masterMarketer');
    Route::get('/marketer/create', [App\Http\Controllers\MarketerController::class, 'create'])
        ->name('createMarketer');
    Route::post('/marketer/store', [App\Http\Controllers\MarketerController::class, 'store'])
        ->name('storeMarketer');
    Route::get('/marketer/edit/{id}', [App\Http\Controllers\MarketerController::class, 'edit']);
    Route::put('/marketer/update/{id}', [App\Http\Controllers\MarketerController::class, 'update']);
    Route::get('/marketer/delete/{id}', [App\Http\Controllers\MarketerController::class, 'delete']);

    // Check Data
    Route::get('/check-include', [App\Http\Controllers\PublicController::class, 'checkInclude'])
        ->name('checkInclude');
    Route::get('/check-exclude', [App\Http\Controllers\PublicController::class, 'checkExclude'])
        ->name('checkExclude');
    Route::get('/check-price', [App\Http\Controllers\PublicController::class, 'checkPrice'])
        ->name('checkPrice');
    Route::get('/check-purchase', [App\Http\Controllers\PublicController::class, 'checkPurchase'])
        ->name('checkPurchase');
    Route::get('/check-sales', [App\Http\Controllers\PublicController::class, 'checkSales'])
        ->name('checkSales');
    Route::get('/check-ppn', [App\Http\Controllers\PublicController::class, 'checkPPN'])
        ->name('checkPPN');
    Route::get('/check-items', [App\Http\Controllers\PublicController::class, 'getItems'])
        ->name('checkItems');

    // Transaksi Pembelian
    Route::resource('purchase', App\Http\Controllers\PurchaseController::class)->only([
        'index', 'store', 'create', 'destroy'
    ]);
    // Transaksi Penjualan
    Route::resource('sales', App\Http\Controllers\SalesController::class)->except([
        'edit', 'update'
    ]);
    Route::get('/get-price', [App\Http\Controllers\PublicController::class, 'getPrice']);
    // Penawaran
    Route::resource('bidding', App\Http\Controllers\BiddingController::class)->only([
        'index', 'store', 'create', 'destroy'
    ]);
    Route::get('/bidding-items', [App\Http\Controllers\BiddingController::class, 'biddingItems'])
        ->name('biddingItems');
    // Surat Jalan
    Route::resource('tdoc', App\Http\Controllers\TravelDocumentController::class)->only([
        'index', 'store', 'create', 'destroy'
    ]);
    // Laporan
    Route::get('/report', [App\Http\Controllers\ReportController::class, 'index'])
        ->name('report.index');
    // Pengaturan
    Route::resource('settings', SettingsController::class)->only([
        'index', 'edit', 'update'
    ]);
});


// Units
Route::resource('units', App\Http\Controllers\UnitsController::class)->only([
    'index', 'store', 'create'
]);

// Users
Route::get('/change-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])
    ->name('changePassword');
Route::post('/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'changePass'])
    ->name('changePass');
