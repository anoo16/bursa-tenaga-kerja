<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JobseekerDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CvController;

Route::view('/', 'welcome');

Route::view('/login','auth.login')
    ->name('login');

Route::view('/register','auth.register');

Route::view(
    '/register/recruiter',
    'auth.register-recruiter'
);

Route::view(
    '/verify-otp',
    'auth.verify-otp'
);

Route::view(
    '/forgot-password',
    'auth.forgot-password'
);

Route::view(
    '/verify-reset-otp',
    'auth.verify-reset-otp'
);

Route::view(
    '/reset-password',
    'auth.reset-password'
);

Route::view(
    '/auth/google/success',
    'auth.google-success'
)->name('google.success');

Route::view(
    '/auth/google/failed',
    'auth.google-failed'
)->name('google.failed');

Route::view(
    '/dashboard/admin',
    'dashboard.admin'
);

Route::view(
    '/dashboard/recruiter',
    'dashboard.recruiter'
);


// JOBSEEKER
Route::middleware([])
->get(
'/dashboard/jobseeker',
[JobseekerDashboardController::class,'index']
)
->name('dashboard');


// PROFILE
    Route::get(
        '/profile',
        [ProfileController::class,'index']
    )->name('profile');

    Route::get(
        '/profile/edit',
        [ProfileController::class,'edit']
    )->name('jobseeker.profile-edit');

    Route::post(
        '/profile/edit',
        [ProfileController::class,'update']
    )->name('profile.update');


// CV
Route::prefix('cv')
->name('cv.')
->group(function(){

    Route::get(
        '/templates',
        [CvController::class,'templates']
    )->name('templates');

    Route::post(
        '/templates/select',
        [CvController::class,'selectTemplate']
    )->name('templates.select');

    Route::get(
        '/edit',
        [CvController::class,'edit']
    )->name('edit');

    Route::put(
        '/update',
        [CvController::class,'update']
    )->name('update');

    Route::get(
        '/preview',
        [CvController::class,'preview']
    )->name('preview');

    Route::delete(
        '/section/{section}/{id}',
        [CvController::class,'deleteSection']
    )->name('section.delete');

});