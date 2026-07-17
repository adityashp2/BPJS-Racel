<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::resource('items', ItemController::class);
    Route::get('item-gallery', [ItemController::class, 'itemGallery'])->name('items.item-gallery');
});
