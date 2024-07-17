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
Route::post('/news', [NewsController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('news/{id}', [NewsController::class, 'show']);
Route::get('news/{id}/edit', [NewsController::class, 'show']);
Route::put('/news/{id}', [NewsController::class, 'update']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::get('categories/{id}/news', [CategoryController::class, 'getNewsByCategory']);
Route::post('categories/{id}/add-news', [CategoryController::class, 'storeNews']);
Route::delete('/news/{id}', [NewsController::class, 'destroy']);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});
