<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::post('login',[UserController::class,'login']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('categories',[CategoryController::class,'store']);
Route::get('categories',[CategoryController::class,'index']);
Route::get('categories/{category}',[CategoryController::class,'show']);

Route::post('products',[ProductController::class,'store']);
Route::get('products',[ProductController::class,'index']);
Route::get('products/{product}',[ProductController::class,'show']);

Route::post('users/register',[UserController::class,'register']);

Route::patch('users/{user}',[UserController::class,'update']);
