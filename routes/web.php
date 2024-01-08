<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\MovieController;
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

Route::group(['middleware' => 'auth'], function () {
// USER CONTROLLER permissions
    Route::get('index', [UserController::class, 'show'])->middleware('permission:create-user|edit-user|delete-user');
    Route::post('create', [UserController::class, 'store'])->middleware('permission:create-user');
    Route::patch('edit', [UserController::class, 'update'])->middleware('permission:edit-user');
    Route::delete('destroy', [UserController::class, 'destroy'])->middleware('permission:delete-user');

// CELEBRITY CONTROLLER
    Route::get('index', [CelebrityController::class, 'show'])->middleware('permission:create-product|edit-product|delete-product');
    Route::post('create', [CelebrityController::class, 'store'])->middleware('permission:create-product');
    Route::patch('edit', [CelebrityController::class, 'update'])->middleware('permission:edit-product');
    Route::delete('destroy', [CelebrityController::class, 'destroy'])->middleware('permission:delete-product');

// ROLE CONTROLLER
    Route::get('index', [RoleController::class, 'show'])->middleware('permission:create-role|edit-role|delete-role');
    Route::post('create', [RoleController::class, 'store'])->middleware('permission:create-role');
    Route::patch('edit', [RoleController::class, 'update'])->middleware('permission:edit-role');
    Route::delete('destroy', [RoleController::class, 'destroy'])->middleware('permission:delete-role');
});

// EXPORT PDF
Route::post('users/view-pdf', [UserController::class, 'viewPDF'])->name('view-pdf');
Route::post('users/download-pdf', [UserController::class, 'downloadPDF'])->name('download-pdf');

// EXPORT EXCEL
Route::post('users/export-csv', [UserController::class, 'exportCSV'])->name('export-csv');
Route::post('celebrities/export-celebrities-csv', [CelebrityController::class, 'exportCSV'])->name('export-celebrities-csv');
Route::post('movies/export-movies-csv', [MovieController::class, 'exportCSV'])->name('export-movies-csv');
