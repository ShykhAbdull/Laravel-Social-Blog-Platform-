<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CommmentController;
use App\Http\Controllers\api\ImageController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Auth Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Authenticated User can post Image, Videos and Posts
Route::post('posts', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::post('images', [ImageController::class, 'uploadImage'])->middleware('auth:sanctum');
Route::post('videos', [VideoController::class, 'uploadVideo'])->middleware('auth:sanctum');

// Authenticated User can comment/Update/Delete any Post, Video and Image
Route::post('{type}/{id}/comments', [CommmentController::class, 'uploadComment'])->middleware('auth:sanctum');
Route::put('{type}/{id}/comments/{cmnt_id}', [CommmentController::class, 'updateComment'])->middleware('auth:sanctum');
Route::delete('{type}/{id}/comments/{cmnt_id}', [CommmentController::class, 'deleteComment'])->middleware('auth:sanctum');
