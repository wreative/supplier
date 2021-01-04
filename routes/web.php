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
Route::get('/employees', [App\Http\Controllers\UnitsController::class, 'index'])
    ->name('masterEmployees');
Route::get('/employees/create', [App\Http\Controllers\UnitsController::class, 'create'])
    ->name('createEmployees');
Route::post('/employees/store', [App\Http\Controllers\UnitsController::class, 'store'])
    ->name('storeEmployees');
Route::get('/employees/edit/{id}', [App\Http\Controllers\UnitsController::class, 'edit']);
Route::put('/employees/update/{id}', [App\Http\Controllers\UnitsController::class, 'update']);
Route::get('/employees/info/{id}', [App\Http\Controllers\UnitsController::class, 'info']);

// Transaction
Route::get('/employees', [App\Http\Controllers\EmployeesController::class, 'index'])
    ->name('masterEmployees');
Route::get('/employees/create', [App\Http\Controllers\EmployeesController::class, 'create'])
    ->name('createEmployees');
Route::post('/employees/store', [App\Http\Controllers\EmployeesController::class, 'store'])
    ->name('storeEmployees');
Route::get('/employees/edit/{id}', [App\Http\Controllers\EmployeesController::class, 'edit']);
Route::put('/employees/update/{id}', [App\Http\Controllers\EmployeesController::class, 'update']);
Route::get('/employees/info/{id}', [App\Http\Controllers\EmployeesController::class, 'info']);
