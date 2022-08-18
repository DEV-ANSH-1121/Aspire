<?php

use App\Http\Controllers\Api\Admin\AdminController;


// All route names are prefixed with 'admin.'
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/updateLoanStatus', [AdminController::class, 'updateLoanStatus'])->name('updateLoanStatus');
});
