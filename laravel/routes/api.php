<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::group(['prefix' => '{category_id}'], function () {
        Route::post('/news', [NewsController::class, 'store']);
    });
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/', [CategoryController::class, 'show']);
        Route::get('/news', [CategoryController::class, 'getNewsByCategory']);

    });
});
Route::group(['prefix' => 'news'], function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::post('/', [NewsController::class, 'store']);
    Route::group(['prefix' => '{id}'], function () {
        Route::get('/', [NewsController::class, 'show']);
        Route::put('/', [NewsController::class, 'update']);
        Route::delete('/', [NewsController::class, 'deleteNews']);
    });
});


Route::middleware('auth:sanctum')->get('/user', function (\App\Http\Requests\NewsRequest $request) {
    return $request->user();

});
