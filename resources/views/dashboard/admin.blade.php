@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Bursa Tenaga Kerja')

@section('content')

    <!-- TOP HEADER -->
    <div class="admin-topbar">

        <div>
            <h1>Kelola Pengguna</h1>

            <p>
                Directory management for all registered users
            </p>
        </div>

        <div class="admin-top-actions">

            <div class="admin-search">
                <i class='bx bx-search'></i>

                <input
                    type="text"
                    placeholder="Cari pengguna..."
                >
            </div>

            <button class="notification-btn">
                <i class='bx bx-bell'></i>
                <span></span>
            </button>

            <div class="admin-avatar">
                <img
                    src="https://i.pravatar.cc/100?img=12"
                    alt="Admin"
                >
            </div>

        </div>

    </div>


    <!-- FILTER -->
    <div class="user-filter-row">

        <div class="filter-tabs">

            <button class="active">
                Semua
            </button>

            <button>
                Aktif
            </button>

            <button class="tab-with-badge">
                Menunggu <br> Persetujuan
                <span>0</span>
            </button>

            <button>
                Ditangguhkan
            </button>

        </div>

        <div class="role-filter">
            <i class='bx bx-slider-alt'></i>

            <span>Peran: Semua</span>

            <i class='bx bx-chevron-down'></i>
        </div>

    </div>


    <!-- USER TABLE -->
    <section class="admin-card user-table-card">

        <div
            class="user-table"
            id="adminUserTable"
        >

            <div class="user-table-head">

                <span>ID Pengguna</span>

                <span>Nama & Detail</span>

                <span>Peran</span>

                <span>Status</span>

                <span>Tgl Bergabung</span>

                <span>Aksi</span>

            </div>

            <div
                id="adminUserTableBody"
                class="admin-user-table-body"
            >

                <div class="user-table-row">

                    <div class="user-id">
                        -
                    </div>

                    <div class="user-profile">

                        <div class="company-avatar">
                            <i class='bx bx-loader-circle bx-spin'></i>
                        </div>

                        <div>
                            <h4>Memuat data...</h4>

                            <p>Mohon tunggu sebentar</p>
                        </div>

                    </div>

                    <div>
                        <span class="role-badge company">
                            Company
                        </span>
                    </div>

                    <div>
                        <span class="status-text pending">
                            Loading
                        </span>
                    </div>

                    <div class="join-date">
                        -
                    </div>

                    <div class="action-buttons">
                        -
                    </div>

                </div>

            </div>

        </div>

        <div class="table-footer">

            <p>
                Menampilkan
                <span id="shownUserCount">0</span>
                pengguna pending
            </p>

            <div class="pagination">

                <i class='bx bx-chevron-left'></i>

                <button class="active">
                    1
                </button>

                <i class='bx bx-chevron-right'></i>

            </div>

        </div>

    </section>


    <!-- SUMMARY -->
    <div class="summary-grid">

        <div class="summary-card blue">

            <p>Total Pengguna</p>

            <h2>12,842</h2>

            <span>
                ↗ +12% bulan ini
            </span>

        </div>

        <div class="summary-card orange">

            <p>Menunggu Persetujuan</p>

            <h2 id="pendingUserCount">0</h2>

            <span>
                Perlu peninjauan segera
            </span>

        </div>

        <div class="summary-card red">

            <p>Ditangguhkan</p>

            <h2>42</h2>

            <span>
                ⚠ Melanggar ketentuan
            </span>

        </div>

    </div>

@endsection