<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('verify', 'verifyCode');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tags', TagController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts/deleted', [PostController::class, 'deleted']);
    Route::patch('posts/{id}/restore', [PostController::class, 'restore']);
    Route::apiResource('posts', PostController::class);
});

