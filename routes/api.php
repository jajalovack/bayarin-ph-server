<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;

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

Route::group(['middleware'=>['auth:sanctum']],function() {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/upload',[ImageController::class,'upload']);
    Route::get('/profilepic/{filename}',[ImageController::class,'profile']);
    Route::get('/bills',[BillController::class,'bills']);
    Route::get('/bill/{id}',[BillController::class,'bill']);
    Route::get('/profile/{id}',[ProfileController::class,'viewProfile']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
