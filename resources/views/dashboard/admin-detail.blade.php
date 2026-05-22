@extends('layouts.admin')

@section('title', 'Detail Informasi Company - Admin Bursa Tenaga Kerja')

@section('content')

    <div class="detail-page-wrapper">

        <!-- BREADCRUMB -->
        <div class="detail-breadcrumb">

            <a href="/dashboard/admin">
                Admin
            </a>

            <i class='bx bx-chevron-right'></i>

            <a href="/dashboard/admin">
                User Management
            </a>

            <i class='bx bx-chevron-right'></i>

            <span id="detailBreadcrumbName">
                Detail Company
            </span>

        </div>

        <!-- HEADER -->
        <div class="detail-header">

            <div>

                <h1>Detail Informasi User</h1>

                <p>
                    Tinjau dan kelola pendaftaran tenaga kerja di platform Bursa Tenaga Kerja.
                </p>

            </div>

            <a
                href="/dashboard/admin"
                class="detail-back-btn"
            >
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>

        </div>

        <!-- ALERT -->
        <div
            id="adminDetailAlert"
            class="detail-alert d-none"
            role="alert"
        ></div>

        <!-- LOADING -->
        <section
            id="recruiterDetailLoading"
            class="detail-loading-card"
        >
            <i class='bx bx-loader-circle bx-spin'></i>

            <p>
                Memuat detail recruiter...
            </p>
        </section>

        <!-- DETAIL CONTENT -->
        <section
            id="recruiterDetailContent"
            class="detail-layout d-none"
        >

            <!-- LEFT COLUMN -->
            <aside class="detail-sidebar-column">

                <!-- PROFILE CARD -->
                <div class="detail-profile-card">

                    <div class="detail-profile-cover"></div>

                    <div class="detail-profile-body">

                        <div class="detail-company-avatar">
                            <i class='bx bx-buildings'></i>
                        </div>

                        <h2 id="detailCompanyName">
                            -
                        </h2>

                        <p
                            id="detailEmail"
                            class="detail-email"
                        >
                            -
                        </p>

                        <p class="detail-role-label">
                            Company / Recruiter
                        </p>

                        <div class="detail-profile-stats">

                            <div>

                                <strong id="detailVerificationStatus">
                                    -
                                </strong>

                                <span>
                                    Status Verifikasi
                                </span>

                            </div>

                            <div>

                                <strong id="detailAccountStatus">
                                    -
                                </strong>

                                <span>
                                    Status Akun
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- QUICK ACTIONS -->
                <div class="detail-quick-actions-card">

                    <small>
                        QUICK ACTIONS
                    </small>

                    <div class="quick-action-list">

                        <button
                            type="button"
                            class="quick-action-btn"
                            title="Fitur dapat dilanjutkan oleh kelompok admin"
                        >
                            <span>Kirim Pesan</span>
                            <i class='bx bx-envelope'></i>
                        </button>

                        <button
                            type="button"
                            class="quick-action-btn"
                            title="Fitur dapat dilanjutkan oleh kelompok admin"
                        >
                            <span>Download Full Profile</span>
                            <i class='bx bx-download'></i>
                        </button>

                    </div>

                </div>

            </aside>

            <!-- RIGHT INFORMATION CARD -->
            <div class="detail-information-card">

                <div class="detail-card-top">

                    <h2>
                        Atribut Data
                    </h2>

                    <span class="detail-review-badge">
                        Draft Review
                    </span>

                </div>

                <div class="detail-attribute-list">

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            ID User
                        </span>

                        <span
                            id="detailUserCode"
                            class="detail-attribute-value strong"
                        >
                            -
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Nama Lengkap PIC
                        </span>

                        <span
                            id="detailPicName"
                            class="detail-attribute-value"
                        >
                            -
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Email Terdaftar
                        </span>

                        <span
                            id="detailBusinessEmail"
                            class="detail-attribute-value link-like"
                        >
                            -
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Pendaftar Sebagai
                        </span>

                        <span
                            id="detailRoleText"
                            class="detail-attribute-value"
                        >
                            Company / Recruiter
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Status Verifikasi
                        </span>

                        <span
                            id="detailApprovalStatus"
                            class="detail-status pending"
                        >
                            Pending
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Nama Perusahaan
                        </span>

                        <span
                            id="detailCompanyField"
                            class="detail-attribute-value"
                        >
                            -
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            NPWP
                        </span>

                        <span
                            id="detailNpwp"
                            class="detail-attribute-value"
                        >
                            -
                        </span>

                    </div>

                    <div class="detail-attribute-row">

                        <span class="detail-attribute-label">
                            Tanggal Bergabung
                        </span>

                        <span
                            id="detailCreatedAt"
                            class="detail-attribute-value"
                        >
                            -
                        </span>

                    </div>

                </div>

                <!-- ADMIN ACTIONS -->
                <div class="detail-admin-actions">

                    <small>
                        AKSI ADMINISTRASI
                    </small>

                    <div class="detail-action-buttons">

                        <button
                            type="button"
                            id="detailApproveBtn"
                            class="detail-btn-approve"
                        >
                            <i class='bx bx-check-circle'></i>
                            Terima
                        </button>

                        <button
                            type="button"
                            id="detailRejectBtn"
                            class="detail-btn-reject"
                        >
                            <i class='bx bx-x-circle'></i>
                            Tolak
                        </button>

                        <button
                            type="button"
                            id="detailDocumentToggleBtn"
                            class="detail-btn-docs"
                        >
                            <i class='bx bx-show-alt'></i>
                            Lihat Dokumen
                        </button>

                    </div>

                    <!-- DOCUMENT DROPDOWN -->
                    <div
                        id="detailDocumentPanel"
                        class="detail-document-panel d-none"
                    >

                        <p>
                            Dokumen Company
                        </p>

                        <div class="detail-document-actions">

                            <button
                                type="button"
                                id="viewNpwpDocumentBtn"
                                class="detail-document-btn"
                            >
                                <i class='bx bx-file'></i>
                                Dokumen NPWP
                            </button>

                            <button
                                type="button"
                                id="viewBusinessLicenseBtn"
                                class="detail-document-btn"
                            >
                                <i class='bx bx-file'></i>
                                Izin Usaha
                            </button>

                            <button
                                type="button"
                                id="viewPicAuthorizationBtn"
                                class="detail-document-btn"
                            >
                                <i class='bx bx-file'></i>
                                Surat Kuasa PIC
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection