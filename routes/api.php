<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarApiController;
use App\Http\Controllers\Api\RentalApiController;
use App\Http\Controllers\Api\LocationApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\GpsController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', function () {
    $routes = collect(Route::getRoutes())->filter(function ($route) {
        // Hanya ambil route yang berawalan 'api' tapi bukan root '/api' itu sendiri
        return str_starts_with($route->uri(), 'api') && $route->uri() !== 'api';
    })->map(function ($route) {
        return [
            'method' => implode('|', array_filter($route->methods(), fn($m) => $m !== 'HEAD')),
            'uri' => '/' . $route->uri(),
            'auth_required' => in_array('auth:sanctum', $route->middleware()) || in_array('auth', $route->middleware()),
        ];
    })->values();

    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to Roamie Rentcar API',
        'version' => '1.0.0',
        'endpoints' => $routes
    ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// Public GPS endpoints (no auth needed for real-time simulation)
Route::post('/gps/update', [GpsController::class, 'update']);
Route::get('/gps/all',     [GpsController::class, 'all']);

// ── Midtrans Notification Webhook (HARUS public, tidak pakai auth) ────────────
// Midtrans server akan hit endpoint ini setelah user bayar
Route::post('/payment/notification', [PaymentController::class, 'notification']);

// ── Protected Routes (auth:sanctum) ──────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // Car Listing & Detail
    Route::get('/cars',       [CarApiController::class, 'index']);
    Route::get('/cars/{id}',  [CarApiController::class, 'show']);

    // Rental lama (masih bisa digunakan)
    Route::post('/rentals', [RentalApiController::class, 'store']);

    // ── Payment / Booking Flow ──────────────────────────────────────────────
    // [1] Upload bukti transfer manual
    Route::post('/payment/upload-proof', [PaymentController::class, 'uploadProof']);

    // [2] Cek status pembayaran sebuah rental
    Route::get('/payment/status/{rentalId}', [PaymentController::class, 'status']);

    // [3] Daftar semua rental milik user yang login
    Route::get('/my-rentals', [PaymentController::class, 'myRentals']);

    // [4] Generate Midtrans snap token
    Route::post('/payment/token', [PaymentController::class, 'getSnapToken']);

    // GPS & Location
    Route::post('/location/update', [LocationApiController::class, 'update']);

    // Dashboard Admin
    Route::get('/dashboard/stats', [DashboardApiController::class, 'index']);

    // User profile update
    Route::put('/users/{id}', [AuthController::class, 'updateProfile']);
    Route::post('/users/{id}/avatar', [AuthController::class, 'uploadAvatar']);

    // Chatbot AI
    Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat']);
});

