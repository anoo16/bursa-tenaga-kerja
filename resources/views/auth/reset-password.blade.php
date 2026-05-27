@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru - Bursa Tenaga Kerja')

@section('body-class', 'auth-overlay-page')
@section('auth-card-class', 'auth-card-transparent')
@section('hero-label', 'MITRA STRATEGIS')

@section('hero-text')

    <h1>Find your job now!</h1>

    <p>
        Menghubungkan ribuan pencari kerja dengan Perusahaan terbaik.
        Proses Rekrutmen yang Cepat, Transparan, dan Terstruktur.
    </p>

@endsection

@section('auth-form')

<div class="modal-auth-overlay">

    <div class="modal-auth-card reset-card">

        <div class="modal-badge">
            OTP Terverifikasi
        </div>

        <h2 class="modal-auth-title">
            Buat Kata Sandi Baru
        </h2>

        <p class="modal-auth-subtitle">
            Silakan buat kata sandi baru yang kuat untuk
            mengamankan akun Anda kembali.
        </p>

        <div
            id="alertBox"
            class="alert d-none"
            role="alert"
        ></div>

        <form id="resetPasswordForm">

            @csrf

            <div class="mb-4">

                <label class="auth-label">
                    Kata Sandi Baru
                </label>

                <div class="password-input-wrapper">
                    <input
                        type="password"
                        id="password"
                        class="form-control auth-input"
                        placeholder="••••••••"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(this)"
                    >
                        👁
                    </button>
                </div>

            </div>

            <div class="mb-4">

                <label class="auth-label">
                    Konfirmasi Kata Sandi
                </label>

                <div class="password-input-wrapper">
                    <input
                        type="password"
                        id="confirmPassword"
                        class="form-control auth-input"
                        placeholder="••••••••"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        onclick="togglePassword(this)"
                    >
                        👁
                    </button>
                </div>

            </div>

            <div class="password-rule-box">
                <div>
                    <span class="password-rule-icon">ⓘ</span>
                    <span>Minimal 6 karakter</span>
                </div>
                <div>
                    <span class="password-rule-icon">ⓘ</span>
                    <span>Gunakan kombinasi huruf & angka</span>
                </div>
            </div>

            <button
                type="submit"
                class="btn auth-primary-btn mt-4"
            >
                Perbarui Kata Sandi
            </button>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush