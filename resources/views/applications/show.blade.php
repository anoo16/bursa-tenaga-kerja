@extends('layouts.jobseeker')

@section('content')

<style>
/* ══ BASE ══ */
.detail-wrap {
    padding: 1.8rem 2.5rem;
    background: #f0f2f8;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* ══ BREADCRUMB ══ */
.breadcrumb-bar {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.breadcrumb-bar span { color: #9aa3b8; }
.breadcrumb-bar .current { color: #1a3570; }

/* ══ PAGE HEADER ══ */
.page-header-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.4rem;
}
.page-title {
    font-size: 1.9rem;
    font-weight: 800;
    color: #1a3570;
    margin: 0;
    font-style: italic;
}
.status-pill {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    background: #fff;
    border-radius: 999px;
    padding: 0.4rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: #1a3570;
    box-shadow: 0 1px 6px rgba(0,0,0,0.08);
}
.status-pill .dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #1a3570;
    display: inline-block;
}

/* ══ JOB INFO CARD ══ */
.job-info-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.5rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.4rem;
    margin-bottom: 1.8rem;
}
.job-logo-big {
    width: 72px;
    height: 72px;
    object-fit: contain;
    border-radius: 14px;
    border: 1px solid #edf0f7;
    padding: 5px;
    background: #fff;
    flex-shrink: 0;
}
.job-card-name {
    font-size: 1.3rem;
    font-weight: 800;
    color: #1a2b4a;
    margin-bottom: 0.2rem;
}
.job-card-sub {
    font-size: 0.9rem;
    color: #7a8599;
    margin-bottom: 0.7rem;
}
.tag-row { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.tag-pill {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.28rem 0.9rem;
    border-radius: 999px;
    border: 1.5px solid #d0d5e3;
    color: #5a667a;
    background: transparent;
}

/* ══ TWO-COLUMN BODY ══ */
.body-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: start;
}

/* ══ PROGRESS SECTION ══ */
.progress-section {}
.section-heading {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a2b4a;
    margin-bottom: 1.4rem;
}
.section-heading::before {
    content: '';
    display: inline-block;
    width: 28px;
    height: 3px;
    background: #1a3570;
    border-radius: 2px;
}

/* ══ TIMELINE ══ */
.timeline { position: relative; padding-left: 0; list-style: none; margin: 0; }
.tl-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    position: relative;
    padding-bottom: 2rem;
}
.tl-item:last-child { padding-bottom: 0; }

/* vertical line */
.tl-item:not(:last-child) .tl-icon-wrap::after {
    content: '';
    position: absolute;
    left: 19px;
    top: 40px;
    width: 2px;
    height: calc(100% - 8px);
    background: #d8dde8;
}

.tl-icon-wrap {
    position: relative;
    flex-shrink: 0;
    width: 40px;
    height: 40px;
}
.tl-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    font-weight: 700;
    flex-shrink: 0;
}
/* States */
.tl-icon.done     { background: #0B6E69; color: #fff; }
.tl-icon.failed   { background: #e74c3c; color: #fff; }
.tl-icon.active   {
    background: #fff;
    color: #1a3570;
    border: 2.5px solid #1a3570;
}
.tl-icon.pending  {
    background: #fff;
    border: 2.5px solid #d0d5e3;
    color: #c0c8d8;
}

.tl-content { padding-top: 0.35rem; }
.tl-title {
    font-size: 0.96rem;
    font-weight: 700;
    color: #1a2b4a;
    margin-bottom: 0.15rem;
}
.tl-title.muted { color: #a0a8bb; font-weight: 600; }
.tl-sub {
    font-size: 0.8rem;
    color: #9aa3b8;
}

/* ══ INFO CARD (RIGHT) ══ */
.info-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.6rem 1.8rem;
}
.info-card-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1a3570;
    margin-bottom: 1.4rem;
}
.info-row {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 0.9rem 0;
    border-bottom: 1px solid #f0f2f8;
}
.info-row:last-child { border-bottom: none; padding-bottom: 0; }
.info-icon-wrap {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f4f6fb;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #7a8599;
}
.info-body { flex: 1; min-width: 0; }
.info-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.2rem;
}
.info-value {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1a3570;
    line-height: 1.4;
}
.info-value.normal {
    font-weight: 400;
    color: #4a5568;
    font-size: 0.85rem;
}
.info-action {
    font-size: 0.82rem;
    font-weight: 600;
    color: #1a3570;
    white-space: nowrap;
    cursor: pointer;
    align-self: center;
    flex-shrink: 0;
}
</style>

<div class="detail-wrap">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-bar">
        <span>Applications</span>
        <span>/</span>
        <span>Tokopedia</span>
        <span>/</span>
        <span class="current">Detail Seleksi</span>
    </div>

    {{-- PAGE HEADER --}}
    <div class="page-header-row">
        <h1 class="page-title">Detail Alur Seleksi</h1>
        <div class="status-pill">
            <span class="dot"></span>
            Sedang Berjalan
        </div>
    </div>

    {{-- JOB INFO CARD --}}
    <div class="job-info-card">
        <img
            src="https://upload.wikimedia.org/wikipedia/commons/4/41/Tokopedia.png"
            alt="Tokopedia"
            class="job-logo-big"
            onerror="this.style.display='none'"
        >
        <div>
            <div class="job-card-name">Senior UI Designer</div>
            <div class="job-card-sub">Tokopedia &bull; Jakarta Selatan</div>
            <div class="tag-row">
                <span class="tag-pill">Full-Time</span>
                <span class="tag-pill">Design Team</span>
                <span class="tag-pill">Applied 12 Oct</span>
            </div>
        </div>
    </div>

    {{-- BODY GRID --}}
    <div class="body-grid">

        {{-- KIRI: TIMELINE --}}
        <div class="progress-section">
            <div class="section-heading">Progress Lamaran</div>

            <ul class="timeline">

                {{-- 1: Selesai --}}
                <li class="tl-item">
                    <div class="tl-icon-wrap">
                        <div class="tl-icon done">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                    </div>
                    <div class="tl-content">
                        <div class="tl-title">Administrasi</div>
                        <div class="tl-sub">Selesai pada 14 Okt 2023</div>
                    </div>
                </li>

                {{-- 2: Gagal / Tidak Lanjut --}}
                <li class="tl-item">
                    <div class="tl-icon-wrap">
                        <div class="tl-icon failed">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6"  y1="6" x2="18" y2="18"/>
                            </svg>
                        </div>
                    </div>
                    <div class="tl-content">
                        <div class="tl-title">Wawancara HR</div>
                        <div class="tl-sub">Selesai pada 20 Okt 2023</div>
                    </div>
                </li>

                {{-- 3: Aktif Saat Ini --}}
                <li class="tl-item">
                    <div class="tl-icon-wrap">
                        <div class="tl-icon active">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                    </div>
                    <div class="tl-content">
                        <div class="tl-title">Wawancara User &amp; LGD</div>
                        <div class="tl-sub" style="color:#1a3570;font-weight:600;">Tahap Saat Ini</div>
                    </div>
                </li>

                {{-- 4: Belum Dimulai --}}
                <li class="tl-item">
                    <div class="tl-icon-wrap">
                        <div class="tl-icon pending"></div>
                    </div>
                    <div class="tl-content">
                        <div class="tl-title muted">Tes Teknis</div>
                        <div class="tl-sub">Belum Dimulai</div>
                    </div>
                </li>

                {{-- 5: Belum Dimulai --}}
                <li class="tl-item">
                    <div class="tl-icon-wrap">
                        <div class="tl-icon pending"></div>
                    </div>
                    <div class="tl-content">
                        <div class="tl-title muted">Offering Letter</div>
                        <div class="tl-sub">Belum Dimulai</div>
                    </div>
                </li>

            </ul>
        </div>

        {{-- KANAN: INFO WAWANCARA --}}
        <div class="info-card">
            <div class="info-card-title">Informasi Tahap Wawancara</div>

            {{-- Waktu --}}
            <div class="info-row">
                <div class="info-icon-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Waktu Pelaksanaan</div>
                    <div class="info-value">Kamis, 24 Oktober 2023 | 10:00 WIB</div>
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="info-row">
                <div class="info-icon-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2"/>
                        <line x1="8" y1="21" x2="16" y2="21"/>
                        <line x1="12" y1="17" x2="12" y2="21"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Lokasi / Tautan</div>
                    <div class="info-value">Google Meet Link</div>
                </div>
                <span class="info-action">Salin Tautan</span>
            </div>

            {{-- Instruksi --}}
            <div class="info-row">
                <div class="info-icon-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Instruksi Khusus</div>
                    <div class="info-value normal">
                        Siapkan portofolio terbaru dan pastikan koneksi internet stabil.
                        LGD (Leaderless Group Discussion) akan dilakukan bersama 5 kandidat
                        lainnya untuk membahas studi kasus produk marketplace.
                    </div>
                </div>
            </div>

            {{-- Hubungi --}}
            <div class="info-row">
                <div class="info-icon-wrap">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                </div>
                <div class="info-body">
                    <div class="info-label">Hubungi Rekruiter</div>
                    <div class="info-value">@gmailhrd/company</div>
                </div>
                <span class="info-action">Salin Gmail</span>
            </div>

        </div>

    </div>

</div>

@endsection