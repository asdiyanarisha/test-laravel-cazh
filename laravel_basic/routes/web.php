<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TransactionController;

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

Auth::routes();


Route::get('/', function () {
    return view('home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('companies')->group(function () {
    Route::get('/add', [CompaniesController::class, 'add']);
    Route::get('/edit/{id}', [CompaniesController::class, 'edit']);
    Route::get('', [CompaniesController::class, 'index']);
});

Route::prefix('employees')->group(function () {
    Route::get('/add', [EmployeeController::class, 'add']);
    Route::get('/edit/{id}', [EmployeeController::class, 'edit']);
    Route::get('', [EmployeeController::class, 'index']);
});

Route::prefix('transaction')->group(function () {
    Route::get('/add', [TransactionController::class, 'add']);
    Route::get('', [TransactionController::class, 'index']);
});
