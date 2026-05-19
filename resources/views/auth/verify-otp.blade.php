@extends('layouts.auth')

@section('title', 'Verifikasi OTP - Bursa Tenaga Kerja')

@section('body-class', 'auth-overlay-page')
@section('auth-card-class', 'auth-card-transparent')
@section('hero-label', 'VERIFIKASI AKUN')

@section('hero-text')

    <h1>Find your job now!</h1>

    <p>
        Masukkan kode OTP untuk menyelesaikan proses pendaftaran akun Anda.
    </p>

@endsection

@section('auth-form')

<div class="modal-auth-overlay">

    <div class="modal-auth-card otp-card">

        <div class="otp-icon">
            <i class="bi bi-envelope-check"></i>
        </div>

        <h2 class="otp-title">
            Verifikasi Kode Keamanan
        </h2>

        <p class="otp-subtitle">
            Masukkan 6 digit kode yang telah dibuat untuk mengaktifkan akun Anda.
        </p>

        <div
            id="alertBox"
            class="alert d-none"
            role="alert"
        ></div>

        <form id="verifyOtpForm">

            @csrf

            <input
                type="hidden"
                id="verifyEmail"
            >

            <div class="otp-input-group">

                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">
                <input type="text" class="otp-input" maxlength="1" inputmode="numeric">

            </div>

            <input
                type="hidden"
                id="otpCode"
            >

            <small
                id="otpTestingInfo"
                class="otp-testing-info"
            ></small>

            <button
                type="submit"
                class="btn auth-primary-btn"
            >
                Verifikasi Sekarang
            </button>

        </form>

        <div class="mt-3">

            <button
                type="button"
                id="resendOtpBtn"
                class="otp-resend-btn"
            >
                Kirim Ulang Kode
            </button>

        </div>

        <div class="otp-timer">
            <i class="bi bi-stopwatch"></i>
            <span>Kode OTP berlaku selama <strong id="otpTimerText">--:--</strong></span>
        </div>

        <div class="otp-divider">
            ATAU
        </div>

        <a
            href="/login"
            class="back-login-link"
        >
            ← Kembali ke halaman masuk
        </a>

    </div>

</div>

@endsection

@push('scripts')

<script src="{{ asset('assets/js/auth.js') }}"></script>

@endpush