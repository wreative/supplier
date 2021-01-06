<?php

use Illuminate\Support\Facades\Route;

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
//Sales
