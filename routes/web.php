<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ------------------------------------ login --------------------
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'doLogin'])->name('do.login');
});

Route::middleware('auth')->group(function () {
    // ------------------------------------ logout --------------------
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // ------------------------------------ Company --------------------
    Route::prefix('company')->controller(CompanyController::class)->name('company.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/createUpdate/{id?}', 'createUpdate')->name('createUpdate');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });

    // ------------------------------------ Employee --------------------
    Route::prefix('employee')->controller(EmployeeController::class)->name('employee.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/createUpdate/{id?}', 'createUpdate')->name('createUpdate');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{id}', 'destroy')->name('delete');
    });
});