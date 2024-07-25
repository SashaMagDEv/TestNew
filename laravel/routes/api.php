<?php

use Illuminate\Http\Request;
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

    Route::group(['prefix' => '{id}'], function () {
        Route::get('/', [CategoryController::class, 'show']);
        Route::get('/news', [CategoryController::class, 'getNewsByCategory']);
        Route::post('/add-news', [CategoryController::class, 'storeNews']);
    });
});

Route::group(['prefix' => 'news'], function () {
    Route::post('/', [NewsController::class, 'store']);

    Route::group(['prefix' => '{id}'], function () {
        Route::get('/', [NewsController::class, 'show']);
        Route::get('/edit', [NewsController::class, 'show']);
        Route::put('/', [NewsController::class, 'update']);
        Route::delete('/', [NewsController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
