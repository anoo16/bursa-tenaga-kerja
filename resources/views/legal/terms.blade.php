<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Syarat & Ketentuan - Bursa Tenaga Kerja</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            margin: 0;
            background: #FEF9F2;
            color: #111827;
            font-family: 'Inter', sans-serif;
        }

        .legal-page {
            min-height: 100vh;
            padding: 42px 20px 60px;
        }

        .legal-container {
            max-width: 920px;
            margin: 0 auto;
        }

        .legal-header {
            margin-bottom: 28px;
        }

        .legal-logo {
            display: inline-flex;
            align-items: center;
            margin-bottom: 22px;
        }

        .legal-logo img {
            height: 92px;
            width: auto;
            object-fit: contain;
        }

        .legal-card {
            background: #FFFFFF;
            border-radius: 24px;
            padding: 38px 42px;
            box-shadow: 0 18px 45px rgba(15, 40, 84, 0.08);
            border: 1px solid rgba(15, 40, 84, 0.08);
        }

        .legal-badge {
            display: inline-flex;
            align-items: center;
            padding: 7px 14px;
            border-radius: 999px;
            background: #E9F4FD;
            color: #102D5C;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        h1 {
            font-family: 'Sora', sans-serif;
            font-size: 34px;
            font-weight: 800;
            color: #102D5C;
            margin-bottom: 12px;
        }

        .legal-subtitle {
            color: #6B7280;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .legal-section {
            margin-bottom: 26px;
        }

        .legal-section h2 {
            font-size: 18px;
            font-weight: 800;
            color: #102D5C;
            margin-bottom: 10px;
        }

        .legal-section p,
        .legal-section li {
            color: #4B5563;
            line-height: 1.75;
            font-size: 14px;
        }

        .legal-section ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .legal-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 34px;
            padding-top: 24px;
            border-top: 1px solid #E5EAF0;
        }

        .btn-primary-legal {
            background: #102D5C;
            color: #FFFFFF;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            text-decoration: none;
        }

        .btn-primary-legal:hover {
            background: #0B244C;
            color: #FFFFFF;
        }

        .btn-outline-legal {
            background: #FFFFFF;
            color: #102D5C;
            border: 1px solid #102D5C;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .btn-outline-legal:hover {
            background: #F3F7FC;
            color: #102D5C;
        }

        @media (max-width: 768px) {
            .legal-card {
                padding: 28px 22px;
            }

            h1 {
                font-size: 26px;
            }

            .legal-logo img {
                height: 72px;
            }
        }
    </style>
</head>
<body>

    <main class="legal-page">

        <div class="legal-container">

            <div class="legal-header">

                <a
                    href="/"
                    class="legal-logo"
                >
                    <img
                        src="{{ asset('assets/logo.png') }}"
                        alt="Bursa Tenaga Kerja"
                    >
                </a>

            </div>

            <section class="legal-card">

                <span class="legal-badge">
                    Dokumen Legal
                </span>

                <h1>
                    Syarat & Ketentuan
                </h1>

                <p class="legal-subtitle">
                    Syarat & Ketentuan ini mengatur penggunaan platform Bursa Tenaga Kerja
                    oleh pencari kerja, recruiter, perusahaan, dan pengguna lainnya.
                </p>

                <div class="legal-section">

                    <h2>1. Penerimaan Syarat</h2>

                    <p>
                        Dengan membuat akun dan menggunakan layanan Bursa Tenaga Kerja,
                        pengguna dianggap telah membaca, memahami, dan menyetujui seluruh
                        Syarat & Ketentuan yang berlaku pada platform ini.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>2. Jenis Akun Pengguna</h2>

                    <p>
                        Platform menyediakan beberapa jenis akun, yaitu akun pencari kerja
                        dan akun recruiter/perusahaan. Setiap pengguna wajib memilih jenis
                        akun yang sesuai dengan kebutuhan dan perannya.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>3. Kewajiban Pencari Kerja</h2>

                    <ul>
                        <li>Memberikan data pribadi dan informasi profil yang benar.</li>
                        <li>Tidak menggunakan identitas palsu atau data milik orang lain.</li>
                        <li>Menjaga kerahasiaan akun dan kata sandi.</li>
                        <li>Menggunakan platform untuk tujuan pencarian kerja secara wajar.</li>
                    </ul>

                </div>

                <div class="legal-section">

                    <h2>4. Kewajiban Recruiter / Perusahaan</h2>

                    <ul>
                        <li>Memberikan data perusahaan yang benar dan dapat diverifikasi.</li>
                        <li>Mengunggah dokumen pendukung yang sah, seperti NPWP, izin usaha, dan surat kuasa PIC.</li>
                        <li>Tidak membuat lowongan palsu, menyesatkan, atau merugikan pencari kerja.</li>
                        <li>Menggunakan data pelamar hanya untuk kebutuhan rekrutmen.</li>
                    </ul>

                </div>

                <div class="legal-section">

                    <h2>5. Verifikasi dan Persetujuan Admin</h2>

                    <p>
                        Akun recruiter/perusahaan dapat melalui proses verifikasi dokumen
                        dan persetujuan admin sebelum dapat menggunakan layanan tertentu.
                        Admin berhak menerima atau menolak pendaftaran apabila data tidak
                        sesuai, tidak lengkap, atau tidak valid.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>6. Keamanan Akun</h2>

                    <p>
                        Pengguna bertanggung jawab menjaga keamanan akun masing-masing.
                        Segala aktivitas yang terjadi melalui akun pengguna menjadi tanggung
                        jawab pengguna yang bersangkutan.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>7. Pembatasan Penggunaan</h2>

                    <ul>
                        <li>Dilarang menyalahgunakan platform untuk spam, penipuan, atau aktivitas ilegal.</li>
                        <li>Dilarang mengunggah dokumen palsu atau informasi yang menyesatkan.</li>
                        <li>Dilarang mengakses, mengambil, atau menyebarkan data pengguna lain tanpa izin.</li>
                    </ul>

                </div>

                <div class="legal-section">

                    <h2>8. Perubahan Syarat</h2>

                    <p>
                        Bursa Tenaga Kerja dapat memperbarui Syarat & Ketentuan ini sesuai
                        kebutuhan pengembangan sistem. Perubahan akan berlaku setelah
                        dipublikasikan pada halaman ini.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>9. Kontak</h2>

                    <p>
                        Jika terdapat pertanyaan terkait Syarat & Ketentuan ini, pengguna
                        dapat menghubungi pengelola platform melalui informasi kontak yang
                        tersedia pada sistem.
                    </p>

                </div>

                <div class="legal-actions">

                    <a
                        href="/"
                        class="btn-outline-legal"
                    >
                        Beranda
                    </a>

                </div>

            </section>

        </div>

    </main>

</body>
</html>