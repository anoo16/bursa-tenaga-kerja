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

            <div class="home-menu">

                <a href="#lowongan">
                    Lowongan
                </a>

                <a href="#perusahaan">
                    Perusahaan
                </a>

                <a href="#tentang">
                    Tentang
                </a>

            </div>

            <div class="home-nav-actions">

                <a
                    href="/login"
                    class="btn btn-login"
                >
                    Login
                </a>

                <a
                    href="/register"
                    class="btn btn-signup"
                >
                    Sign Up
                </a>

            </div>

        </div>

    </nav>

    <!-- HERO -->
    <section class="hero-section-home">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6">

                    <div class="hero-content">

                        <h1>
                            Temukan Karir <br>
                            Impianmu <br>
                            di Satu Tempat.
                        </h1>

                        <p>
                            Bursa Tenaga Kerja bukan sekadar platform rekrutmen.
                            Ini adalah ruang pameran bagi bakat terbaik dan peluang
                            karir yang dikurasi secara editorial.
                        </p>

                        <form class="home-search-box">

                            <div class="search-input-wrapper">

                                <i class="bi bi-search"></i>

                                <input
                                    type="text"
                                    placeholder="Cari posisi atau perusahaan..."
                                >

                            </div>

                            <button type="submit">
                                Cari Kerja
                            </button>

                        </form>

                        <div class="home-stats">

                            <div>
                                <strong>12K+</strong>
                                <span>Lowongan Aktif</span>
                            </div>

                            <div>
                                <strong>850</strong>
                                <span>Perusahaan Top</span>
                            </div>

                            <div>
                                <strong>15K+</strong>
                                <span>Candidate</span>
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

                        </div>

                        <div class="hero-floating-card">

                            <div class="floating-icon">
                                <i class="bi bi-activity"></i>
                            </div>

                            <div>
                                <small>Gaji Tertinggi</small>
                                <strong>DAPUR MBG</strong>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- CATEGORY -->
    <section class="category-section">

        <div class="container">

            <div class="section-heading-row">

                <div>
                    <h2>KATEGORI POPULER</h2>

                    <p>
                        Telusuri peluang berdasarkan bidang keahlian Anda.
                    </p>
                </div>

                <a href="#">
                    Lihat Semua
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

            <div class="row g-4">

                <div class="col-md-3 col-sm-6">

                    <div class="category-card">

                        <div class="category-icon">
                            <i class="bi bi-palette"></i>
                        </div>

                        <h5>Design & Creative</h5>

                        <span>2.4k Lowongan</span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card">

                        <div class="category-icon">
                            <i class="bi bi-code"></i>
                        </div>

                        <h5>Development</h5>

                        <span>3.2k Lowongan</span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card">

                        <div class="category-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>

                        <h5>Marketing</h5>

                        <span>1.2 Lowongan</span>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="category-card">

                        <div class="category-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <h5>Finance</h5>

                        <span>850 Lowongan</span>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- JOBS -->
    <section
        id="lowongan"
        class="jobs-section"
    >

        <div class="container">

            <div class="row g-4 align-items-start">

                <div class="col-lg-8">

                    <h2 class="section-title">
                        LOWONGAN TERBARU
                    </h2>

                    <div class="job-card active-job">

                        <div class="job-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <div class="job-content">

                            <div class="job-top">

                                <div>
                                    <h5>Senior Product Designer</h5>
                                    <span>Studio Kreatif Digital</span>
                                </div>

                                <span class="job-badge">
                                    Remote
                                </span>

                            </div>

                            <p>
                                Kami mencari desainer visioner untuk memimpin tim
                                produk kami dalam membangun masa depan fintech.
                            </p>

                            <div class="job-tags">

                                <span>IDR 15M - 25M</span>

                                <span>Figma</span>

                                <span>Leader</span>

                            </div>

                        </div>

                    </div>

                    <div class="job-card">

                        <div class="job-icon">
                            <i class="bi bi-box"></i>
                        </div>

                        <div class="job-content">

                            <div class="job-top">

                                <div>
                                    <h5>Front-end Developer (Vue.js)</h5>
                                    <span>TechNova Solutions</span>
                                </div>

                                <span class="job-badge">
                                    Jakarta
                                </span>

                            </div>

                            <p>
                                Bergabunglah dengan tim engineering kami yang dinamis.
                                Fokus pada performa dan skalabilitas aplikasi.
                            </p>

                            <div class="job-tags">

                                <span>IDR 12M - 18M</span>

                                <span>Vue 3</span>

                                <span>Mid-Level</span>

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
                                <strong>Perusahaan Terverifikasi</strong>
                                <span>Hanya perusahaan terbaik yang dapat memposting.</span>
                            </div>

                        </div>

                        <div class="why-item">

                            <i class="bi bi-lightning-charge"></i>

                            <div>
                                <strong>Proses Cepat</strong>
                                <span>Dapatkan respon dalam rata-rata 3 hari kerja.</span>
                            </div>

                        </div>

                        <div class="why-item">

                            <i class="bi bi-shield-check"></i>

                            <div>
                                <strong>Keamanan S3 Cloud</strong>
                                <span>Dokumen CV Anda disimpan dengan aman menggunakan AWS Cloud terenkripsi.</span>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- HOW IT WORKS -->
    <section class="how-section">

        <div class="container">

            <div class="section-title-group">

                <h2>CARA KERJA</h2>

                <h3>
                    MULAI KARIR BARU DALAM
                    <span>4 LANGKAH</span>
                </h3>

            </div>

            <div class="steps-wrapper">

                <div class="step-line"></div>

                <div class="step-item">

                    <div class="step-number">
                        1
                    </div>

                    <h5>BUAT PROFIL</h5>

                    <p>
                        Lengkapi Data diri, Pengalaman Kerja,
                        dan Unggah CV Terbaru kamu.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        2
                    </div>

                    <h5>CARI LOWONGAN</h5>

                    <p>
                        Temukan ribuan Lowongan yang sesuai
                        dengan keahlian dan lokasi pilihanmu.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        3
                    </div>

                    <h5>LAMAR PEKERJAAN</h5>

                    <p>
                        Kirim lamaran dengan satu klik dan
                        pantau statusnya secara real-time.
                    </p>

                </div>

                <div class="step-item">

                    <div class="step-number">
                        4
                    </div>

                    <h5>DAPATKAN PEKERJAAN</h5>

                    <p>
                        Terima tawaran dan mulai perjalanan
                        karir baru bersama Perusahaan Impianmu.
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
                        Karirmu?
                    </h2>

                    <p>
                        Bergabung dengan lebih dari 89.000 pencari kerja
                        yang sudah terdaftar.
                    </p>

                </div>

                <div class="cta-actions">

                    <a
                        href="/register"
                        class="btn cta-outline"
                    >
                        Daftar Sebagai Pencari Kerja
                    </a>

                    <a
                        href="/register/recruiter"
                        class="btn cta-outline"
                    >
                        Pasang Lowongan
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
                        Platfrom Rekrutmen Digital yang menghubungkan
                        pencari kerja dengan perusahaan terbaik
                        diseluruh indonesia
                    </p>

                </div>

                <div class="footer-links">

                    <h5>Pencari Kerja</h5>

                    <a href="#">Cari Lowongan</a>

                    <a href="#">Buat Profil</a>

                    <a href="#">Upload CV</a>

                    <a href="#">Lamaran Saya</a>

                </div>

                <div class="footer-links">

                    <h5>Perusahaan</h5>

                    <a href="#">Pasang Lowongan</a>

                    <a href="#">Kelola Pelamar</a>

                    <a href="#">Profil Perusahaan</a>

                    <a href="#">Paket Premium</a>

                </div>

                <div class="footer-links">

                    <h5>Informasi</h5>

                    <a href="#">Tentang Kami</a>

                    <a href="#">Kontak</a>

                    <a href="#">Kebijakan Privasi</a>

                    <a href="#">Syarat & Ketentuan</a>

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

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>