@extends('layouts.auth')

@section('title', 'Daftar Recruiter - Bursa Tenaga Kerja')

@section('hero-text')

    <div class="hero-custom recruiter-hero">

        <div class="hero-badge">
            <i class="bi bi-check-circle"></i>
            MITRA STRATEGIS
        </div>

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
                <i class="bi bi-people-fill"></i>
            </div>

            <div>
                <h5>Jangkauan Luas</h5>

                <span>
                    Akses ke ribuan kandidat berkualitas dari berbagai
                    spesialisasi.
                </span>
            </div>

        </div>

        <!-- BENEFIT 2 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                <i class="bi bi-headset"></i>
            </div>

            <div>
                <h5>Keamanan S3 Cloud</h5>

                <span>
                    Dokumen perusahaan Anda disimpan dengan aman menggunakan
                    infrastruktur AWS Cloud terenkripsi.
                </span>
            </div>

        </div>

        <!-- BENEFIT 3 -->
        <div class="benefit-item">

            <div class="benefit-icon">
                <i class="bi bi-bar-chart-line-fill"></i>
            </div>

            <div>
                <h5>Data-Driven Insight</h5>

                <span>
                    Pantau performa lowongan Anda dengan dashboard analytics
                    real-time.
                </span>
            </div>

        </div>

    </div>

@endsection

@section('auth-form')

    <div class="register-wrapper recruiter-register-wrapper">

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
        <form
            id="recruiterRegisterForm"
            enctype="multipart/form-data"
        >

            @csrf

            <!-- ROLE -->
            <div class="mb-3">

                <label class="custom-label">
                    PERAN AKUN
                </label>

                <div class="role-input-wrapper">

                    <i class="bi bi-building"></i>

                    <input
                        type="text"
                        class="form-control"
                        value="Perusahaan / Recruiter"
                        readonly
                    >

                    <i class="bi bi-lock-fill"></i>

                </div>

                <small class="register-note">
                    *Anda mendaftar khusus untuk portal pemberi kerja.
                </small>

            </div>

            <!-- PIC & COMPANY -->
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="pic_name"
                        class="custom-label"
                    >
                        NAMA LENGKAP PIC
                    </label>

                    <input
                        type="text"
                        id="pic_name"
                        name="name"
                        class="form-control"
                        placeholder="Contoh: Budi Santoso"
                        autocomplete="name"
                        required
                    >

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="company_name"
                        class="custom-label"
                    >
                        NAMA PERUSAHAAN
                    </label>

                    <input
                        type="text"
                        id="company_name"
                        name="company_name"
                        class="form-control"
                        placeholder="Contoh: PT Teknologi Maju"
                        required
                    >

                </div>

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label
                    for="email"
                    class="custom-label"
                >
                    EMAIL BISNIS
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="hrd@perusahaan.com"
                    autocomplete="email"
                    required
                >

            </div>

            <!-- PASSWORD -->
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="password"
                        class="custom-label"
                    >
                        KATA SANDI
                    </label>

                    <div class="password-input-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder=""
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword(this)"
                            aria-label="Tampilkan kata sandi"
                        >
                            👁
                        </button>

                    </div>

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="confirmPassword"
                        class="custom-label"
                    >
                        KONFIRMASI SANDI
                    </label>

                    <div class="password-input-wrapper">

                        <input
                            type="password"
                            id="confirmPassword"
                            name="password_confirmation"
                            class="form-control"
                            placeholder=""
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-password"
                            onclick="togglePassword(this)"
                            aria-label="Tampilkan konfirmasi kata sandi"
                        >
                            👁
                        </button>

                    </div>

                </div>

            </div>

            <!-- NPWP & BUSINESS LICENSE -->
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="npwp"
                        class="custom-label"
                    >
                        NPWP (NOMOR POKOK WAJIB PAJAK)
                    </label>

                    <input
                        type="text"
                        id="npwp"
                        name="npwp"
                        class="form-control mb-2"
                        placeholder="00.000.000.0-000.000"
                        maxlength="30"
                        required
                    >

                    <label
                        for="npwp_file"
                        class="file-upload-btn"
                    >
                        Choose File
                    </label>

                    <input
                        type="file"
                        id="npwp_file"
                        name="npwp_file"
                        class="document-file-input"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                    >

                    <span
                        id="npwpFileName"
                        class="file-name"
                    >
                        No file chosen
                    </span>

                    <small class="file-note">
                        Unggah file PDF/JPG/PNG (Maks. 2MB)
                    </small>

                </div>

                <div class="col-md-6 mb-3">

                    <label
                        for="business_license_file"
                        class="custom-label"
                    >
                        IZIN USAHA (SIUP/TDP/NIB)
                    </label>

                    <label
                        for="business_license_file"
                        class="file-upload-btn file-upload-top"
                    >
                        Choose File
                    </label>

                    <input
                        type="file"
                        id="business_license_file"
                        name="business_license_file"
                        class="document-file-input"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                    >

                    <span
                        id="businessLicenseFileName"
                        class="file-name"
                    >
                        No file chosen
                    </span>

                    <small class="file-note">
                        Unggah file PDF/JPG/PNG (Maks. 2MB)
                    </small>

                </div>

            </div>

            <!-- PIC AUTHORIZATION -->
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label
                        for="pic_authorization_file"
                        class="custom-label"
                    >
                        SURAT KUASA PIC
                    </label>

                    <label
                        for="pic_authorization_file"
                        class="file-upload-btn"
                    >
                        Choose File
                    </label>

                    <input
                        type="file"
                        id="pic_authorization_file"
                        name="pic_authorization_file"
                        class="document-file-input"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                    >

                    <span
                        id="picAuthorizationFileName"
                        class="file-name"
                    >
                        No file chosen
                    </span>

                    <small class="file-note">
                        Unggah file PDF/JPG/PNG (Maks. 2MB)
                    </small>

                </div>

            </div>

            <!-- TERMS -->
            <div class="form-check recruiter-terms mb-4">

                <input
                    class="form-check-input"
                    type="checkbox"
                    id="terms"
                    name="terms"
                    value="1"
                    required
                >

                <label
                    class="form-check-label"
                    for="terms"
                >
                    Saya setuju dengan
                    <a href="#">Syarat & Ketentuan</a>
                    serta
                    <a href="#">Kebijakan Privasi</a>
                    Bursa Tenaga Kerja.
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
        <div class="text-center mt-4 recruiter-login-text">

            <span>
                Sudah memiliki akun?
            </span>

            <a
                href="/login"
                class="text-decoration-none fw-semibold"
            >
                Login di sini
            </a>

        </div>

    </div>

@endsection

@push('scripts')

    <script src="{{ asset('assets/js/auth.js') }}"></script>

@endpush