<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::any('/', function() {
	return response()->json([
		'success' => false,
		'message' => 'User Unauthorized'
	], 401);
})->name('login');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
	// Route::apiResource('posts', PostController::class);

	Route::get('posts', [PostController::class, 'index'])->middleware('ability:see-post');
	Route::get('posts/{post}', [PostController::class, 'show'])->middleware('ability:see-post');
	Route::post('posts', [PostController::class, 'store'])->middleware('ability:post-manipulation');
	Route::put('posts/{id}', [PostController::class, 'update'])->middleware('ability:post-manipulation','post-owner');
	Route::delete('posts/{id}', [PostController::class, 'destroy'])->middleware('ability:post-manipulation','post-owner');

	Route::post('comments', [CommentController::class, 'store']);
	Route::put('comments/{id}', [CommentController::class, 'update'])->middleware('comment-owner');
	Route::delete('comments/{id}', [CommentController::class, 'destroy'])->middleware('comment-owner');

	Route::get('profile', [UserController::class, 'profile']);
	Route::get('logout', [AuthController::class, 'logout']);
});
