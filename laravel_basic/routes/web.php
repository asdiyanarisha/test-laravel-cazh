<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;

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
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('companies')->group(function () {
    Route::get('/add', [CompaniesController::class, 'add']);
    Route::get('/edit/{id}', [CompaniesController::class, 'edit']);
    Route::get('', [CompaniesController::class, 'index']);
});
