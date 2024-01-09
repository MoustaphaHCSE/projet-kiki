<?php

use App\Enums\PermissionTo;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('index', [RoleController::class, 'show'])->middleware(PermissionTo::CRUD_ROLE->label());
Route::post('create', [RoleController::class, 'store'])->middleware(PermissionTo::CREATE_ROLE->label());
Route::patch('edit', [RoleController::class, 'update'])->middleware(PermissionTo::EDIT_ROLE->label());
Route::delete('destroy', [RoleController::class, 'destroy'])->middleware(PermissionTo::DELETE_ROLE->label());
