<?php

use App\Enums\PermissionTo;
use App\Http\Controllers\CelebrityController;
use Illuminate\Support\Facades\Route;

Route::get('index', [CelebrityController::class, 'show'])->middleware(PermissionTo::CRUD_CELEBRITY->label());
Route::post('create', [CelebrityController::class, 'store'])->middleware(PermissionTo::CREATE_CELEBRITY->label());
Route::patch('edit', [CelebrityController::class, 'update'])->middleware(PermissionTo::EDIT_CELEBRITY->label());
Route::delete('destroy', [CelebrityController::class, 'destroy'])->middleware(PermissionTo::DELETE_CELEBRITY->label());
