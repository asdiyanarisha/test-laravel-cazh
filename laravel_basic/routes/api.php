<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->post('companies/insert', [CompaniesController::class, 'insert'])->name('api-companies-insert');
Route::middleware('auth:api')->post('companies/change', [CompaniesController::class, 'change'])->name('api-companies-change');
Route::middleware('auth:api')->post('companies/delete', [CompaniesController::class, 'delete'])->name('api-companies-delete');
Route::middleware('auth:api')->post('companies/paginate', [CompaniesController::class, 'paginate'])->name('api-companies-paginate');


Route::middleware('auth:api')->post('employees/insert', [EmployeeController::class, 'insert'])->name('api-employees-insert');
Route::middleware('auth:api')->post('employees/change', [EmployeeController::class, 'change'])->name('api-employees-change');
Route::middleware('auth:api')->post('employees/delete', [EmployeeController::class, 'delete'])->name('api-employees-delete');