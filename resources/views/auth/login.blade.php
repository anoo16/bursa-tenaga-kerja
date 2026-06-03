@extends('layouts.auth')

@section('title', 'Masuk - Bursa Tenaga Kerja')

@section('hero-label', 'MASUK')

@section('hero-text')

    <h1>Find your job now!</h1>

    <p>
        Menghubungkan ribuan pencari kerja dengan perusahaan terbaik.
        Proses Rekrutmen yang Cepat, Transparan, dan Terstruktur.
    </p>

@endsection

@section('auth-form')

    <!-- TIPE AKUN -->
    <div class="mb-4">

        <label class="form-label text-muted text-uppercase mb-2"
            style="
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 1px;
            "
        >
            TIPE AKUN
        </label>

        <div class="d-flex gap-3">

            <!-- JOBSEEKER -->
            <button
                id="jobseekerBtn"
                type="button"
                class="btn role-btn flex-fill d-flex align-items-center justify-content-center gap-2 py-2"
            >
                <img
                    src="{{ asset('assets/icon_jobseeker.svg') }}"
                    width="20"
                    alt="Jobseeker Icon"
                >

                Pencari Kerja
            </button>

            <!-- RECRUITER -->
            <button
                id="recruiterBtn"
                type="button"
                class="btn role-btn flex-fill d-flex align-items-center justify-content-center gap-2 py-2"
            >
                <img
                    src="{{ asset('assets/icon_rekruiter.svg') }}"
                    width="20"
                    alt="Recruiter Icon"
                >

                Perekrut
            </button>

        </div>

    </div>

    <!-- ALERT -->
    <div
        id="alertBox"
        class="alert d-none"
        role="alert"
    ></div>

    <!-- LOGIN FORM -->
    <form id="loginForm">

        @csrf

        <!-- EMAIL -->
        <div class="mb-3">

            <label class="form-label text-muted text-uppercase mb-1"
                style="
                    font-size: 12px;
                    font-weight: 700;
                    letter-spacing: 1px;
                "
            >
                ALAMAT EMAIL
            </label>

            <input
                type="email"
                id="email"
                class="form-control"
                placeholder="nama@contoh.com"
                required
            >

        </div>

        <!-- PASSWORD -->
        <div class="mb-3">

            <div class="d-flex justify-content-between align-items-center mb-1">

                <label class="form-label text-muted text-uppercase mb-0"
                    style="
                        font-size: 12px;
                        font-weight: 700;
                        letter-spacing: 1px;
                    "
                >
                    KATA SANDI
                </label>

                <a
                    href="/forgot-password"
                    class="text-decoration-none"
                    style="
                        font-size: 12px;
                        font-weight: 600;
                        color: #1A4885;
                    "
                >
                    Lupa Kata Sandi?
                </a>

            </div>

            <div class="password-input-wrapper">

                <input
                    type="password"
                    id="password"
                    class="form-control"
                    placeholder=""
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

        <!-- REMEMBER -->
        <div class="mb-4 form-check d-flex align-items-center gap-2">

            <input
                type="checkbox"
                class="form-check-input mt-0"
                id="rememberMe"
                style="
                    width: 16px;
                    height: 16px;
                "
            >

            <label
                class="form-check-label"
                for="rememberMe"
                style="
                    font-size: 14px;
                    color: #64748B;
                "
            >
                Ingat perangkat ini
            </label>

        </div>

        <!-- BUTTON LOGIN -->
        <button
            type="submit"
            class="btn w-100 py-2 mb-4"
            style="
                background-color: #0F2854;
                color: #FFFFFF;
                font-weight: 600;
                font-size: 16px;
                border-radius: 8px;
            "
        >
            Masuk
        </button>

    </form>

    <!-- DIVIDER -->
    <div class="d-flex align-items-center mb-4">

        <hr class="flex-grow-1 m-0" style="color: #E2E8F0;">

        <span
            class="px-3"
            style="
                font-size: 12px;
                color: #94A3B8;
                font-weight: 500;
                letter-spacing: 0.5px;
            "
        >
            ATAU LANJUTKAN DENGAN
        </span>

        <hr class="flex-grow-1 m-0" style="color: #E2E8F0;">

    </div>

    <!-- GOOGLE LOGIN -->
    <a
        href="/api/auth/google"
        class="btn w-100 d-flex align-items-center justify-content-center gap-2 py-2 mb-4"
        style="
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
            color: #1E1E1E;
            font-weight: 600;
            font-size: 14px;
            border-radius: 8px;
        "
    >
        <img
            src="{{ asset('assets/google.svg') }}"
            width="20"
            alt="Google"
        >

        Masuk Dengan Google
    </a>

    <!-- REGISTER -->
    <div
        class="text-center"
        style="
            font-size: 14px;
            color: #64748B;
        "
    >
        Belum Terdaftar?

        <a
            href="/register"
            id="registerLink"
            class="text-decoration-none"
            style="
                color: #1A4885;
                font-weight: 600;
            "
        >
            Buat Akun
        </a>

    </div>

@endsection

@push('scripts')

    <script src="{{ asset('assets/js/auth.js') }}"></script>

@endpush