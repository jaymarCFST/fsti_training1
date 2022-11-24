<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request)
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function (){
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});

Route::middleware('auth:api')->group(function (){
    // User Unauthentication
    Route::post('auth/logout', [UserController::class, 'logout']);

    // Users API
    Route::group(['prefix' => 'users'], function () {
        Route::post('store', [UserController::class, 'store']);
        Route::get('all', [UserController::class, 'index']);
        Route::get('{id}', [UserController::class, 'get']);
        Route::put('update', [UserController::class, 'update']);
        Route::delete('{id}', [UserController::class, 'delete']);
    });
    // Article Categories API
    Route::group(['prefix' => 'article-categories'], function () {
        Route::get('all', [ArticleCategoryController::class, 'index']);
        Route::get('{id}', [ArticleCategoryController::class, 'get']);
        Route::post('store', [ArticleCategoryController::class, 'store']);
        Route::put('update', [ArticleCategoryController::class, 'update']);
        Route::delete('{id}', [ArticleCategoryController::class, 'delete']);
    });

    // Articles API
    Route::group(['prefix' => 'articles'], function () {
        Route::get('all', [ArticleController::class, 'index']);
        Route::get('{id}', [ArticleController::class, 'get']);
        Route::post('store', [ArticleController::class, 'store']);
        Route::put('update', [ArticleController::class, 'update']);
        Route::delete('{id}', [ArticleController::class, 'delete']);
    });
});
