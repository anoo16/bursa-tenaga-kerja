<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Bursa Tenaga Kerja</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >

    <!-- Google Fonts -->
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Home CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/home.css') }}"
    >
</head>

<body>

    <!-- NAVBAR -->
    <nav class="home-navbar">

        <div class="container home-nav-container">

            <a
                href="/"
                class="home-logo"
            >
                <img
                    src="{{ asset('assets/logo.png') }}"
                    alt="Bursa Tenaga Kerja"
                >
            </a>

            <div class="home-nav-actions">

                <a
                    href="/login"
                    class="btn btn-login"
                >
                    Login
                </a>

                <button
                    type="button"
                    class="btn btn-signup"
                    data-bs-toggle="modal"
                    data-bs-target="#signupRoleModal"
                >
                    Sign Up
                </button>

            </div>

        </div>

    </nav>

    <!-- HERO -->
    <section class="hero-section-home">

        <div class="container">

            <div class="row align-items-center gy-5">

                <div class="col-lg-6">

                    <div class="hero-content">

                        <h1>
                            Temukan Karir <br>
                            Impianmu <br>
                            di Satu Tempat.
                        </h1>

                        <p>
                            Bursa Tenaga Kerja menghubungkan pencari kerja
                            dengan perusahaan terpercaya melalui proses
                            pendaftaran dan verifikasi yang lebih aman.
                        </p>

                        <div class="hero-action-buttons">

                            <a
                                href="/register"
                                class="btn hero-primary-btn"
                            >
                                Daftar Pencari Kerja
                            </a>

                            <a
                                href="/register/recruiter"
                                class="btn hero-secondary-btn"
                            >
                                Daftarkan Perusahaan
                            </a>

                        </div>

                        <div class="home-feature-points">

                            <div class="feature-point">

                                <i class="bi bi-envelope-check"></i>

                                <div>
                                    <strong>OTP Email</strong>
                                    <span>Verifikasi akun aman</span>
                                </div>

                            </div>

                            <div class="feature-point">

                                <i class="bi bi-patch-check"></i>

                                <div>
                                    <strong>Review Admin</strong>
                                    <span>Company ditinjau</span>
                                </div>

                            </div>

                            <div class="feature-point">

                                <i class="bi bi-shield-lock"></i>

                                <div>
                                    <strong>Dokumen Aman</strong>
                                    <span>Akses terlindungi</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6">

                    <div class="hero-image-wrapper">

                        <img
                            src="{{ asset('assets/home-hero.png') }}"
                            alt="Gedung Bursa Tenaga Kerja"
                            class="hero-main-image"
                        >

                        <div class="hero-floating-card">

                            <div class="floating-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div>
                                <small>Sistem Verifikasi</small>
                                <strong>OTP EMAIL AKTIF</strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- PLATFORM FEATURES -->
    <section
        id="fitur"
        class="category-section"
    >

        <div class="container">

            <div class="section-heading-row">

                <div>

                    <h2>FITUR PLATFORM</h2>

                    <p>
                        Proses rekrutmen yang lebih aman, terarah, dan transparan.
                    </p>

                </div>

            </div>

            <div class="row g-4">

                <div class="col-md-3 col-sm-6">

                    <div class="category-card platform-feature-card">

                        <div class="category-icon">
                            <i class="bi bi-person-plus"></i>
                        </div>

                        <h5>Registrasi Mudah</h5>

                        <span>
                            Buat akun sesuai peran Anda.
                        </span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card platform-feature-card">

                        <div class="category-icon">
                            <i class="bi bi-envelope-check"></i>
                        </div>

                        <h5>OTP Email</h5>

                        <span>
                            Verifikasi akun melalui email.
                        </span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card platform-feature-card">

                        <div class="category-icon">
                            <i class="bi bi-building-check"></i>
                        </div>

                        <h5>Review Company</h5>

                        <span>
                            Recruiter ditinjau oleh admin.
                        </span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card platform-feature-card">

                        <div class="category-icon">
                            <i class="bi bi-file-earmark-lock"></i>
                        </div>

                        <h5>Dokumen Terlindungi</h5>

                        <span>
                            Dokumen diperiksa secara aman.
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- USER ROLES -->
    <section
        id="peran"
        class="jobs-section role-introduction-section"
    >

        <div class="container">

            <div class="row g-4 align-items-start">

                <div class="col-lg-8">

                    <h2 class="section-title">
                        UNTUK SIAPA PLATFORM INI?
                    </h2>

                    <!-- JOB SEEKER CARD -->
                    <div class="job-card active-job role-card">

                        <div class="job-icon">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <div class="job-content">

                            <div class="job-top">

                                <div>
                                    <h5>Pencari Kerja</h5>
                                    <span>Bangun langkah awal karier Anda</span>
                                </div>

                                <span class="job-badge">
                                    Job Seeker
                                </span>

                            </div>

                            <p>
                                Daftar sebagai pencari kerja, verifikasi akun
                                melalui email, lalu siapkan profil Anda untuk
                                menemukan peluang kerja yang sesuai.
                            </p>

                            <div class="role-card-action">

                                <a href="/register">
                                    Daftar sebagai Pencari Kerja
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                    <!-- COMPANY CARD -->
                    <div class="job-card role-card">

                        <div class="job-icon company-icon">
                            <i class="bi bi-buildings"></i>
                        </div>

                        <div class="job-content">

                            <div class="job-top">

                                <div>
                                    <h5>Recruiter / Perusahaan</h5>
                                    <span>Temukan kandidat terbaik untuk perusahaan</span>
                                </div>

                                <span class="job-badge company-badge">
                                    Company
                                </span>

                            </div>

                            <p>
                                Daftarkan perusahaan, unggah dokumen pendukung,
                                verifikasi email, dan tunggu persetujuan admin
                                sebelum menggunakan portal recruiter.
                            </p>

                            <div class="role-card-action">

                                <a href="/register/recruiter">
                                    Daftarkan Perusahaan
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="why-card">

                        <h5>Kenapa Bergabung?</h5>

                        <div class="why-item">

                            <i class="bi bi-patch-check"></i>

                            <div>
                                <strong>Perusahaan Ditinjau</strong>

                                <span>
                                    Pengajuan recruiter melalui proses review admin.
                                </span>
                            </div>

                        </div>

                        <div class="why-item">

                            <i class="bi bi-envelope-check"></i>

                            <div>
                                <strong>Verifikasi OTP Email</strong>

                                <span>
                                    Proses aktivasi akun dilakukan melalui kode OTP.
                                </span>
                            </div>

                        </div>

                        <div class="why-item">

                            <i class="bi bi-shield-lock"></i>

                            <div>
                                <strong>Dokumen Terlindungi</strong>

                                <span>
                                    Dokumen company hanya dapat ditinjau melalui akses admin.
                                </span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- HOW IT WORKS -->
    <section
        id="cara-kerja"
        class="how-section"
    >

        <div class="container">

            <div class="section-title-group">

                <h2>CARA KERJA</h2>

                <h3>
                    MULAI BERGABUNG DALAM
                    <span>4 LANGKAH</span>
                </h3>

            </div>

            <div class="steps-wrapper">

                <div class="step-line"></div>

                <div class="step-item">

                    <div class="step-number">
                        1
                    </div>

                    <h5>PILIH PERAN</h5>

                    <p>
                        Daftar sebagai pencari kerja atau recruiter
                        sesuai kebutuhan Anda.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        2
                    </div>

                    <h5>ISI DATA AKUN</h5>

                    <p>
                        Lengkapi data akun. Recruiter juga mengunggah
                        dokumen perusahaan pendukung.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        3
                    </div>

                    <h5>VERIFIKASI EMAIL</h5>

                    <p>
                        Masukkan kode OTP yang dikirimkan ke email
                        untuk mengaktifkan akun.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        4
                    </div>

                    <h5>MULAI BERGABUNG</h5>

                    <p>
                        Pencari kerja dapat masuk, sedangkan recruiter
                        menunggu persetujuan admin.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <!-- CTA -->
    <section class="cta-section-home">

        <div class="container">

            <div class="cta-card">

                <div class="circle circle-one"></div>

                <div class="circle circle-two"></div>

                <div class="circle circle-three"></div>

                <div class="cta-content">

                    <h2>
                        Siap <br>
                        Memulai <br>
                        Perjalanan <br>
                        Anda?
                    </h2>

                    <p>
                        Pilih peran Anda dan bergabung dengan Bursa Tenaga Kerja
                        melalui proses pendaftaran yang aman.
                    </p>

                </div>

                <div class="cta-actions">

                    <a
                        href="/register"
                        class="btn cta-outline"
                    >
                        Daftar Pencari Kerja
                    </a>

                    <a
                        href="/register/recruiter"
                        class="btn cta-outline"
                    >
                        Daftarkan Perusahaan
                    </a>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer
        id="tentang"
        class="home-footer"
    >

        <div class="container">

            <h2 class="footer-title">
                TENTANG
            </h2>

            <div class="footer-content">

                <div class="footer-brand">

                    <img
                        src="{{ asset('assets/logo.png') }}"
                        alt="Bursa Tenaga Kerja"
                    >

                    <p>
                        Platform rekrutmen digital yang menghubungkan
                        pencari kerja dengan perusahaan melalui proses
                        pendaftaran dan verifikasi yang aman.
                    </p>

                </div>

                <div class="footer-links">

                    <h5>Pencari Kerja</h5>

                    <a href="/register">Daftar Akun</a>

                    <a href="/login">Masuk Pencari Kerja</a>

                    <a href="#cara-kerja">Cara Kerja</a>

                    <a href="#fitur">Fitur Keamanan</a>

                </div>

                <div class="footer-links">

                    <h5>Perusahaan</h5>

                    <a href="/register/recruiter">Daftarkan Perusahaan</a>

                    <a href="/login">Masuk Perusahaan</a>

                    <a href="#fitur">Review Admin</a>

                    <a href="#cara-kerja">Proses Pendaftaran</a>

                </div>

                <div class="footer-links">

                    <h5>Informasi</h5>

                    <a
                        href="https://www.instagram.com/asisst.log/"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Tentang
                    </a>
                    
                    <a href="#fitur">Fitur</a>

                    <a href="#peran">Jenis Akun</a>

                    <a href="#cara-kerja">Alur Penggunaan</a>

                </div>

            </div>

            <div class="footer-bottom">

                <div>
                    ©2026
                    <span>Bursa Tenaga Kerja</span>
                    Semua hak dilindungi
                </div>

                <div>
                    Made in Pemograman Web A
                </div>

            </div>

        </div>

    </footer>

    <!-- SIGN UP ROLE MODAL -->
    <div
        class="modal fade signup-role-modal"
        id="signupRoleModal"
        tabindex="-1"
        aria-labelledby="signupRoleModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content signup-role-content">

                <button
                    type="button"
                    class="btn-close signup-role-close"
                    data-bs-dismiss="modal"
                    aria-label="Tutup"
                ></button>

                <div class="signup-role-header">

                    <span class="signup-role-badge">
                        MULAI BERGABUNG
                    </span>

                    <h2 id="signupRoleModalLabel">
                        Daftar Sebagai Apa?
                    </h2>

                    <p>
                        Pilih jenis akun yang sesuai dengan kebutuhan Anda.
                    </p>

                </div>

                <div class="signup-role-options">

                    <a
                        href="/register"
                        class="signup-option-card"
                    >
                        <div class="signup-option-icon jobseeker">
                            <i class="bi bi-person-workspace"></i>
                        </div>

                        <div class="signup-option-text">

                            <h3>Pencari Kerja</h3>

                            <p>
                                Temukan peluang kerja dan mulai membangun
                                perjalanan karier Anda.
                            </p>

                            <span>
                                Daftar sebagai Job Seeker
                                <i class="bi bi-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                    <a
                        href="/register/recruiter"
                        class="signup-option-card"
                    >
                        <div class="signup-option-icon recruiter">
                            <i class="bi bi-building"></i>
                        </div>

                        <div class="signup-option-text">

                            <h3>Recruiter / Perusahaan</h3>

                            <p>
                                Daftarkan perusahaan dan temukan kandidat
                                berkualitas.
                            </p>

                            <span>
                                Daftarkan Perusahaan
                                <i class="bi bi-arrow-right"></i>
                            </span>

                        </div>

                    </a>

                </div>

                <div class="signup-role-footer">

                    <span>
                        Sudah memiliki akun?
                    </span>

                    <a href="/login">
                        Login di sini
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>