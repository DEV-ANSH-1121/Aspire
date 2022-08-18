<?php

use App\Http\Controllers\Api\Loan\LoanController;


// All route names are prefixed with 'loan.'
Route::group(['as' => 'loan.', 'prefix' => 'loan', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/storeLoan', [LoanController::class, 'storeLoan'])->name('storeLoan');
    Route::post('/loanRepayment', [LoanController::class, 'loanRepayment'])->name('loanRepayment');
});
