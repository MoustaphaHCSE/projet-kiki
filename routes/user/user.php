<?php

use App\Enums\PermissionTo;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('index', [UserController::class, 'show'])->middleware(PermissionTo::CRUD_USER->label());
Route::post('create', [UserController::class, 'store'])->middleware(PermissionTo::CREATE_USER->label());
Route::patch('edit', [UserController::class, 'update'])->middleware(PermissionTo::EDIT_USER->label());
Route::delete('destroy', [UserController::class, 'destroy'])->middleware(PermissionTo::DELETE_USER->label());
