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
use App\Http\Controllers\EmailMonitorController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminQuoteController;
use App\Http\Controllers\Admin\AdminShipmentController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminDocumentController;

Route::post('/contact', [ContactController::class, 'send'])->middleware('throttle:10,1');

Route::prefix('auth')->middleware('throttle:20,1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/resend-verification-email', [AuthController::class, 'resendVerificationEmail']);
});

// Email verification route (public, uses signed URL)
Route::get('/auth/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

// Email monitoring endpoints (for development/testing - local environment only)
Route::prefix('debug/email')
    ->middleware(function ($request, $next) {
        if (!app()->environment('local')) {
            return response()->json(['error' => 'Not available in this environment'], 403);
        }
        return $next($request);
    })
    ->group(function () {
        Route::get('/logs', [EmailMonitorController::class, 'logs']);
        Route::get('/status/{email}', [EmailMonitorController::class, 'status']);
        Route::get('/test-users', [EmailMonitorController::class, 'testUsers']);
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
    Route::post('/quotes/bulk/approve', [QuoteController::class, 'bulkApprove']);
    Route::post('/quotes/bulk/reject',  [QuoteController::class, 'bulkReject']);

    // Shipments
    Route::get('/shipments', [ShipmentController::class, 'index']);

    // Documents
    Route::get('/documents',              [DocumentController::class, 'index']);
    Route::post('/documents',             [DocumentController::class, 'store']);
    Route::delete('/documents/{document}',[DocumentController::class, 'destroy']);

    // Messages (per sourcing request)
    Route::get('/sourcing-requests/{sourcingRequest}/messages',  [MessageController::class, 'index']);
    Route::post('/sourcing-requests/{sourcingRequest}/messages', [MessageController::class, 'store']);
    
    // Analytics & Analytics
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics']);
    Route::get('/dashboard/supplier-performance', [DashboardController::class, 'supplierPerformance']);
    
    // Activity logs
    Route::get('/activity-logs', [DashboardController::class, 'activityLogs']);
});

// Admin routes
Route::prefix('admin')->middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/stats', [AdminStatsController::class, 'index']);

    Route::get('/users',        [AdminUserController::class, 'index']);
    Route::get('/users/{user}', [AdminUserController::class, 'show']);

    Route::get('/sourcing-requests',                                    [AdminRequestController::class, 'index']);
    Route::get('/sourcing-requests/{sourcingRequest}',                  [AdminRequestController::class, 'show']);
    Route::patch('/sourcing-requests/{sourcingRequest}/status',         [AdminRequestController::class, 'updateStatus']);

    Route::get('/quotes',            [AdminQuoteController::class, 'index']);
    Route::post('/quotes',           [AdminQuoteController::class, 'store']);
    Route::put('/quotes/{quote}',    [AdminQuoteController::class, 'update']);
    Route::delete('/quotes/{quote}', [AdminQuoteController::class, 'destroy']);

    Route::get('/shipments',              [AdminShipmentController::class, 'index']);
    Route::post('/shipments',             [AdminShipmentController::class, 'store']);
    Route::put('/shipments/{shipment}',   [AdminShipmentController::class, 'update']);

    Route::get('/documents',                 [AdminDocumentController::class, 'index']);
    Route::post('/documents',                [AdminDocumentController::class, 'store']);
    Route::delete('/documents/{document}',   [AdminDocumentController::class, 'destroy']);

    Route::get('/messages',                                                      [AdminMessageController::class, 'threads']);
    Route::get('/sourcing-requests/{sourcingRequest}/messages',                  [AdminMessageController::class, 'index']);
    Route::post('/sourcing-requests/{sourcingRequest}/messages',                 [AdminMessageController::class, 'store']);
});
