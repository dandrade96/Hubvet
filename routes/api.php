<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SupermarketController;
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
Route::get('/login', function(){
    return response()->json([
        'success' => false,
        'message' => 'Unauthorized'
    ], 401);
})->name('login');
Route::post('/login', [ AuthController::class, 'login' ]);
Route::post('/register', [ AuthController::class, 'register' ]);
Route::get('/logout', [ AuthController::class, 'logout' ])->middleware('auth:api');
Route::middleware('auth:api')->prefix('supermarket')->group(function(){
    Route::get('/home', [ SupermarketController::class, 'index' ]);

    Route::resource('markets', '\App\Http\Controllers\MarketController');
    Route::resource('sectors','\App\Http\Controllers\SectorController');
    Route::resource('products','\App\Http\Controllers\ProductController');
});