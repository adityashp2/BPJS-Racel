<?php

use App\Http\Controllers\ItemLoanController;
use Illuminate\Support\Facades\Route;

Route::prefix('apps')->group(function () {
    Route::resource('item-loans', ItemLoanController::class);
});