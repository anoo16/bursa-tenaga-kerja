<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\JobController;

/*
|--------------------------------------------------------------------------
| Landing Page & Auth Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');

Route::view('/login', 'auth.login')->name('login');

Route::view('/register', 'auth.register');

Route::view('/register/recruiter', 'auth.register-recruiter');

Route::view('/verify-otp', 'auth.verify-otp');

Route::view('/forgot-password', 'auth.forgot-password');

Route::view('/verify-reset-otp', 'auth.verify-reset-otp');

Route::view('/reset-password', 'auth.reset-password');

Route::view('/auth/google/success', 'auth.google-success')->name('google.success');

Route::view('/auth/google/failed', 'auth.google-failed')->name('google.failed');


/*
|--------------------------------------------------------------------------
| Admin & Jobseeker Dashboard Web Routes
|--------------------------------------------------------------------------
*/

Route::view('/dashboard/admin', 'dashboard.admin');

Route::view('/dashboard/admin/recruiters/{id}', 'dashboard.admin-detail');

Route::view('/dashboard/jobseeker', 'dashboard.jobseeker');

// Redirect the placeholder recruiter dashboard to the real company dashboard
Route::get('/dashboard/recruiter', function () {
    return redirect()->route('company.dashboard');
});


/*
|--------------------------------------------------------------------------
| Company / Recruiter Real Dashboard Web Routes (Your Project)
|--------------------------------------------------------------------------
*/

Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
Route::get('/company/profile', [CompanyDashboardController::class, 'profile'])->name('company.profile');
Route::get('/company/profile/edit', [CompanyDashboardController::class, 'editProfile'])->name('company.profile.edit');
Route::put('/company/profile', [CompanyDashboardController::class, 'updateProfile'])->name('company.profile.update');


// RUTE KELOLA LOWONGAN

// menampilkan halaman kelola lowongan
Route::get(
    '/company/jobs',
    [JobController::class,'index']
)->name('company.jobs');


// menyimpan lowongan baru
Route::post(
    '/company/jobs',
    [JobController::class,'store']
)->name('company.jobs.store');

// mengupdate lowongan
Route::put(
    '/company/jobs/{job}',
    [JobController::class,'update']
)->name('company.jobs.update');

// mengubah status aktif/tutup
Route::patch(
    '/company/jobs/{job}/toggle-status',
    [JobController::class,'toggleStatus']
)->name('company.jobs.toggle');

// menghapus lowongan
Route::delete(
    '/company/jobs/{job}',
    [JobController::class,'destroy']
)->name('company.jobs.delete');

// RUTE PELAMAR MASUK
Route::get('/company/applicants', [CompanyDashboardController::class, 'applicants'])->name('company.applicants');