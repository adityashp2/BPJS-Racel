<?php

use App\Http\Controllers\ItemRequestController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('item-requests', ItemRequestController::class);
});