<?php

use App\Http\Controllers\BlogController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [BlogController::class, 'index']);
Route::get('/posts/{postId}', [BlogController::class, 'show']);

Route::get('/posts/{postId}/comments', [BlogController::class, 'getComments']);
Route::post('/posts/{postId}/comments', [BlogController::class, 'addComments']);
