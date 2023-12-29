<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::resources([
            'roles' => RoleController::class,
            'users' => UserController::class,
            'celebrities' => CelebrityController::class
        ]);
    });
});

// EXPORT PDF
Route::post('users/view-pdf', [UserController::class, 'viewPDF'])->name('view-pdf');
Route::post('users/download-pdf', [UserController::class, 'downloadPDF'])->name('download-pdf');

// EXPORT EXCEL
Route::post('users/export-csv', [UserController::class, 'exportCSV'])->name('export-csv');
