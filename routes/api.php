<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    // Public Routes
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Protected Routes
    Route::middleware('auth:api')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/refresh', [AuthController::class, 'refresh']);

        Route::get('/me', [AuthController::class, 'me']);

    });

});


/*
|--------------------------------------------------------------------------
| Role Middleware Routes
|--------------------------------------------------------------------------
*/

// Admin Routes
Route::middleware(['auth:api', 'role:1'])->group(function () {

    Route::get('/admin/dashboard', function () {

        return response()->json([

            'success' => true,

            'message' => 'Welcome Admin'

        ]);
    });

});


// Company Routes
Route::middleware(['auth:api', 'role:2'])->group(function () {

    Route::get('/company/dashboard', function () {

        return response()->json([

            'success' => true,

            'message' => 'Welcome Company'

        ]);
    });

});


// Jobseeker Routes
Route::middleware(['auth:api', 'role:3'])->group(function () {

    Route::get('/jobseeker/dashboard', function () {

        return response()->json([

            'success' => true,

            'message' => 'Welcome Jobseeker'

        ]);
    });

});