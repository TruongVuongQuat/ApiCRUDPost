<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use VCComponent\Laravel\TestPostManage\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('api/posts', [PostController::class, 'index']);
Route::get('api/posts-filter/{status}', [PostController::class, 'filter_status']);
Route::get('api/posts/{id}', [PostController::class, 'show']);
Route::post('api/posts', [PostController::class, 'store']);
Route::post('api/posts/{id}', [PostController::class, 'update']);
Route::delete('api/posts/{id}', [PostController::class, 'destroy']);
Route::get('api/search/{post}', [PostController::class, 'search']);
