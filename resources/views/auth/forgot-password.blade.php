@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi - Bursa Tenaga Kerja')

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

    <div class="modal-auth-card">

        <h2 class="modal-auth-title">
            Lupa Kata Sandi?
        </h2>

        <p class="modal-auth-subtitle">
            Masukkan alamat email yang terdaftar. Kami akan
            mengirimkan tautan untuk mengatur ulang kata sandi Anda.
        </p>

        <div
            id="alertBox"
            class="alert d-none"
            role="alert"
        ></div>

        <form id="forgotPasswordForm">

            @csrf

            <div class="mb-4">

                <label class="auth-label">
                    Alamat Email
                </label>

                <input
                    type="email"
                    id="email"
                    class="form-control auth-input"
                    placeholder="contoh@email.com"
                    required
                >

            </div>

            <button
                type="submit"
                class="btn auth-primary-btn"
            >
                Kirim Tautan Pemulihan
            </button>

        </form>

        <div class="mt-4">
            <a
                href="/login"
                class="back-login-link"
            >
                ← Kembali ke halaman Login
            </a>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/auth.js') }}"></script>
@endpush