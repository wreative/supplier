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
    Route::resource('customer', App\Http\Controllers\CustomerController::class)->except([
        'show'
    ]);
    // Supplier
    Route::resource('supplier', App\Http\Controllers\SupplierController::class)->except([
        'show'
    ]);
    // Marketer
    Route::resource('marketer', App\Http\Controllers\MarketerController::class)->except([
        'show'
    ]);

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
    Route::resource('purchase', App\Http\Controllers\PurchaseController::class)->except([
        'edit'
    ]);
    Route::get('/status/{id}/{category}', [App\Http\Controllers\PurchaseController::class, 'status'])
        ->name('purchase.status');
    Route::get('/payment/{id}', [App\Http\Controllers\PurchaseController::class, 'payment'])
        ->name('purchase.payment');
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
