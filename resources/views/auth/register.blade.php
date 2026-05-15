@extends('layouts.auth')

@section('title', 'Daftar Job Seeker - Bursa Tenaga Kerja')

@section('hero-label', 'MITRA STRATEGIS')

@section('hero-text')

    <div class="hero-custom">

        <h1>
            Find your job <br>
            now!
        </h1>

        <p>
            Menghubungkan ribuan pencari kerja dengan Perusahaan terbaik.
            Proses Rekrutmen yang Cepat, Transparan, dan Terstruktur.
        </p>

        <!-- BENEFIT 1 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                <i class="bi bi-people-fill"></i>
            </div>

            <div>
                <h5>Perusahaan Terverifikasi</h5>

                <span>
                    Hanya perusahaan terbaik yang dapat memposting.
                </span>
            </div>

        </div>

        <!-- BENEFIT 2 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                <i class="bi bi-speedometer2"></i>
            </div>

            <div>
                <h5>Proses Cepat</h5>

                <span>
                    Dapatkan respon dalam rata-rata 3 hari kerja.
                </span>
            </div>

        </div>

        <!-- BENEFIT 3 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                 <i class="bi bi-window-stack"></i>
            </div>

            <div>
                <h5>Keamanan S3 Cloud</h5>

                <span>
                    Dokumen CV Anda disimpan dengan aman menggunakan AWS Cloud.
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
                Daftar Akun Job Seeker
            </h2>

            <p class="register-subtitle">
                Lengkapi detail diri Anda untuk memulai.
            </p>

        </div>

        <!-- ALERT -->
        <div
            id="alertBox"
            class="alert d-none"
            role="alert"
        ></div>

        <!-- FORM -->
        <form id="registerForm">

            @csrf

            <!-- ROW PROFILE -->
            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        NAMA LENGKAP
                    </label>

                    <input
                        type="text"
                        id="name"
                        class="form-control"
                        placeholder="Contoh: Budi Santoso"
                        required
                    >

                </div>

                <!-- EDUCATION -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        PENDIDIKAN TERAKHIR
                    </label>

                    <input
                        type="text"
                        id="education"
                        class="form-control"
                        placeholder="Contoh: S1/Teknik Informatika"
                        required
                    >

                </div>

            </div>

            <!-- ROW DETAIL -->
            <div class="row">

                <!-- BIRTH DATE -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        TANGGAL LAHIR
                    </label>

                    <input
                        type="date"
                        id="birth_date"
                        class="form-control"
                        required
                    >

                </div>

                <!-- PHONE -->
                <div class="col-md-6 mb-3">

                    <label class="custom-label">
                        NO TELEPON
                    </label>

                    <input
                        type="text"
                        id="phone"
                        class="form-control"
                        placeholder="08123456789"
                        required
                    >

                </div>

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label class="custom-label">
                    EMAIL
                </label>

                <input
                    type="email"
                    id="email"
                    class="form-control"
                    placeholder="nama@email.com"
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