<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Bursa Tenaga Kerja')
    </title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@400;600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Custom CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/auth.css') }}"
    >

</head>

<body>

    <!-- LOGO -->
    <div class="logo-wrapper">

        <img
            src="{{ asset('assets/logo.png') }}"
            alt="Logo Bursa Tenaga Kerja"
        >

    </div>

    <!-- MAIN CONTENT -->
    <div class="container-fluid main-content">

        <div class="row w-100 align-items-center">

            <!-- HERO -->
            <div class="col-md-6 hero-section">

                <div class="label-login text-uppercase">

                    @yield('hero-label', 'MASUK')

                </div>

                @yield('hero-text')

            </div>

            <!-- AUTH CARD -->
            <div class="col-md-6 d-flex justify-content-end pe-md-4">

                <div class="auth-card">

                    @yield('auth-form')

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="footer-wrapper">

        <div>

            © 2026

            <span class="brand-text">
                Bursa Tenaga Kerja
            </span>

            Semua hak dilindungi

        </div>

        <div>
            Dibuat dalam Pemrograman Web A
        </div>

    </footer>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Stack Scripts -->
    @stack('scripts')

</body>

</html>