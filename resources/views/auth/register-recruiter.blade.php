@extends('layouts.auth')

@section('title', 'Daftar Recruiter - Bursa Tenaga Kerja')

@section('hero-label', 'MITRA STRATEGIS')

@section('hero-text')

    <div class="hero-custom">

        <h1>
            Bangun Tim <br>
            Impian Anda.
        </h1>

        <p>
            Masuk ke portal rekrutmen eksklusif Bursa Tenaga Kerja
            untuk mengelola kandidat dan galeri karir perusahaan Anda.
        </p>

        <!-- BENEFIT 1 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                🌎
            </div>

            <div>
                <h5>Jangkauan Luas</h5>

                <span>
                    Akses ke ribuan kandidat berkualitas dari berbagai spesialisasi.
                </span>
            </div>

        </div>

        <!-- BENEFIT 2 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                🔒
            </div>

            <div>
                <h5>Keamanan S3 Cloud</h5>

                <span>
                    Dokumen CV Anda disimpan dengan aman menggunakan AWS Cloud.
                </span>
            </div>

        </div>

        <!-- BENEFIT 3 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                📊
            </div>

            <div>
                <h5>Data-Driven Insight</h5>

                <span>
                    Pantau performa lowongan Anda dengan dashboard analytics realtime.
                </span>
            </div>

        </div>

    </div>

@endsection

@section('auth-form')

    <div class="register-wrapper">

        <!-- TITLE -->
        <div class="mb-4">

            <h2 class="register-title">
                Daftar Akun Recruiter
            </h2>

            <p class="register-subtitle">
                Lengkapi detail perusahaan Anda untuk memulai.
            </p>

        </div>

        <!-- ALERT -->
        <div
            id="alertBox"
            class="alert d-none"
            role="alert"
        ></div>

        <!-- FORM -->
        <form id="recruiterRegisterForm">

            @csrf

            <!-- ROLE -->
            <div class="mb-3">

                <label class="custom-label">
                    PERAN AKUN
                </label>

                <input
                    type="text"
                    class="form-control"
                    value="Perusahaan / Recruiter"
                    readonly
                >

                <small
                    style="
                        color: #1A4885;
                        font-size: 12px;
                    "
                >
                    *Anda mendaftar khusus untuk portal pemberi kerja.
                </small>

            </div>

            <!-- ROW PROFILE -->
            <div class="row">

                <!-- PIC -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        NAMA LENGKAP PIC
                    </label>

                    <input
                        type="text"
                        id="pic_name"
                        class="form-control"
                        placeholder="Contoh: Budi Santoso"
                        required
                    >

                </div>

                <!-- COMPANY -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        NAMA PERUSAHAAN
                    </label>

                    <input
                        type="text"
                        id="company_name"
                        class="form-control"
                        placeholder="Contoh: PT Maju Bersama"
                        required
                    >

                </div>

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label class="custom-label">
                    EMAIL BISNIS
                </label>

                <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="hrd@perusahaan.com"
                    required
                >

            </div>

            <!-- ROW PASSWORD -->
            <div class="row">

                <!-- PASSWORD -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        KATA SANDI
                    </label>

                    <div class="password-input-wrapper">

                        <input
                            type="password"
                            id="password"
                            class="form-control"
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

                <!-- CONFIRM PASSWORD -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        KONFIRMASI SANDI
                    </label>

                    <div class="password-input-wrapper">

                        <input
                            type="password"
                            id="confirmPassword"
                            class="form-control"
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

            </div>

            <!-- CHECKBOX -->
            <div class="form-check mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="agree"
                    required
                >

                <label
                    class="form-check-label"
                    for="agree"
                    style="
                        font-size: 13px;
                        color: #64748B;
                    "
                >
                    Saya setuju dengan
                    <a href="#">Syarat & Ketentuan</a>
                    serta
                    <a href="#">Kebijakan Privasi</a>
                </label>

            </div>

            <!-- BUTTON -->
            <button
                type="submit"
                class="btn register-btn"
            >
                Daftar Sekarang
            </button>

        </form>

        <!-- LOGIN -->
        <div class="text-center mt-4">

            <span style="color: #64748B;">
                Sudah memiliki akun?
            </span>

            <a
                href="/login"
                class="text-decoration-none fw-semibold"
                style="color: #1A4885;"
            >
                Login di sini
            </a>

        </div>

    </div>

@endsection

@push('scripts')

    <script src="{{ asset('assets/js/auth.js') }}"></script>

@endpush