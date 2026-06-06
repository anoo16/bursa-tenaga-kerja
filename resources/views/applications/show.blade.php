@extends('layouts.jobseeker')

@section('content')
<style>
* { box-sizing: border-box; }

.ds-wrap {
    padding: 2rem 2.5rem 3rem;
    background: #f5f5e8;
    min-height: 100vh;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

/* ══ BREADCRUMB ══ */
.ds-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.5rem;
}
.ds-breadcrumb a { color: #9aa3b8; text-decoration: none; }
.ds-breadcrumb a:hover { color: #1C4D8D; }
.ds-breadcrumb span { color: #1C4D8D; }
.ds-breadcrumb-sep { font-size: 0.65rem; }

/* ══ HEADING ROW ══ */
.ds-heading-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.8rem;
    flex-wrap: wrap;
    gap: 0.8rem;
}
.ds-heading-row h1 {
    font-size: 2rem;
    font-weight: 800;
    color: #0F2854;
    margin: 0;
    font-style: italic;
}
.ds-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.45rem 1.1rem;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 700;
    background: #fff;
    border: 2px solid #1C4D8D;
    color: #1C4D8D;
}
.ds-status-pill.sedang  { border-color: #1C4D8D; color: #1C4D8D; }
.ds-status-pill.selesai { border-color: #1a8040; color: #1a8040; }
.ds-status-pill.ditolak { border-color: #c0392b; color: #c0392b; }
.ds-status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
    flex-shrink: 0;
}

/* ══ JOB HERO CARD ══ */
.ds-job-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(15,40,84,0.07);
    padding: 1.6rem 2rem;
    display: flex;
    align-items: center;
    gap: 1.4rem;
    margin-bottom: 1.6rem;
    flex-wrap: wrap;
}
.ds-company-logo {
    width: 64px;
    height: 64px;
    border-radius: 14px;
    background: linear-gradient(135deg, #0F2854, #1C4D8D);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
    flex-shrink: 0;
    overflow: hidden;
}
.ds-company-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 6px;
}
.ds-job-info h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0F2854;
    margin: 0 0 0.25rem;
}
.ds-job-meta {
    font-size: 0.88rem;
    color: #7a8599;
    margin-bottom: 0.6rem;
}
.ds-job-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
}
.ds-tag {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.3rem 0.85rem;
    border-radius: 999px;
    border: 1.5px solid #d0d5e3;
    color: #1C4D8D;
    background: #f0f4ff;
}

/* ══ MAIN GRID ══ */
.ds-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.4rem;
    align-items: start;
}

/* ══ PROGRESS CARD ══ */
.ds-progress-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(15,40,84,0.07);
    padding: 2rem;
    border-left: 4px solid #1C4D8D;
}
.ds-progress-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0F2854;
    margin-bottom: 1.8rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.ds-progress-title::before {
    content: '';
    display: block;
    width: 4px;
    height: 20px;
    background: #1C4D8D;
    border-radius: 4px;
    flex-shrink: 0;
}

/* ══ TIMELINE STEPS ══ */
.ds-steps { position: relative; }
.ds-step {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    position: relative;
    padding-bottom: 1.8rem;
}
.ds-step:last-child { padding-bottom: 0; }

/* Garis vertikal */
.ds-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 17px;
    top: 36px;
    width: 2px;
    bottom: 0;
    background: #e2e6f0;
}
.ds-step.step-done:not(:last-child)::after    { background: #1C4D8D; }
.ds-step.step-current:not(:last-child)::after { background: #e2e6f0; }

/* ── Icon bulatan ── */
.ds-step-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    background: #f0f2f8;
    border: 2px solid #d0d5e3;
}
.ds-step.step-done .ds-step-icon {
    background: #1C4D8D;
    border-color: #1C4D8D;
}
.ds-step.step-current .ds-step-icon {
    background: #fff;
    border: 3px solid #1C4D8D;
    box-shadow: 0 0 0 4px rgba(28,77,141,0.12);
}
.ds-step.step-rejected .ds-step-icon {
    background: #fde8e8;
    border-color: #c0392b;
}
.ds-step.step-pending .ds-step-icon {
    background: #f0f2f8;
    border-color: #d0d5e3;
}

/* ── Label step ── */
.ds-step-content { flex: 1; padding-top: 0.3rem; }
.ds-step-name {
    font-size: 0.95rem;
    font-weight: 700;
    color: #1D1C18;
    margin-bottom: 0.15rem;
}
.ds-step.step-done .ds-step-name    { color: #1C4D8D; }
.ds-step.step-current .ds-step-name { color: #0F2854; }
.ds-step.step-rejected .ds-step-name { color: #c0392b; }
.ds-step.step-pending .ds-step-name  { color: #9aa3b8; }
.ds-step-sub {
    font-size: 0.78rem;
    color: #9aa3b8;
}
.ds-step.step-current .ds-step-sub { color: #1C4D8D; font-weight: 600; }

/* ══ INFO CARD (kanan) ══ */
.ds-info-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(15,40,84,0.07);
    padding: 2rem;
}
.ds-info-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1C4D8D;
    margin-bottom: 1.5rem;
}
.ds-info-row {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.ds-info-row:last-child { margin-bottom: 0; }
.ds-info-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f5f5e0;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #1C4D8D;
}
.ds-info-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.2rem;
}
.ds-info-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0F2854;
    line-height: 1.4;
}
.ds-info-action {
    font-size: 0.78rem;
    font-weight: 700;
    color: #1C4D8D;
    text-decoration: none;
    cursor: pointer;
    background: none;
    border: none;
    padding: 0;
    font-family: inherit;
    margin-left: auto;
    flex-shrink: 0;
    align-self: center;
}
.ds-info-action:hover { text-decoration: underline; }
.ds-info-desc {
    font-size: 0.85rem;
    color: #5a667a;
    line-height: 1.6;
    margin-top: 0.25rem;
}

/* ══ TARIK LAMARAN ══ */
.ds-withdraw-card {
    grid-column: 1 / -1;
    background: #fff8f8;
    border: 1.5px solid rgba(192,57,43,0.15);
    border-radius: 16px;
    padding: 1.2rem 1.6rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
}
.ds-withdraw-text {
    font-size: 0.88rem;
    color: #5a667a;
}
.ds-withdraw-text strong { color: #c0392b; }
.btn-withdraw {
    background: #fff;
    color: #c0392b;
    border: 2px solid rgba(192,57,43,0.3);
    border-radius: 10px;
    padding: 0.6rem 1.4rem;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    font-family: inherit;
    transition: all 0.2s;
}
.btn-withdraw:hover { background: #fde8e8; border-color: #c0392b; }

/* ══ EMPTY ══ */
.ds-not-found {
    background: #fff;
    border-radius: 20px;
    padding: 4rem;
    text-align: center;
    color: #9aa3b8;
}

@media (max-width: 800px) {
    .ds-wrap  { padding: 1rem; }
    .ds-grid  { grid-template-columns: 1fr; }
    .ds-withdraw-card { grid-column: 1; }
}
</style>

<div class="ds-wrap">

@if(!$application)
    <div class="ds-not-found">
        <p>Lamaran tidak ditemukan.</p>
        <a href="{{ route('applications.lamaran-saya') }}"
           style="color:#1C4D8D;font-weight:700;">Kembali ke Lamaran Saya</a>
    </div>
@else

@php
    $status    = $application->status;  // BARU / REVIEW / INTERVIEW / DITERIMA / DITOLAK
    $appliedAt = $application->applied_at ?? $application->created_at;
    $updatedAt = $application->updated_at;

    $companyName = $company->name ?? 'Perusahaan';
    $companyHq   = $company->hq ?? 'Indonesia';
    $companyLogo = $company->logo_path ?? null;
    $companyEmail = $company->website ?? null;

    // Tentukan label pill status atas
    $pillClass = match($status) {
        'DITERIMA' => 'selesai',
        'DITOLAK'  => 'ditolak',
        default    => 'sedang',
    };
    $pillLabel = match($status) {
        'BARU'      => 'Menunggu Review',
        'REVIEW'    => 'Sedang Berjalan',
        'INTERVIEW' => 'Sedang Berjalan',
        'DITERIMA'  => 'Diterima',
        'DITOLAK'   => 'Ditolak',
        default     => $status,
    };

    /*
     * Definisi tahapan seleksi.
     * step-done    = sudah selesai
     * step-current = sedang berlangsung sekarang
     * step-rejected= ditolak di tahap ini
     * step-pending = belum dimulai
     */
    $steps = [
        [
            'name' => 'Administrasi',
            'icon' => 'check',  // ikon centang
            'state' => in_array($status, ['REVIEW','INTERVIEW','DITERIMA','DITOLAK'])
                ? 'step-done' : 'step-current',
            'sub'  => in_array($status, ['REVIEW','INTERVIEW','DITERIMA','DITOLAK'])
                ? 'Selesai pada ' . $appliedAt->translatedFormat('d M Y')
                : 'Tahap Saat Ini',
        ],
        [
            'name' => 'Review Berkas',
            'icon' => 'doc',
            'state' => match(true) {
                $status === 'BARU'    => 'step-pending',
                $status === 'REVIEW'  => 'step-current',
                $status === 'DITOLAK' => 'step-rejected',
                in_array($status, ['INTERVIEW','DITERIMA']) => 'step-done',
                default => 'step-pending',
            },
            'sub' => match(true) {
                $status === 'BARU'    => 'Belum Dimulai',
                $status === 'REVIEW'  => 'Tahap Saat Ini',
                $status === 'DITOLAK' => 'Tidak Lolos',
                in_array($status, ['INTERVIEW','DITERIMA']) => 'Selesai pada ' . $updatedAt->translatedFormat('d M Y'),
                default => 'Belum Dimulai',
            },
        ],
        [
            'name' => 'Interview',
            'icon' => 'people',
            'state' => match(true) {
                in_array($status, ['BARU','REVIEW']) => 'step-pending',
                $status === 'INTERVIEW'               => 'step-current',
                $status === 'DITERIMA'                => 'step-done',
                $status === 'DITOLAK'                 => 'step-rejected',
                default => 'step-pending',
            },
            'sub' => match(true) {
                in_array($status, ['BARU','REVIEW']) => 'Belum Dimulai',
                $status === 'INTERVIEW'               => 'Tahap Saat Ini',
                $status === 'DITERIMA'                => 'Selesai',
                $status === 'DITOLAK'                 => 'Tidak Lolos',
                default => 'Belum Dimulai',
            },
        ],
        [
            'name' => 'Offering Letter',
            'icon' => 'letter',
            'state' => match(true) {
                $status === 'DITERIMA' => 'step-done',
                in_array($status, ['BARU','REVIEW','INTERVIEW']) => 'step-pending',
                default => 'step-pending',
            },
            'sub' => match(true) {
                $status === 'DITERIMA' => 'Selesai — Anda Diterima!',
                default => 'Belum Dimulai',
            },
        ],
    ];
@endphp

{{-- BREADCRUMB --}}
<div class="ds-breadcrumb">
    <a href="{{ route('applications.lamaran-saya') }}">Applications</a>
    <span class="ds-breadcrumb-sep">›</span>
    <a href="{{ route('applications.lamaran-saya') }}">{{ $companyName }}</a>
    <span class="ds-breadcrumb-sep">›</span>
    <span>Detail Seleksi</span>
</div>

{{-- HEADING --}}
<div class="ds-heading-row">
    <h1>Detail Alur Seleksi</h1>
    <div class="ds-status-pill {{ $pillClass }}">
        <span class="ds-status-dot"></span>
        {{ $pillLabel }}
    </div>
</div>

{{-- JOB HERO --}}
<div class="ds-job-card">
    <div class="ds-company-logo">
        @if($companyLogo)
            <img src="{{ asset('storage/'.$companyLogo) }}" alt="{{ $companyName }}">
        @else
            {{ strtoupper(substr($companyName, 0, 2)) }}
        @endif
    </div>
    <div class="ds-job-info">
        <h2>{{ $application->job->posisi ?? '-' }}</h2>
        <div class="ds-job-meta">
            {{ $companyName }} &bull; {{ $companyHq }}
        </div>
        <div class="ds-job-tags">
            <span class="ds-tag">Full-Time</span>
            <span class="ds-tag">{{ $application->job->kategori ?? '-' }}</span>
            <span class="ds-tag">
                Applied {{ $appliedAt->translatedFormat('d M Y') }}
            </span>
        </div>
    </div>
</div>

{{-- MAIN GRID --}}
<div class="ds-grid">

    {{-- ── KIRI: PROGRESS LAMARAN ── --}}
    <div class="ds-progress-card">
        <div class="ds-progress-title">Progress Lamaran</div>

        <div class="ds-steps">
            @foreach($steps as $step)
            <div class="ds-step {{ $step['state'] }}">

                {{-- Icon bulatan --}}
                <div class="ds-step-icon">
                    @if($step['state'] === 'step-done')
                        {{-- Centang putih --}}
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="#fff" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    @elseif($step['state'] === 'step-rejected')
                        {{-- Silang merah --}}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="#c0392b" stroke-width="3">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    @elseif($step['state'] === 'step-current')
                        {{-- Icon orang --}}
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="#1C4D8D" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    @else
                        {{-- Abu-abu --}}
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="#b0b8cb" stroke-width="2">
                            <circle cx="12" cy="12" r="4"/>
                        </svg>
                    @endif
                </div>

                {{-- Label --}}
                <div class="ds-step-content">
                    <div class="ds-step-name">{{ $step['name'] }}</div>
                    <div class="ds-step-sub">{{ $step['sub'] }}</div>
                </div>

            </div>
            @endforeach
        </div>
    </div>

    {{-- ── KANAN: INFORMASI TAHAP ── --}}
    <div class="ds-info-card">

        @if($status === 'INTERVIEW')
        {{-- INFO INTERVIEW --}}
        <div class="ds-info-title">Informasi Tahap Wawancara</div>

        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8"  y1="2" x2="8"  y2="6"/>
                    <line x1="3"  y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div class="ds-info-label">Waktu Pelaksanaan</div>
                <div class="ds-info-value">
                    Akan dikonfirmasi oleh rekruiter
                </div>
            </div>
        </div>

        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <polygon points="23 7 16 12 23 17 23 7"/>
                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div class="ds-info-label">Lokasi / Tautan</div>
                <div class="ds-info-value">
                    {{ $company->website ?? 'Akan dikonfirmasi' }}
                </div>
            </div>
            @if($company->website)??
            <a href="{{ $company->website }}" target="_blank" class="ds-info-action">
                Buka Tautan
            </a>
            @endif
        </div>

        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div class="ds-info-label">Instruksi Khusus</div>
                <div class="ds-info-value">Siapkan diri Anda</div>
                <div class="ds-info-desc">
                    Pastikan Anda hadir tepat waktu dan membawa semua dokumen yang diperlukan.
                    Rekruiter akan menghubungi Anda melalui email untuk detail lebih lanjut.
                </div>
            </div>
        </div>

        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <div style="flex:1;">
                <div class="ds-info-label">Hubungi Rekruiter</div>
                <div class="ds-info-value">{{ $company->website ?? '-' }}</div>
            </div>
        </div>

        @elseif($status === 'DITERIMA')
        {{-- INFO DITERIMA --}}
        <div class="ds-info-title" style="color:#1a8040;">🎉 Selamat, Anda Diterima!</div>
        <div class="ds-info-row">
            <div class="ds-info-icon" style="background:#e8f5e9;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#1a8040" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Status</div>
                <div class="ds-info-value" style="color:#1a8040;">Lamaran Diterima</div>
                <div class="ds-info-desc">
                    Rekruiter dari {{ $companyName }} telah menerima lamaran Anda
                    untuk posisi {{ $application->job->posisi }}.
                    Silakan tunggu konfirmasi lebih lanjut melalui email Anda.
                </div>
            </div>
        </div>
        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Hubungi Rekruiter</div>
                <div class="ds-info-value">{{ $company->website ?? '-' }}</div>
            </div>
        </div>

        @elseif($status === 'DITOLAK')
        {{-- INFO DITOLAK --}}
        <div class="ds-info-title" style="color:#c0392b;">Lamaran Tidak Lanjut</div>
        <div class="ds-info-row">
            <div class="ds-info-icon" style="background:#fde8e8;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#c0392b" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9"  y1="9" x2="15" y2="15"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Status</div>
                <div class="ds-info-value" style="color:#c0392b;">Tidak Melanjutkan</div>
                <div class="ds-info-desc">
                    Terima kasih sudah melamar di {{ $companyName }}.
                    Saat ini kami tidak dapat melanjutkan lamaran Anda.
                    Jangan menyerah — terus lamar kesempatan lainnya!
                </div>
            </div>
        </div>

        @elseif($status === 'REVIEW')
        {{-- INFO REVIEW --}}
        <div class="ds-info-title">Status Review Berkas</div>
        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Estimasi Proses</div>
                <div class="ds-info-value">3–5 Hari Kerja</div>
                <div class="ds-info-desc">
                    Tim {{ $companyName }} sedang meninjau berkas lamaran Anda.
                    Anda akan mendapatkan notifikasi jika ada perkembangan.
                </div>
            </div>
        </div>
        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Posisi Dilamar</div>
                <div class="ds-info-value">{{ $application->job->posisi ?? '-' }}</div>
            </div>
        </div>

        @else
        {{-- INFO BARU/DEFAULT --}}
        <div class="ds-info-title">Lamaran Terkirim</div>
        <div class="ds-info-row">
            <div class="ds-info-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div>
                <div class="ds-info-label">Status</div>
                <div class="ds-info-value">Menunggu Review</div>
                <div class="ds-info-desc">
                    Lamaran Anda untuk posisi {{ $application->job->posisi }}
                    di {{ $companyName }} telah berhasil terkirim.
                    Tim rekruiter akan segera meninjau berkas Anda.
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- TARIK LAMARAN (hanya status BARU) --}}
    @if($status === 'BARU')
    <div class="ds-withdraw-card">
        <div class="ds-withdraw-text">
            Ingin membatalkan? <strong>Penarikan lamaran tidak bisa dibatalkan.</strong>
        </div>
        <form action="{{ route('applications.withdraw', $application->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menarik lamaran ini?')">
            @csrf
            <button type="submit" class="btn-withdraw">Tarik Lamaran</button>
        </form>
    </div>
    @endif

</div>

@endif
</div>
@endsection