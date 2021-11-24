<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisteredUserController;
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

Route::group(['middleware' => 'api',], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [RegisteredUserController::class, 'store']);

    Route::group(['middleware' => 'auth'],function (){

        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('users',[RegisteredUserController::class,'index']);

    });
});
