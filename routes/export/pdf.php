<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('users/view-pdf', [UserController::class, 'viewPDF'])->name('view-pdf');
Route::post('users/download-pdf', [UserController::class, 'downloadPDF'])->name('download-pdf');
