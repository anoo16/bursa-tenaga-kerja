<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Kebijakan Privasi - Bursa Tenaga Kerja</title>

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

            <a
                href="/"
                class="legal-logo"
            >
                <img
                    src="{{ asset('assets/logo.png') }}"
                    alt="Bursa Tenaga Kerja"
                >
            </a>

            <section class="legal-card">

                <span class="legal-badge">
                    Privasi Pengguna
                </span>

                <h1>
                    Kebijakan Privasi
                </h1>

                <p class="legal-subtitle">
                    Kebijakan Privasi ini menjelaskan bagaimana Bursa Tenaga Kerja
                    mengumpulkan, menggunakan, menyimpan, dan melindungi data pengguna.
                </p>

                <div class="legal-section">

                    <h2>1. Data yang Dikumpulkan</h2>

                    <p>
                        Platform dapat mengumpulkan data seperti nama, email, nomor telepon,
                        tanggal lahir, pendidikan, data perusahaan, dokumen pendukung,
                        serta informasi lain yang diberikan pengguna saat mendaftar.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>2. Penggunaan Data</h2>

                    <ul>
                        <li>Memproses pendaftaran dan login pengguna.</li>
                        <li>Mengirim kode OTP untuk verifikasi akun.</li>
                        <li>Melakukan verifikasi akun recruiter/perusahaan.</li>
                        <li>Mengelola akses pengguna berdasarkan peran akun.</li>
                        <li>Mendukung proses rekrutmen pada platform.</li>
                    </ul>

                </div>

                <div class="legal-section">

                    <h2>3. Perlindungan Data</h2>

                    <p>
                        Data pengguna disimpan dan dikelola dengan memperhatikan keamanan
                        sistem. Akses terhadap dokumen perusahaan dibatasi agar hanya dapat
                        digunakan untuk proses verifikasi yang diperlukan.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>4. Dokumen Perusahaan</h2>

                    <p>
                        Dokumen seperti NPWP, izin usaha, dan surat kuasa PIC digunakan
                        untuk membantu admin meninjau validitas akun recruiter/perusahaan.
                        Dokumen tersebut tidak digunakan untuk tujuan di luar proses
                        verifikasi platform.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>5. Penyimpanan Data</h2>

                    <p>
                        Data disimpan selama akun masih aktif atau selama diperlukan untuk
                        mendukung layanan platform. Pengelola dapat menghapus atau membatasi
                        data sesuai kebutuhan operasional sistem.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>6. Tanggung Jawab Pengguna</h2>

                    <p>
                        Pengguna bertanggung jawab untuk memastikan data yang diberikan
                        benar, valid, dan tidak melanggar hak pihak lain.
                    </p>

                </div>

                <div class="legal-section">

                    <h2>7. Perubahan Kebijakan</h2>

                    <p>
                        Kebijakan Privasi ini dapat diperbarui sesuai pengembangan sistem.
                        Perubahan akan dipublikasikan melalui halaman ini.
                    </p>

                </div>

                <div class="legal-actions">

                    <a
                        href="/"
                        class="btn-primary-legal"
                    >
                        Beranda
                    </a>

                </div>

            </section>

        </div>

    </main>

</body>
</html>