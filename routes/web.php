<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobseekerDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/login', 'auth.login')
    ->name('login');

Route::view('/register', 'auth.register');

Route::view(
    '/register/recruiter',
    'auth.register-recruiter'
);

Route::view('/terms', 'legal.terms')->name('terms');

Route::view('/privacy-policy', 'legal.privacy')->name('privacy.policy');

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

// JOBSEEKER
Route::middleware([])
    ->get(
        '/dashboard/jobseeker',
        [JobseekerDashboardController::class, 'index']
    )
    ->name('dashboard');

// PROFILE
Route::get(
    '/profile',
    [ProfileController::class, 'index']
)->name('profile');

Route::get(
    '/profile/edit',
    [ProfileController::class, 'edit']
)->name('jobseeker.profile-edit');

Route::post(
    '/profile/edit',
    [ProfileController::class, 'update']
)->name('profile.update');

// CV
Route::prefix('cv')
    ->name('cv.')
    ->group(function () {
        Route::get(
            '/templates',
            [CvController::class, 'templates']
        )->name('templates');

        Route::post(
            '/templates/select',
            [CvController::class, 'selectTemplate']
        )->name('templates.select');

        Route::get(
            '/edit',
            [CvController::class, 'edit']
        )->name('edit');

        Route::put(
            '/update',
            [CvController::class, 'update']
        )->name('update');

        Route::get(
            '/preview',
            [CvController::class, 'preview']
        )->name('preview');

        Route::post(
        '/preview-draft',
        [CvController::class, 'previewDraft']
        )->name('preview.draft');

        Route::get(
        '/preview-draft/show',
        [CvController::class, 'showPreview']
        )->name('preview.show');

        Route::delete(
            '/section/{section}/{id}',
            [CvController::class, 'deleteSection']
        )->name('section.delete');
    });

// Application job
Route::middleware([])
    ->group(function () {
        Route::get(
            '/applications',
            [ApplicationController::class, 'index']
        )->name('applications.lamaran-saya');

        Route::post(
            '/applications/store',
            [ApplicationController::class, 'store']
        )->name('applications.store');

        Route::get(
            '/applications/success',
            [App\Http\Controllers\ApplicationController::class, 'success']
        )->name('applications.success');

        Route::get(
            '/applications/{id}',
            [ApplicationController::class, 'show']
        )->name('applications.show');

        Route::post(
            '/applications/{id}/withdraw',
            [ApplicationController::class, 'withdraw']
        )->name('applications.withdraw');

        // CARI LOWONGAN
        Route::get(
            '/jobs',
            [App\Http\Controllers\JobSearchController::class, 'index']
        )->name('jobs.index');

        // DETAIL LOWONGAN
        Route::get(
            '/jobs/{job}',
            [App\Http\Controllers\JobSearchController::class, 'show']
        )->name('jobs.show');

        // SIMPAN LOWONGAN
        Route::get(
            '/jobseeker/simpan',
            [App\Http\Controllers\SavedJobController::class, 'index']
        )->name('jobseeker.simpan');
        
        Route::post(
            '/jobs/{jobId}/simpan',
            [App\Http\Controllers\SavedJobController::class, 'toggle']
        )->name('jobseeker.simpan.toggle');
        
        Route::delete(
            '/jobseeker/simpan/{savedId}',
            [App\Http\Controllers\SavedJobController::class, 'remove']
        )->name('jobseeker.simpan.remove');
        
        Route::delete(
            '/jobseeker/simpan',
            [App\Http\Controllers\SavedJobController::class, 'clearAll']
        )->name('jobseeker.simpan.clear');
    });

/*
 * |--------------------------------------------------------------------------
 * | Company / Recruiter Real Dashboard Web Routes
 * |--------------------------------------------------------------------------
 */

Route::get('/dashboard/perusahaan', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
Route::get('/profil/perusahaan', [CompanyDashboardController::class, 'profile'])->name('company.profile');
Route::get('/profil/edit/perusahaan', [CompanyDashboardController::class, 'editProfile'])->name('company.profile.edit');
Route::put('/profil/perusahaan', [CompanyDashboardController::class, 'updateProfile'])->name('company.profile.update');

// RUTE KELOLA LOWONGAN
// menampilkan halaman kelola lowongan
Route::middleware([])
    ->group(function () {
        Route::get(
            '/company/jobs',
            [JobController::class, 'index']
        )->name('company.jobs');

        // menyimpan lowongan baru
        Route::post(
            '/company/jobs',
            [JobController::class, 'store']
        )->name('company.jobs.store');

        // mengupdate lowongan
        Route::put(
            '/company/jobs/{job}',
            [JobController::class, 'update']
        )->name('company.jobs.update');

        // mengubah status aktif/tutup
        Route::patch(
            '/company/jobs/{job}/toggle-status',
            [JobController::class, 'toggleStatus']
        )->name('company.jobs.toggle');

        // menghapus lowongan
        Route::delete(
            '/company/jobs/{job}',
            [JobController::class, 'destroy']
        )->name('company.jobs.delete');
    });

// RUTE PELAMAR MASUK
Route::get(
    '/company/applicants',
    [CompanyDashboardController::class, 'applicants']
)->name('company.applicants');

Route::get(
    '/company/applicants/{id}',
    [CompanyDashboardController::class, 'showApplicant']
)->name('company.applicant.show');

Route::get(
    '/company/applicants/{id}/review',
    [CompanyDashboardController::class, 'reviewApplicant']
)->name('company.applicant.review');

Route::patch(
    '/company/applicants/{id}/status',
    [CompanyDashboardController::class, 'updateApplicantStatus']
)->name('company.applicant.update-status');
