<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Loan\LoanController;

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

// All route names are prefixed with 'admin.'
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:sanctum','IsAdmin']], function () {
    Route::get('/getAllLoans', [AdminController::class, 'getAllLoans'])->name('getAllLoans');
    Route::post('/updateLoanStatus', [AdminController::class, 'updateLoanStatus'])->name('updateLoanStatus');
});

// All route names are prefixed with 'auths.'
Route::group(['as' => 'auths.', 'prefix' => 'auth', 'middleware' => ['throttle:10,1']], function () {

    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login'); 
       
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// All route names are prefixed with 'loan.'
Route::group(['as' => 'loan.', 'prefix' => 'loan', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/storeLoan', [LoanController::class, 'storeLoan'])->name('storeLoan');
    Route::post('/loanRepayment', [LoanController::class, 'loanRepayment'])->name('loanRepayment');
    Route::post('/getLoansByStatus', [LoanController::class, 'getLoansByStatus'])->name('getLoansByStatus');
});