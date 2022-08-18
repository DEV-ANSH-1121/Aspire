<?php

use App\Http\Controllers\Api\Auth\AuthController;

// All route names are prefixed with 'auths.'
Route::group(['as' => 'auths.', 'prefix' => 'auth', 'middleware' => ['throttle:10,1']], function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login'); 
       
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
