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

    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp']);

    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    // Google Login
    Route::get('/google', [AuthController::class, 'redirectToGoogle']);

    Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);

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

    Route::get(
        '/admin/recruiters/pending',
        [AuthController::class, 'pendingRecruiters']
    );

    Route::get(
        '/admin/recruiters/{id}',
        [AuthController::class, 'showRecruiter']
    );

    Route::get(
        '/admin/recruiters/{id}/documents/{type}',
        [AuthController::class, 'viewRecruiterDocument']
    );

    Route::post(
        '/admin/recruiters/{id}/approve',
        [AuthController::class, 'approveRecruiter']
    );

    Route::post(
        '/admin/recruiters/{id}/reject',
        [AuthController::class, 'rejectRecruiter']
    );

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

Route::get('/test-jwt', function () {
    return response()->json([
        'user' => auth('api')->user(),
    ]);
})->middleware('auth:api');

use App\Http\Controllers\ProfileController;

Route::middleware('auth:api')->post(
    '/profile/update',
    [ProfileController::class, 'update']
);

use App\Http\Controllers\CvController;
// routes/api.php
Route::middleware('auth:api')->group(function () {
    Route::get('/cv/download-pdf', [CvController::class, 'downloadPDF']);
    Route::post('/cv/download-draft-pdf', [CvController::class, 'downloadDraftPDF']); // ← POST
});