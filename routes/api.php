<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/upload',[ImageController::class,'upload']);

Route::group(['middleware'=>['auth:sanctum']],function() {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/profilepic/{filename}',[ImageController::class,'profile'])->where('filename','.*');
    Route::get('/bills',[BillController::class,'bills']);
    Route::get('/bill/{refnum}',[BillController::class,'bill']);
    Route::get('/billers',[BillerController::class,'billers']);
    Route::get('/profilepic/{filename}',[ImageController::class,'profile']);
    Route::get('/profile',[ProfileController::class,'viewProfile']);
    Route::get('/alltransactions',[TransactionController::class,'alltransactions']);
    Route::get('/transactions',[TransactionController::class,'transactions']);
    Route::get('/transaction/{id}',[TransactionController::class,'transaction']);
    Route::post('/pay',[TransactionController::class,'pay']);
    Route::put('/refund',[TransactionController::class,'refund']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
