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
Route::get('/transaction', [App\Http\Controllers\TransactionController::class, 'index'])
    ->name('masterTransaction');
Route::get('/transaction/create', [App\Http\Controllers\TransactionController::class, 'create'])
    ->name('createTransaction');
Route::post('/transaction/store', [App\Http\Controllers\TransactionController::class, 'store'])
    ->name('storeTransaction');
Route::get('/transaction/edit/{id}', [App\Http\Controllers\TransactionController::class, 'edit']);
Route::put('/transaction/update/{id}', [App\Http\Controllers\TransactionController::class, 'update']);
Route::get('/transaction/delete/{id}', [App\Http\Controllers\TransactionController::class, 'delete']);
