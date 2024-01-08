<?php

use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('users/export-csv', [UserController::class, 'exportCSV'])->name('export-csv');
Route::post('celebrities/export-celebrities-csv', [CelebrityController::class, 'exportCSV'])->name('export-celebrities-csv');
Route::post('movies/export-movies-csv', [MovieController::class, 'exportCSV'])->name('export-movies-csv');
