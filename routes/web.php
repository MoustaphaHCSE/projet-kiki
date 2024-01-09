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

Route::group([
    'prefix' => 'admin',
    'middleware' => 'auth',
], function () {
    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'celebrities' => CelebrityController::class
    ]);
});
Route::group(['middleware' => 'auth'], function () {
    require_once 'user/user.php';
    require_once 'celebrity/celebrity.php';
    require_once 'role/role.php';
});

require_once 'export/pdf.php';
require_once 'export/csv.php';
