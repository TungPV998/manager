<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiEmployeeController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('employee')->group(function () {
    Route::get('/index',[ApiEmployeeController::class, 'index']);
    Route::get('/show/{id}',[ApiEmployeeController::class, 'show']);
    Route::get('/path/',[ApiEmployeeController::class, 'getImagePath']);
    Route::delete('/delete/{id}',[ApiEmployeeController::class, 'destroy']);
    Route::post('/store',[ApiEmployeeController::class, 'store']);
    Route::put('/update/{id}',[ApiEmployeeController::class, 'update']);
});
//Route::get('/index',[EmployeeController::class, 'index']);
