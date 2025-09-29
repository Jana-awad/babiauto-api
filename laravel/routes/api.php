<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\FeatureController;
use App\Http\Controllers\API\InsuranceController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\VehicleFeatureController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\NotificationController as ControllersNotificationController;
use App\Http\Controllers\API\FCMController;

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public Routes (no auth needed)
Route::get('/vehicles', [VehicleController::class, 'index']);
Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
Route::get('/bookings', [BookingController::class, 'index']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::get('/features', [FeatureController::class, 'index']);
Route::get('/features/{id}', [FeatureController::class, 'show']);
Route::get('/insurances', [InsuranceController::class, 'index']);
Route::get('/insurances/{id}', [InsuranceController::class, 'show']);
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
// Protected Routes (auth required)
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', fn(Request $request) => $request->user());

    Route::put('/profile', function (Request $request) {
        $user = $request->user();

        // Validate input
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
        ]);

        // Update user
        $user->update($request->only('name', 'email'));

        return response()->json($user);
    });

    Route::post('/save-device-token', [ControllersNotificationController::class, 'saveDeviceToken']);
    // Only Admin can manage vehicles, insurances, and payments
    Route::middleware(['role:admin'])->group(function () {
        Route::apiResource('vehicles', VehicleController::class)->except(['index', 'show']);
        Route::apiResource('insurances', InsuranceController::class)->except(['index', 'show']);

        // Vehicle Feature pivot APIs
        Route::get('/vehicles/{id}/features', [VehicleFeatureController::class, 'index']);
        Route::post('/vehicles/{id}/features/attach', [VehicleFeatureController::class, 'attach']);
        Route::post('/vehicles/{id}/features/detach', [VehicleFeatureController::class, 'detach']);
        Route::post('/vehicles/{id}/features/sync', [VehicleFeatureController::class, 'sync']);
    });

    // Bookings can be managed by authenticated users
    Route::apiResource('bookings', BookingController::class)->except(['index', 'show']);
    Route::get('/users/{userId}/bookings', [BookingController::class, 'bookingsByUser']);
    Route::apiResource('payments', PaymentController::class)->except(['index', 'show']);

    // Users CRUD
    Route::middleware(['role:admin'])->apiResource('users', UserController::class);

    // Features CRUD
    Route::middleware(['role:admin'])->apiResource('features', FeatureController::class);
});
