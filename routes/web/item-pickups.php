<?php

use App\Http\Controllers\ItemPickupController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'hasDivision'])->group(function () {
    Route::get('item-pickups/report', [ItemPickupController::class, 'report'])->name('item-pickups.report');
    Route::resource('item-pickups', ItemPickupController::class);
});
