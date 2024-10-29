<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
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



Route::get('/', [EmployeeController::class, 'index'])->name('employees.index');
Route::post('/store', [EmployeeController::class, 'store']);
Route::get('/edit', [EmployeeController::class, 'edit']);
Route::post('/update/{id}', [EmployeeController::class, 'update']);
Route::get('/delete', [EmployeeController::class, 'delete']);



