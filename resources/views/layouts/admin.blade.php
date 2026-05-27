<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>@yield('title', 'Admin Dashboard - Bursa Tenaga Kerja')</title>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap"
        rel="stylesheet"
    >

    <!-- Boxicons -->
    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    >

    <!-- Admin CSS -->
    <link
        rel="stylesheet"
        href="{{ asset('assets/css/admin.css') }}"
    >
</head>
<body>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="admin-sidebar">

            <div class="admin-logo">
                <img
                    src="{{ asset('assets/logo.png') }}"
                    alt="Bursa Tenaga Kerja"
                >
            </div>

            <nav class="admin-menu">

                <a href="#" class="admin-menu-item">
                    <i class='bx bx-grid-alt'></i>
                    <span>Overview</span>
                </a>

                <a href="/dashboard/admin" class="admin-menu-item active">
                    <i class='bx bx-user'></i>
                    <span>Kelola Pengguna</span>
                </a>

                <a href="#" class="admin-menu-item">
                    <i class='bx bx-briefcase'></i>
                    <span>Kelola Lowongan</span>
                </a>

                <a href="#" class="admin-menu-item">
                    <i class='bx bx-bar-chart-alt-2'></i>
                    <span>Laporan</span>
                </a>

                <a href="#" class="admin-menu-item">
                    <i class='bx bx-cog'></i>
                    <span>Pengaturan Sistem</span>
                </a>

            </nav>

        </aside>

        <!-- MAIN -->
        <main class="admin-main">

            @yield('content')

        </main>

    </div>

        <script src="{{ asset('assets/js/admin.js') }}"></script>

</body>
</html>