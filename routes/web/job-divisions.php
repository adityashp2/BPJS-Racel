<?php

use App\Http\Controllers\JobDivisionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('job-divisions', JobDivisionController::class);
});
