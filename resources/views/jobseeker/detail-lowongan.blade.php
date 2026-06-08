@extends('layouts.jobseeker')

@section('content')
<style>
/* ══ WRAP ══ */
.dl-wrap {
    padding: 2rem 2.5rem;
    background: #f5f5e8;
    min-height: 100vh;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

/* ══ BACK LINK ══ */
.dl-back {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #1C4D8D;
    text-decoration: none;
    margin-bottom: 1.4rem;
    transition: opacity 0.2s;
}
.dl-back:hover { opacity: 0.75; color: #1C4D8D; }

/* ══ HEADER CARD ══ */
.dl-header {
    background: #fff;
    border-radius: 18px;
    padding: 1.8rem 2rem;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 1.2rem;
    margin-bottom: 1.6rem;
}
.dl-header-logo {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    background: #f0f2f8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 800;
    color: #1C4D8D;
    flex-shrink: 0;
    overflow: hidden;
}
.dl-header-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 6px;
}
.dl-header-info { flex: 1; }
.dl-header-title {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1C4D8D;
    margin-bottom: 0.25rem;
    line-height: 1.25;
}
.dl-header-meta {
    display: flex;
    align-items: center;
    gap: 1.2rem;
    flex-wrap: wrap;
}
.dl-header-meta span {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.84rem;
    color: #7a8599;
}
.dl-header-meta svg { flex-shrink: 0; }

/* ══ CLOSED BADGE ══ */
.dl-closed-banner {
    background: #fff3cd;
    border: 1.5px solid #ffc107;
    border-radius: 12px;
    padding: 0.8rem 1.2rem;
    font-size: 0.88rem;
    color: #856404;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.4rem;
}

/* ══ GRID LAYOUT ══ */
.dl-grid {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 1.6rem;
    align-items: start;
}

/* ══ MAIN SECTION ══ */
.dl-main {
    display: flex;
    flex-direction: column;
    gap: 1.4rem;
}

.dl-section {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    padding: 1.6rem 1.8rem;
}
.dl-section-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1C4D8D;
    margin-bottom: 1.1rem;
    padding-bottom: 0.7rem;
    border-bottom: 2px solid #f0f2f8;
}

/* ══ LIST ITEMS ══ */
.dl-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.dl-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.92rem;
    color: #374151;
    line-height: 1.55;
}
.dl-list li .dl-check {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #e8f0fe;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}
.dl-list li .dl-check svg { color: #1C4D8D; }

/* ══ SIDEBAR ══ */
.dl-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    position: sticky;
    top: 1rem;
}

/* ══ INFO CARD ══ */
.dl-info-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.5rem 1.6rem;
}
.dl-info-row {
    display: flex;
    align-items: center;
    gap: 0.9rem;
    margin-bottom: 1.1rem;
}
.dl-info-row:last-of-type { margin-bottom: 0; }
.dl-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #f0f2f8;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.dl-info-icon svg { color: #1C4D8D; }
.dl-info-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.15rem;
}
.dl-info-value {
    font-size: 0.97rem;
    font-weight: 700;
    color: #1a2b4a;
    line-height: 1.3;
}

/* ══ ACTION BUTTONS ══ */
.dl-divider {
    height: 1px;
    background: #f0f2f8;
    margin: 1.1rem 0;
}
.btn-lamar-primary {
    display: block;
    width: 100%;
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 0.85rem 1.2rem;
    font-size: 0.95rem;
    font-weight: 700;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    transition: opacity 0.2s;
    margin-bottom: 0.75rem;
}
.btn-lamar-primary:hover { opacity: 0.88; color: #fff; }
.btn-lamar-primary.disabled-btn {
    background: #d1d5db;
    cursor: not-allowed;
    opacity: 1;
}
.btn-sudah-lamar {
    display: block;
    width: 100%;
    background: #e8f5e9;
    color: #1a8040;
    border: 2px solid #a5d6a7;
    border-radius: 12px;
    padding: 0.85rem 1.2rem;
    font-size: 0.95rem;
    font-weight: 700;
    text-align: center;
    text-decoration: none;
    font-family: inherit;
    margin-bottom: 0.75rem;
    cursor: default;
}
.btn-simpan-secondary {
    display: block;
    width: 100%;
    background: #fff;
    color: #374151;
    border: 2px solid #d1d5db;
    border-radius: 12px;
    padding: 0.75rem 1.2rem;
    font-size: 0.88rem;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    transition: border-color 0.2s, color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
}
.btn-simpan-secondary:hover {
    border-color: #1C4D8D;
    color: #1C4D8D;
}

/* ══ COMPANY CARD ══ */
.dl-company-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.4rem 1.6rem;
}
.dl-company-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.9rem;
}
.dl-company-desc {
    font-size: 0.86rem;
    color: #5a667a;
    line-height: 1.65;
    margin-bottom: 0.9rem;
}
.dl-company-link {
    font-size: 0.84rem;
    font-weight: 700;
    color: #1C4D8D;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    transition: opacity 0.2s;
}
.dl-company-link:hover { opacity: 0.75; color: #1C4D8D; }

/* ══ SARAN KARIR ══ */
.dl-saran-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.4rem 1.6rem;
}
.dl-saran-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.5rem;
}
.dl-saran-desc {
    font-size: 0.84rem;
    color: #5a667a;
    margin-bottom: 0.9rem;
    line-height: 1.55;
}
.btn-saran {
    background: #0F2854;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 0.55rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    display: inline-block;
    transition: opacity 0.2s;
}
.btn-saran:hover { opacity: 0.85; color: #fff; }

/* ══ TAG KATEGORI ══ */
.dl-tag {
    display: inline-flex;
    align-items: center;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.28rem 0.75rem;
    border-radius: 999px;
    border: 1.5px solid #d0d5e3;
    color: #5a667a;
    margin-right: 0.4rem;
    margin-bottom: 0.4rem;
}

@media (max-width: 900px) {
    .dl-wrap { padding: 1rem; }
    .dl-grid { grid-template-columns: 1fr; }
    .dl-sidebar { position: static; }
    .dl-header { flex-direction: column; align-items: flex-start; }
    .dl-header-title { font-size: 1.3rem; }
}

/* ══ MODAL ══ */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15, 40, 84, 0.45);
    backdrop-filter: blur(3px);
    z-index: 999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.modal-overlay.modal-open {
    display: flex;
}
.modal-box {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    width: 100%;
    max-width: 560px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 2rem 2.2rem;
    position: relative;
    animation: modalIn 0.25s ease;
}
@keyframes modalIn {
    from { opacity: 0; transform: translateY(20px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-header {
    margin-bottom: 1.4rem;
}
.modal-header h2 {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0F2854;
    margin-bottom: 0.2rem;
}
.modal-header p {
    font-size: 0.85rem;
    color: #7a8599;
}
.modal-close {
    position: absolute;
    top: 1.2rem;
    right: 1.4rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #9aa3b8;
    font-size: 1.3rem;
    line-height: 1;
    padding: 0.2rem;
    transition: color 0.2s;
}
.modal-close:hover { color: #1a2b4a; }
.modal-section-title {
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    color: #1C4D8D;
    margin-bottom: 0.75rem;
    margin-top: 1.2rem;
}
.modal-section-title:first-of-type { margin-top: 0; }

/* Upload Area */
.upload-area {
    border: 2px dashed #d0d5e3;
    border-radius: 14px;
    background: #fafbfe;
    padding: 1.8rem 1rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    position: relative;
}
.upload-area:hover,
.upload-area.drag-over {
    border-color: #1C4D8D;
    background: #f0f4ff;
}
.upload-area input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.upload-area .upload-icon {
    width: 44px;
    height: 44px;
    background: #e8f0fe;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.7rem;
}
.upload-area .upload-icon svg { color: #1C4D8D; }
.upload-area .upload-label {
    font-size: 0.92rem;
    font-weight: 600;
    color: #1a2b4a;
    margin-bottom: 0.2rem;
}
.upload-area .upload-hint {
    font-size: 0.78rem;
    color: #9aa3b8;
}
.upload-area .file-chosen {
    font-size: 0.82rem;
    font-weight: 600;
    color: #1C4D8D;
    margin-top: 0.5rem;
    display: none;
}

/* Portfolio Row */
.portfolio-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}
.portfolio-btn {
    border: 1.5px solid #e2e6f0;
    border-radius: 12px;
    padding: 0.85rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    cursor: pointer;
    background: #fff;
    transition: border-color 0.2s;
    position: relative;
}
.portfolio-btn:hover { border-color: #1C4D8D; }
.portfolio-btn .pb-icon {
    width: 34px;
    height: 34px;
    background: #e8f0fe;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.portfolio-btn .pb-icon svg { color: #1C4D8D; }
.portfolio-btn .pb-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: #1a2b4a;
    display: block;
    margin-bottom: 0.1rem;
}
.portfolio-btn .pb-sub {
    font-size: 0.72rem;
    color: #9aa3b8;
    display: block;
}
.portfolio-btn input[type="file"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    cursor: pointer;
    width: 100%;
    height: 100%;
}
.portfolio-btn input[type="text"] {
    position: absolute;
    inset: 0;
    opacity: 0;
    width: 100%;
}

/* Textarea Cover Letter */
.modal-textarea {
    width: 100%;
    border: 1.5px solid #e2e6f0;
    border-radius: 12px;
    padding: 0.85rem 1rem;
    font-family: inherit;
    font-size: 0.9rem;
    color: #1a2b4a;
    resize: vertical;
    outline: none;
    transition: border-color 0.2s;
    min-height: 110px;
}
.modal-textarea:focus { border-color: #1C4D8D; }
.modal-textarea-hint {
    font-size: 0.75rem;
    color: #9aa3b8;
    margin-top: 0.4rem;
}

/* Portfolio Link field */
.modal-input {
    width: 100%;
    border: 1.5px solid #e2e6f0;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-family: inherit;
    font-size: 0.88rem;
    color: #1a2b4a;
    outline: none;
    transition: border-color 0.2s;
}
.modal-input:focus { border-color: #1C4D8D; }

/* Footer Buttons */
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1.6rem;
    padding-top: 1.2rem;
    border-top: 1px solid #f0f2f8;
}
.btn-batal {
    background: none;
    border: none;
    font-size: 0.92rem;
    font-weight: 600;
    color: #1C4D8D;
    cursor: pointer;
    padding: 0.75rem 1.4rem;
    border-radius: 10px;
    transition: background 0.2s;
    font-family: inherit;
}
.btn-batal:hover { background: #f0f4ff; }
.btn-kirim {
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.8rem;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: opacity 0.2s;
}
.btn-kirim:hover { opacity: 0.88; }

</style>

<div class="dl-wrap">

    {{-- BACK --}}
    <a href="{{ route('jobs.index') }}" class="dl-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Cari Lowongan
    </a>

    {{-- HEADER --}}
    <div class="dl-header">
        <div class="dl-header-logo">
            @if($company && $company->logo_path)
                <img src="{{ asset('storage/' . $company->logo_path) }}"
                     alt="{{ $company->name }}">
            @else
                {{ strtoupper(substr($job->posisi, 0, 2)) }}
            @endif
        </div>
        <div class="dl-header-info">
            <div class="dl-header-title">{{ $job->posisi }}</div>
            <div class="dl-header-meta">
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                    </svg>
                    {{ $company->name ?? 'Perusahaan' }}
                </span>
                <span>
                    <svg width="12" height="13" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    {{ $company->hq ?? 'Indonesia' }}, On-Site
                </span>
                <span class="dl-tag">{{ $job->kategori }}</span>
                <span class="dl-tag">Full-Time</span>
            </div>
        </div>
    </div>

    {{-- BANNER TUTUP (jika lowongan sudah tutup) --}}
    @if($job->status === 'tutup')
    <div class="dl-closed-banner">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        Lowongan ini sudah ditutup dan tidak menerima lamaran baru.
    </div>
    @endif

    {{-- GRID UTAMA --}}
    <div class="dl-grid">

        {{-- ── MAIN ── --}}
        <div class="dl-main">

            {{-- Tanggung Jawab --}}
            <div class="dl-section">
                <div class="dl-section-title">Tanggung Jawab</div>
                <ul class="dl-list">
                    @forelse((array) $job->tanggung_jawab as $item)
                    <li>
                        <span class="dl-check">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        {{ $item }}
                    </li>
                    @empty
                    <li>
                        <span class="dl-check">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        Belum ada informasi tanggung jawab.
                    </li>
                    @endforelse
                </ul>
            </div>

            {{-- Kualifikasi --}}
            <div class="dl-section">
                <div class="dl-section-title">Kualifikasi</div>
                <ul class="dl-list">
                    @forelse((array) $job->kualifikasi as $item)
                    <li>
                        <span class="dl-check">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        {{ $item }}
                    </li>
                    @empty
                    <li>
                        <span class="dl-check">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="3">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        Belum ada informasi kualifikasi.
                    </li>
                    @endforelse
                </ul>
            </div>

        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="dl-sidebar">

            {{-- INFO GAJI & DEADLINE --}}
            <div class="dl-info-card">
                <div class="dl-info-row">
                    <div class="dl-info-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <rect x="2" y="6" width="20" height="12" rx="2"/>
                            <circle cx="12" cy="12" r="2"/>
                            <path d="M6 12h.01M18 12h.01"/>
                        </svg>
                    </div>
                    <div>
                        <div class="dl-info-label">Estimasi Gaji</div>
                        <div class="dl-info-value">Rp {{ $job->gaji_minimum }} - {{ $job->gaji_maksimum }}</div>
                    </div>
                </div>

                @if($job->deadline)
                <div class="dl-info-row">
                    <div class="dl-info-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <div>
                        <div class="dl-info-label">Batas Lamaran</div>
                        <div class="dl-info-value">
                            {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>
                @endif

                <div class="dl-divider"></div>

                {{-- TOMBOL AKSI --}}
                @if($job->status === 'tutup')
                    <span class="btn-lamar-primary disabled-btn">
                        Lowongan Sudah Ditutup
                    </span>

                @elseif($sudahLamar)
                    <span class="btn-sudah-lamar">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="3"
                             style="display:inline;vertical-align:middle;margin-right:4px;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Sudah Dilamar
                    </span>

                @else
                <button type="button"
                    onclick="document.getElementById('modalLamar').classList.add('modal-open')"
                    class="btn-lamar-primary"
                    style="border:none; cursor:pointer;">
                    Lamar Sekarang
                </button>
                @endif

                <a href="#" class="btn-simpan-secondary">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                    Simpan Lowongan
                </a>
            </div>

            {{-- TENTANG PERUSAHAAN --}}
            <div class="dl-company-card">
                <div class="dl-company-label">Tentang Perusahaan</div>
                <p class="dl-company-desc">
                    {{ $company->about ?? $company->description ?? 'Informasi perusahaan belum tersedia.' }}
                </p>
                @if($company)
                <a href="{{ route('company.profile') }}" class="dl-company-link">
                    Lihat Profil Lengkap
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </a>
                @endif
            </div>

            {{-- SARAN KARIR --}}
            <div class="dl-saran-card">
                <div class="dl-saran-label">Saran Karir</div>
                <p class="dl-saran-desc">
                    Ingin meningkatkan peluang diterima? Lengkapi CV Anda dengan pengalaman dan keahlian terbaru.
                </p>
                <a href="{{ route('cv.edit') }}" class="btn-saran">Buka Editor CV</a>
            </div>

        </div>
    </div>

</div>

{{-- ══════════════ MODAL LAMAR ══════════════ --}}
<div id="modalLamar" class="modal-overlay"
     onclick="if(event.target===this) this.classList.remove('modal-open')">
    <div class="modal-box">

        {{-- Close --}}
        <button class="modal-close"
                onclick="document.getElementById('modalLamar').classList.remove('modal-open')"
                type="button">
            &times;
        </button>

        {{-- Header --}}
        <div class="modal-header">
            <h2>Lengkapi Lamaran Anda</h2>
            <p>{{ $company->name ?? 'Perusahaan' }} &mdash; {{ $job->posisi }}</p>
        </div>

        <form id="formLamar" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="job_id" value="{{ $job->id }}">

            {{-- 1. Upload CV --}}
            <div class="modal-section-title">Upload Curriculum Vitae (CV)</div>
            <label class="upload-area" id="cvDropArea">
                <input type="file"
                       name="cv_file"
                       accept=".pdf,.doc,.docx"
                       onchange="showFileName(this, 'cvFileName')">
                <div class="upload-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <polyline points="16 16 12 12 8 16"/>
                        <line x1="12" y1="12" x2="12" y2="21"/>
                        <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
                    </svg>
                </div>
                <div class="upload-label">Klik atau seret file ke sini</div>
                <div class="upload-hint">Hanya mendukung PDF atau DOCX (Maks. 5MB)</div>
                <div class="file-chosen" id="cvFileName"></div>
            </label>

            {{-- 2. Portofolio --}}
            <div class="modal-section-title">Portofolio Kerja</div>
            <div class="portfolio-row">
                <label class="portfolio-btn">
                    <input type="file"
                           name="portfolio_file"
                           accept=".pdf"
                           onchange="showFileName(this, 'portfolioFileName')">
                    <div class="pb-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div>
                        <span class="pb-label" id="portfolioFileName">Upload PDF</span>
                        <span class="pb-sub">Dokumen Portfolio</span>
                    </div>
                </label>

                <div class="portfolio-btn" style="cursor:default;"
                     onclick="document.getElementById('portfolioLinkInput').focus()">
                    <div class="pb-icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                        </svg>
                    </div>
                    <div style="flex:1; overflow:hidden;">
                        <span class="pb-label">Tautan Portofolio</span>
                        <input type="text"
                               name="portfolio_link"
                               id="portfolioLinkInput"
                               placeholder="https://behance.net/..."
                               style="border:none; padding:0; font-size:0.72rem;
                                      color:#9aa3b8; background:transparent;
                                      margin-top:0.15rem; outline:none; width:100%;">
                    </div>
                </div>
            </div>

            {{-- 3. Pesan --}}
            <div class="modal-section-title">Pesan untuk Rekruiter</div>
            <textarea name="cover_letter"
                      class="modal-textarea"
                      placeholder="Tuliskan alasan mengapa Anda cocok untuk posisi ini..."></textarea>
            <p class="modal-textarea-hint">
                Opsional: Tambahkan sentuhan personal agar profil Anda menonjol.
            </p>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn-batal"
                        onclick="document.getElementById('modalLamar').classList.remove('modal-open')">
                    Batal
                </button>
                <button type="button" class="btn-kirim" id="btnKirimLamar"
                        onclick="kirimLamaran()">
                    <span id="btnKirimText">Kirim Lamaran</span>
                    <span id="btnKirimSpinner" style="display:none;">Mengirim...</span>
                    <svg id="btnKirimIcon" width="16" height="16" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script --}}
<script>
function showFileName(input, targetId) {
    const el = document.getElementById(targetId);
    if (input.files && input.files[0] && el) {
        el.textContent = '✓ ' + input.files[0].name;
        el.style.display = 'block';
    }
}

const dropArea = document.getElementById('cvDropArea');
if (dropArea) {
    ['dragenter', 'dragover'].forEach(e =>
        dropArea.addEventListener(e, () => dropArea.classList.add('drag-over'))
    );
    ['dragleave', 'drop'].forEach(e =>
        dropArea.addEventListener(e, () => dropArea.classList.remove('drag-over'))
    );
}

async function kirimLamaran() {
    const btn       = document.getElementById('btnKirimLamar');
    const txtNormal = document.getElementById('btnKirimText');
    const txtSpin   = document.getElementById('btnKirimSpinner');
    const icon      = document.getElementById('btnKirimIcon');

    // Ambil user dari localStorage (disimpan saat login)
    const userRaw = localStorage.getItem('user') || sessionStorage.getItem('user');

    if (!userRaw) {
        alert('Sesi Anda telah berakhir. Silakan login kembali.');
        window.location.href = '{{ route("login") }}';
        return;
    }

    const user = JSON.parse(userRaw);

    if (!user || !user.id) {
        alert('Data sesi tidak valid. Silakan login kembali.');
        window.location.href = '{{ route("login") }}';
        return;
    }

    // Loading state
    btn.disabled            = true;
    txtNormal.style.display = 'none';
    txtSpin.style.display   = 'inline';
    icon.style.display      = 'none';

    const form     = document.getElementById('formLamar');
    const formData = new FormData(form);

    // Tambahkan user_id dari localStorage
    formData.append('user_id', user.id);

    try {
        const response = await fetch('{{ route("applications.store") }}', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData,
        });

        const result = await response.json();

        if (response.ok && result.success) {
            document.getElementById('modalLamar').classList.remove('modal-open');
            window.location.href = result.redirect;
        } else {
            alert(result.message || 'Gagal mengirim lamaran. Silakan coba lagi.');
        }

    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
    } finally {
        btn.disabled            = false;
        txtNormal.style.display = 'inline';
        txtSpin.style.display   = 'none';
        icon.style.display      = 'inline';
    }
}
</script>

@endsection