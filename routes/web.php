<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/login', 'auth.login');

Route::view('/register', 'auth.register');

Route::view('/register/recruiter', 'auth.register-recruiter');

Route::view('/verify-otp', 'auth.verify-otp');

Route::view('/forgot-password', 'auth.forgot-password');

Route::view('/verify-reset-otp', 'auth.verify-reset-otp');

Route::view('/reset-password', 'auth.reset-password');

Route::view('/auth/google/success', 'auth.google-success')->name('google.success');

Route::view('/auth/google/failed', 'auth.google-failed')->name('google.failed');

Route::middleware(['auth:api', 'role:1'])->group(function () {

    Route::view('/dashboard/admin', 'dashboard.admin');

});

Route::middleware(['auth:api', 'role:2'])->group(function () {

    Route::view('/dashboard/recruiter', 'dashboard.recruiter');

});

Route::middleware(['auth:api', 'role:3'])->group(function () {

    Route::view('/dashboard/jobseeker', 'dashboard.jobseeker');

});