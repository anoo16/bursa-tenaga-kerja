<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/login', 'auth.login');

Route::view('/register', 'auth.register');

Route::view('/register/recruiter', 'auth.register-recruiter');

Route::view('/forgot-password', 'auth.forgot-password');

Route::view('/reset-password', 'auth.reset-password');

Route::middleware(['auth:api', 'role:1'])->group(function () {

    Route::view('/dashboard/admin', 'dashboard.admin');

});

Route::middleware(['auth:api', 'role:2'])->group(function () {

    Route::view('/dashboard/recruiter', 'dashboard.recruiter');

});

Route::middleware(['auth:api', 'role:3'])->group(function () {

    Route::view('/dashboard/jobseeker', 'dashboard.jobseeker');

});