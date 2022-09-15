<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::post('/login', [ AuthController::class, 'login' ])->name('login');
Route::post('/register', [ AuthController::class, 'register' ])->name('register');
Route::get('/logout', [ AuthController::class, 'logout' ])->name('logout');
Route::prefix('/supermarket')->group(function(){
    Route::get('/', [ SupermarketController::class, 'index' ]);

    Route::post('/create/market', [ MarketController::class, 'insert'])->name('marketInsert');
    Route::put('/update/market', [ MarketController::class, 'update'])->name('marketUpdate');
    Route::get('/delete/market', [ MarketController::class, 'delete'])->name('marketDelete');

    Route::post('/create/sector', [ SectorController::class, 'insert'])->name('sectorInsert');
    Route::put('/update/sector', [ SectorController::class, 'update'])->name('sectorUpdate');
    Route::get('/delete/sector', [ SectorController::class, 'delete'])->name('sectorDelete');

    Route::post('/create/product', [ ProductController::class, 'insert'])->name('productInsert');
    Route::put('/update/product', [ ProductController::class, 'update'])->name('productUpdate');
    Route::get('/delete/product', [ ProductController::class, 'delete'])->name('productDelete');
});