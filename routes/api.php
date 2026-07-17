<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ItemLoanController;
use App\Http\Controllers\Api\ItemPickupController;
use App\Http\Controllers\Api\ItemRequestController;
use App\Http\Controllers\Api\JobDivisionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Take n Track / BPJS Inventory Barang
|--------------------------------------------------------------------------
*/

// ---------- Publik ----------
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ---------- Wajib login (Sanctum token) ----------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Katalog barang - semua role login boleh lihat
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{item}', [ItemController::class, 'show']);

    // Divisi - lihat saja untuk user biasa
    Route::get('/job-divisions', [JobDivisionController::class, 'index']);
    Route::get('/job-divisions/{jobDivision}', [JobDivisionController::class, 'show']);

    // Pengambilan barang
    Route::get('/item-pickups', [ItemPickupController::class, 'index']);
    Route::post('/item-pickups', [ItemPickupController::class, 'store']);
    Route::get('/item-pickups/{itemPickup}', [ItemPickupController::class, 'show']);

    // Peminjaman barang
    Route::get('/item-loans', [ItemLoanController::class, 'index']);
    Route::post('/item-loans', [ItemLoanController::class, 'store']);
    Route::get('/item-loans/{itemLoan}', [ItemLoanController::class, 'show']);
    Route::post('/item-loans/{itemLoan}/return', [ItemLoanController::class, 'returnItem']);

    // Permintaan barang baru
    Route::get('/item-requests', [ItemRequestController::class, 'index']);
    Route::post('/item-requests', [ItemRequestController::class, 'store']);
    Route::get('/item-requests/{itemRequest}', [ItemRequestController::class, 'show']);
    Route::delete('/item-requests/{itemRequest}', [ItemRequestController::class, 'destroy']);

    // ---------- Khusus admin (pakai middleware 'role' yang sudah ada di project) ----------
    Route::middleware('role:admin')->group(function () {
        Route::post('/items', [ItemController::class, 'store']);
        Route::put('/items/{item}', [ItemController::class, 'update']);
        Route::delete('/items/{item}', [ItemController::class, 'destroy']);

        Route::post('/job-divisions', [JobDivisionController::class, 'store']);
        Route::put('/job-divisions/{jobDivision}', [JobDivisionController::class, 'update']);
        Route::delete('/job-divisions/{jobDivision}', [JobDivisionController::class, 'destroy']);

        Route::delete('/item-pickups/{itemPickup}', [ItemPickupController::class, 'destroy']);
        Route::delete('/item-loans/{itemLoan}', [ItemLoanController::class, 'destroy']);

        Route::post('/item-requests/{itemRequest}/approve', [ItemRequestController::class, 'approve']);
        Route::post('/item-requests/{itemRequest}/reject', [ItemRequestController::class, 'reject']);

        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
});
