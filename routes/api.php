<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api',], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [RegisteredUserController::class, 'store']);

    Route::group(['middleware' => 'auth'],function (){

        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);

        Route::get('users',[RegisteredUserController::class,'index']);

    });
});
