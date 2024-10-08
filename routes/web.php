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

    // ------------------------------------ Students --------------------
    Route::prefix('students')->controller(StudentController::class)->name('students.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/students/createUpdate/{id?}', 'createUpdate')->name('createUpdate');
        Route::post('/students/store', 'store')->name('store');
        Route::get('/students/delete/{id?}', 'destroy')->name('delete');
    });

    Route::prefix('company')->controller(CompanyController::class)->name('company.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/company/createUpdate/{id?}', 'createUpdate')->name('createUpdate');
        Route::post('/company/store', 'store')->name('store');
        Route::get('/company/delete/{id?}', 'destroy')->name('delete');
    });

    Route::prefix('employee')->controller(EmployeeController::class)->name('employee.')->group(function () {
        Route::get('/', 'index')->name('list');
        Route::get('/employee/createUpdate/{id?}', 'createUpdate')->name('createUpdate');
        Route::post('/employee/store', 'store')->name('store');
        Route::get('/employee/delete/{id?}', 'destroy')->name('delete');
    });
});