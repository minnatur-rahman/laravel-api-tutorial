<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('create-user', [UserController::class, 'createUser']);
Route::get('get-users', [UserController::class, 'getUsers']);
Route::get('get-user-detail/{id}', [UserController::class, 'getUserDetail']);

Route::post('update-user/{id}', [UserController::class, 'updateUser']);
