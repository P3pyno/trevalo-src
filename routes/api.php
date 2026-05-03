<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SourcingRequestController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;

Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:10,1');

Route::prefix('auth')->middleware('throttle:20,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',      [AuthController::class, 'me']);

    // User profile
    Route::get('/user',           [UserController::class, 'show']);
    Route::put('/user/profile',   [UserController::class, 'updateProfile']);
    Route::put('/user/password',  [UserController::class, 'changePassword']);
    Route::delete('/user',        [UserController::class, 'deleteAccount']);

    // Dashboard stats
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);

    // Sourcing requests
    Route::get('/sourcing-requests',              [SourcingRequestController::class, 'index']);
    Route::post('/sourcing-requests',             [SourcingRequestController::class, 'store']);
    Route::get('/sourcing-requests/{sourcingRequest}', [SourcingRequestController::class, 'show']);
    Route::patch('/sourcing-requests/{sourcingRequest}/cancel', [SourcingRequestController::class, 'cancel']);

    // Quotes
    Route::get('/quotes',               [QuoteController::class, 'index']);
    Route::patch('/quotes/{quote}/approve', [QuoteController::class, 'approve']);
    Route::patch('/quotes/{quote}/reject',  [QuoteController::class, 'reject']);

    // Shipments
    Route::get('/shipments', [ShipmentController::class, 'index']);

    // Documents
    Route::get('/documents', [DocumentController::class, 'index']);

    // Messages (per sourcing request)
    Route::get('/sourcing-requests/{sourcingRequest}/messages',  [MessageController::class, 'index']);
    Route::post('/sourcing-requests/{sourcingRequest}/messages', [MessageController::class, 'store']);
});
