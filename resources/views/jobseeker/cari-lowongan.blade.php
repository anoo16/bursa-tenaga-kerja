@extends('layouts.jobseeker')

@section('content')
<style>
/* ══ BASE ══ */
.cl-wrap {
    padding: 2rem 2.5rem;
    background: #f7f7f0;
    min-height: 100vh;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

/* ══ HERO ══ */
.cl-hero { margin-bottom: 2rem; }
.cl-hero h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a2235;
    line-height: 1.15;
    margin-bottom: 0.35rem;
}
.cl-hero h1 span { color: #2563EB; }
.cl-hero p {
    color: #7a8599;
    font-size: 0.93rem;
    margin-bottom: 1.5rem;
}

/* ══ SEARCH BAR ══ */
.cl-searchbar {
    display: flex;
    gap: 0;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    overflow: hidden;
    max-width: 680px;
    border: 1.5px solid #e8eaf0;
}
.cl-searchbar .sb-field {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0 1.2rem;
    flex: 1;
    border-right: 1px solid #f0f2f7;
}
.cl-searchbar .sb-field svg { color: #b0b8cb; flex-shrink: 0; }
.cl-searchbar input {
    border: none;
    outline: none;
    font-size: 0.92rem;
    color: #1a2235;
    width: 100%;
    padding: 0.95rem 0;
    background: transparent;
    font-family: inherit;
}
.cl-searchbar input::placeholder { color: #c0c8d8; }
.cl-searchbar button {
    background: #031c7e;
    color: #fff;
    border: none;
    padding: 0 2rem;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    font-family: inherit;
    letter-spacing: 0.02em;
    transition: background 0.18s;
}
.cl-searchbar button:hover { background: #052cca; }

/* ══ LAYOUT ══ */
.cl-body {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 1.6rem;
    align-items: start;
}

/* ══ SIDEBAR FILTER ══ */
.cl-filter {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #e8eaf0;
    padding: 1.4rem 1.3rem 1.2rem;
    position: sticky;
    top: 1rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.cl-filter-title {
    font-size: 0.87rem;
    font-weight: 800;
    color: #1a2235;
    margin-bottom: 1.3rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding-bottom: 1rem;
    border-bottom: 1.5px solid #f0f2f7;
}
.cl-filter-section {
    margin-bottom: 1.2rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid #f0f2f7;
}
.cl-filter-section:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.cl-filter-label {
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.8rem;
}

/* Radio chips untuk KATEGORI */
.kategori-grid {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.cl-radio-item {
    display: flex;
    align-items: center;
    gap: 0;
    cursor: pointer;
    position: relative;
}
.cl-radio-item input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}
.cl-radio-chip {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    width: 100%;
    padding: 0.52rem 0.75rem;
    border-radius: 10px;
    border: 1.5px solid #e8eaf0;
    background: #f8f9fc;
    font-size: 0.75rem;
    font-weight: 600;
    color: #5a667a;
    transition: all 0.15s;
    cursor: pointer;
    user-select: none;
}
.cl-radio-chip .chip-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    border: 2px solid #c5ccd8;
    flex-shrink: 0;
    transition: all 0.15s;
}
.cl-radio-item input[type="radio"]:checked + .cl-radio-chip {
    background: #eef3ff;
    border-color: #2563EB;
    color: #1a2235;
}
.cl-radio-item input[type="radio"]:checked + .cl-radio-chip .chip-dot {
    background: #2563EB;
    border-color: #2563EB;
}
.cl-radio-chip:hover {
    border-color: #c5d0e8;
    background: #f0f4ff;
}

/* Gaji slider + inputs */
.salary-slider-wrap { margin-top: 0.4rem; }
.salary-inputs-row {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 0.4rem;
    margin-bottom: 0.85rem;
}
.salary-input-box {
    position: relative;
}
.salary-input-box input {
    width: 100%;
    border: 1.5px solid #e2e6f0;
    border-radius: 10px;
    padding: 0.52rem 0.6rem;
    font-size: 0.75rem;
    color: #1a2235;
    outline: none;
    font-family: inherit;
    background: #f8f9fc;
    transition: border-color 0.15s;
    box-sizing: border-box;
}
.salary-input-box input:focus { border-color: #2563EB; background: #fff; }
.salary-sep { font-size: 0.8rem; color: #b0b8cb; text-align: center; flex-shrink: 0; }
.salary-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    margin-bottom: 0.85rem;
}
.salary-preset-btn {
    padding: 0.28rem 0.6rem;
    border-radius: 20px;
    border: 1.5px solid #e2e6f0;
    background: #f8f9fc;
    font-size: 0.68rem;
    font-weight: 600;
    color: #5a667a;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.15s;
    white-space: nowrap;
}
.salary-preset-btn:hover,
.salary-preset-btn.active {
    background: #eef3ff;
    border-color: #2563EB;
    color: #2563EB;
}
.btn-terapkan-gaji {
    width: 100%;
    background: #1a2235;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.58rem;
    font-size: 0.8rem;
    font-weight: 700;
    cursor: pointer;
    font-family: inherit;
    transition: background 0.18s;
    letter-spacing: 0.02em;
}
.btn-terapkan-gaji:hover { background: #2563EB; }

/* Select industri */
.cl-filter-section select {
    width: 100%;
    padding: 0.55rem 0.8rem;
    border-radius: 10px;
    border: 1.5px solid #e2e6f0;
    font-size: 0.82rem;
    color: #1a2235;
    background: #f8f9fc;
    outline: none;
    cursor: pointer;
    font-family: inherit;
    transition: border-color 0.15s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239aa3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.7rem center;
    padding-right: 2rem;
}
.cl-filter-section select:focus { border-color: #2563EB; }

/* Tombol aksi bawah */
.filter-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 0.2rem;
}
.btn-reset {
    width: 100%;
    background: #fff;
    border: 1.5px solid #e2e6f0;
    border-radius: 10px;
    padding: 0.55rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #8a95a8;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.18s;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    text-decoration: none;
}
.btn-reset:hover { border-color: #e05252; color: #e05252; background: #fff8f8; }

/* Active filter badge */
.filter-active-count {
    display: none;
    background: #2563EB;
    color: #fff;
    font-size: 0.6rem;
    font-weight: 800;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    margin-left: auto;
}

/* ══ MAIN ══ */
.cl-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.1rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.cl-count { font-size: 0.88rem; color: #7a8599; }
.cl-count strong { color: #1a2235; }
.cl-sort {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.84rem;
    color: #7a8599;
}
.cl-sort select {
    border: 1.5px solid #e2e6f0;
    border-radius: 8px;
    padding: 0.38rem 0.75rem;
    font-size: 0.84rem;
    color: #1a2235;
    background: #fff;
    outline: none;
    cursor: pointer;
    font-family: inherit;
}

/* ══ GRID ══ */
.cl-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.4rem;
}

/* ══ JOB CARD ══ */
.jc {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #ebebeb;
    padding: 1.3rem 1.3rem 1.1rem;
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    transition: box-shadow 0.18s, border-color 0.18s, transform 0.18s;
    cursor: pointer;
}
.jc:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.09);
    border-color: #193481;
    transform: translateY(-2px);
}

/* Featured Card */
.jc.featured {
    grid-column: 1 / -1;
    background: #081f56;
    border-color: #1a2235;
    color: #fff;
    flex-direction: row;
    align-items: center;
    gap: 1.4rem;
    padding: 1.6rem 1.8rem;
    border-radius: 20px;
}
.jc.featured:hover { box-shadow: 0 8px 32px rgba(26,34,53,0.28); transform: translateY(-2px); }

/* Logo */
.jc-logo {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #f4f6fb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 800;
    color: #081f56;
    flex-shrink: 0;
    overflow: hidden;
    margin-bottom: 0.9rem;
}
.jc-logo img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
.jc.featured .jc-logo {
    background: rgba(255,255,255,0.12);
    color: #fff;
    width: 58px;
    height: 58px;
    margin-bottom: 0;
    font-size: 1.15rem;
}

/* Bookmark */
.jc-bookmark {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #d0d5e3;
    padding: 0;
    line-height: 0;
    transition: color 0.18s;
}
.jc-bookmark:hover, .jc-bookmark.saved { color: #1a2235; }
.jc.featured .jc-bookmark { color: rgba(255,255,255,0.35); }
.jc.featured .jc-bookmark:hover { color: #fff; }

/* Text */
.jc-label {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.25rem;
}
.jc.featured .jc-label { color: rgba(255,255,255,0.5); }

.jc-title {
    font-size: 1rem;
    font-weight: 800;
    color: #1a2235;
    line-height: 1.3;
    margin-bottom: 0.15rem;
}
.jc.featured .jc-title { color: #fff; font-size: 1.25rem; margin-bottom: 0.2rem; }

.jc-company {
    font-size: 0.82rem;
    color: #9aa3b8;
    margin-bottom: 0.75rem;
}
.jc.featured .jc-company { color: rgba(255,255,255,0.65); margin-bottom: 0.75rem; }

/* Tags */
.jc-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    margin-bottom: 1rem;
}
.jc-tag {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.22rem 0.65rem;
    border-radius: 6px;
    border: 1.5px solid #e2e6f0;
    color: #5a667a;
    background: #f8f9fc;
}
.jc.featured .jc-tag { border-color: rgba(255,255,255,0.25); color: rgba(255,255,255,0.8); background: rgba(255,255,255,0.08); }

/* Footer */
.jc-footer { display: flex; align-items: flex-end; justify-content: space-between; margin-top: auto; }
.jc-salary-label {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #b0b8cb;
    margin-bottom: 0.12rem;
}
.jc.featured .jc-salary-label { color: rgba(255,255,255,0.5); }
.jc-salary { font-size: 0.92rem; font-weight: 600; color: #1a2235; }
.jc.featured .jc-salary { color: #fff; font-size: 1rem; }

.jc-location {
    font-size: 0.75rem;
    color: #b0b8cb;
    display: flex;
    align-items: center;
    gap: 0.22rem;
    margin-top: 0.2rem;
}
.jc.featured .jc-location { color: rgba(255,255,255,0.55); }

.jc-body { flex: 1; }

/* Buttons */
.btn-apply-featured {
    background: #fff;
    color: #1a2235;
    border: none;
    border-radius: 12px;
    padding: 0.7rem 1.5rem;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    transition: opacity 0.18s, transform 0.18s;
    font-family: inherit;
    display: inline-block;
}
.btn-apply-featured:hover { opacity: 0.9; color: #1a2235; transform: scale(1.02); }

.btn-apply {
    background: #031c7e;
    color: #fff;
    border: none;
    border-radius: 9px;
    padding: 0.48rem 1.1rem;
    font-size: 0.78rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.18s;
    font-family: inherit;
    display: inline-block;
    letter-spacing: 0.01em;
}
.btn-apply:hover { background: #031c7e; color: #fff; }
.btn-apply.sudah-lamar { background: #e8f5e9; color: #1a8040; cursor: default; }

.applied-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: #e8f5e9;
    color: #1a8040;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 0.22rem 0.65rem;
    border-radius: 999px;
    letter-spacing: 0.05em;
}

.jc-deadline {
    font-size: 0.7rem;
    color: #e74c3c;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.22rem;
    margin-top: 0.25rem;
}

/* ══ EMPTY ══ */
.cl-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #b0b8cb;
}
.cl-empty p { font-size: 0.95rem; margin-top: 1rem; }

/* ══ PAGINATION ══ */
/* ══ PAGINATION ══ */
.cl-pagination { display: flex; justify-content: center; margin-top: 0.8rem; }

/* ── Override Laravel Tailwind Pagination ── */
.cl-pagination nav { width: 100%; }
.cl-pagination nav > div:first-child { display: none !important; }
.cl-pagination nav > div:last-child > div:first-child { display: none !important; }
.cl-pagination nav > div:last-child {
    display: flex !important;
    justify-content: center !important;
    flex-direction: row !important;
}
.cl-pagination nav > div:last-child > div:last-child {
    display: flex !important;
    flex-direction: row !important;
}
.cl-pagination .shadow-sm {
    box-shadow: none !important;
    display: flex !important;
    flex-direction: row !important;
    gap: 0.3rem !important;
    align-items: center !important;
    flex-wrap: nowrap !important;
}
.cl-pagination [class*="sm:flex"] { display: flex !important; flex-direction: row !important; }
.cl-pagination [class*="sm:flex-1"] { display: none !important; }
.cl-pagination [class*="sm:items-center"] { align-items: center !important; }
.cl-pagination [class*="sm:justify-between"] { justify-content: center !important; }
.cl-pagination span.inline-flex.rtl\:flex-row-reverse {
    display: flex !important;
    flex-direction: row !important;
    gap: 0.3rem !important;
}
.cl-pagination [class*="inline-flex"] {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 32px !important;
    height: 32px !important;
    min-width: 32px !important;
    padding: 0 !important;
    margin: 0 !important;
    border-radius: 8px !important;
    font-size: 0.82rem !important;
    font-weight: 500 !important;
    font-family: 'Sora', sans-serif !important;
    color: #4b5563 !important;
    background: #fff !important;
    border: 1.5px solid #e5e7eb !important;
    text-decoration: none !important;
    box-shadow: none !important;
    line-height: 1 !important;
    transition: background 0.15s, border-color 0.15s, color 0.15s !important;
}
.cl-pagination a[class*="inline-flex"]:hover {
    background: #f3f4f6 !important;
    border-color: #d1d5db !important;
    color: #111827 !important;
}
.cl-pagination span[aria-current="page"] > span {
    background: #0D1B4B !important;
    border-color: #0D1B4B !important;
    color: #fff !important;
    font-weight: 600 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    width: 32px !important;
    height: 32px !important;
    min-width: 32px !important;
    padding: 0 !important;
    margin: 0 !important;
    border-radius: 8px !important;
    font-size: 0.82rem !important;
    border: 1.5px solid #0D1B4B !important;
    cursor: default !important;
}
.cl-pagination [class*="inline-flex"] svg {
    width: 14px !important;
    height: 14px !important;
    flex-shrink: 0 !important;
}

@media (max-width: 900px) {
    .cl-body { grid-template-columns: 1fr; }
    .cl-grid { grid-template-columns: 1fr; }
    .jc.featured { flex-direction: column; align-items: flex-start; }
    .cl-wrap { padding: 1rem; }
}
</style>

{{-- Auto inject user_id ke URL dari localStorage --}}
<script>
(function() {
    const url    = new URL(window.location.href);
    if (!url.searchParams.get('user_id')) {
        try {
            const u = JSON.parse(
                localStorage.getItem('jobseeker_user') ||
                localStorage.getItem('user') ||
                sessionStorage.getItem('user') ||
                '{}'
            );

            if (u && u.id) {
                url.searchParams.set('user_id', u.id);
                window.location.replace(url.toString());
            }
        } catch(e) {}
    }
})();
</script>

<div class="cl-wrap">

    {{-- HERO --}}
    <div class="cl-hero">
        <h1>Temukan<br><span>Lowongan Terbaik</span></h1>
        <p>Jelajahi posisi yang sesuai dengan keahlian dan minat Anda</p>

        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="cl-searchbar">
                <div class="sb-field">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" placeholder="Cari Posisi Pekerjaan" value="{{ request('search') }}">
                </div>
                <div class="sb-field" style="border-right:none; max-width:170px;">
                    <svg width="13" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <input type="text" name="lokasi" placeholder="Lokasi" value="{{ request('lokasi') }}">
                </div>
                @if(request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                <button type="submit">Cari</button>
            </div>
        </form>
    </div>

    {{-- BODY --}}
    <div class="cl-body">

        {{-- SIDEBAR FILTER --}}
        <div class="cl-filter">
            <div class="cl-filter-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                    <line x1="11" y1="18" x2="13" y2="18"/>
                </svg>
                Filter Pencarian
                <span class="filter-active-count" id="filterActiveCount"></span>
            </div>

            <form method="GET" action="{{ route('jobs.index') }}" id="filterForm">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('lokasi'))<input type="hidden" name="lokasi" value="{{ request('lokasi') }}">@endif
                {{-- user_id dipertahankan --}}
                @if(request('user_id'))<input type="hidden" name="user_id" value="{{ request('user_id') }}">@endif

                {{-- TIPE PEKERJAAN --}}
                <div class="cl-filter-section">
                    <div class="cl-filter-label">Tipe Pekerjaan</div>
                    <div class="kategori-grid">
                        @foreach([
                            ['val'=>'KONTRAK',    'icon'=>'💼'],
                            ['val'=>'PEKERJA TETAP',      'icon'=>'🏢'],
                            ['val'=>'PARUH WAKTU','icon'=>'⏰'],
                            ['val'=>'MAGANG',     'icon'=>'🎓'],
                        ] as $item)
                        <label class="cl-radio-item">
                            <input type="radio" name="jenis" value="{{ $item['val'] }}"
                                {{ request('jenis') === $item['val'] ? 'checked' : '' }}
                                onchange="document.getElementById('filterForm').submit()">
                            <span class="cl-radio-chip">
                                <span class="chip-dot"></span>
                                {{ $item['val'] }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- RENTANG GAJI --}}
                <div class="cl-filter-section">
                    <div class="cl-filter-label">Rentang Gaji (Bulanan)</div>
                    <div class="salary-slider-wrap">
                        <div class="salary-inputs-row">
                            <div class="salary-input-box">
                                <input type="text" id="gaji_min_input" name="gaji_min"
                                    placeholder="Min" value="{{ request('gaji_min') }}"
                                    autocomplete="off">
                            </div>
                            <span class="salary-sep">—</span>
                            <div class="salary-input-box">
                                <input type="text" id="gaji_max_input" name="gaji_max"
                                    placeholder="Maks" value="{{ request('gaji_max') }}"
                                    autocomplete="off">
                            </div>
                        </div>

                        {{-- Preset cepat --}}
                        <div class="salary-presets" id="salaryPresets">
                            <button type="button" class="salary-preset-btn {{ request('gaji_min')==='3' && request('gaji_max')==='5' ? 'active' : '' }}"
                                    data-min="3" data-max="5">3–5 Jt</button>
                            <button type="button" class="salary-preset-btn {{ request('gaji_min')==='5' && request('gaji_max')==='10' ? 'active' : '' }}"
                                    data-min="5" data-max="10">5–10 Jt</button>
                            <button type="button" class="salary-preset-btn {{ request('gaji_min')==='10' && request('gaji_max')==='20' ? 'active' : '' }}"
                                    data-min="10" data-max="20">10–20 Jt</button>
                            <button type="button" class="salary-preset-btn {{ request('gaji_min')==='20' && !request('gaji_max') ? 'active' : '' }}"
                                    data-min="20" data-max="">20 Jt+</button>
                        </div>

                        <button type="button" class="btn-terapkan-gaji" id="btnTerapkanGaji">
                            Terapkan Filter Gaji
                        </button>
                    </div>
                </div>

                {{-- BIDANG INDUSTRI --}}
                <div class="cl-filter-section">
                    <div class="cl-filter-label">Bidang Industri</div>
                    <select name="jenis_bidang" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Industri</option>
                        @foreach($jenis_bidangs as $bidang)
                            <option value="{{ $bidang }}" {{ request('jenis_bidang') === $bidang ? 'selected' : '' }}>
                                {{ $bidang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="filter-actions">
                    <a href="{{ route('jobs.index') }}{{ request('user_id') ? '?user_id='.request('user_id') : '' }}" class="btn-reset">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="1 4 1 10 7 10"/><polyline points="23 20 23 14 17 14"/>
                            <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"/>
                        </svg>
                        Reset Semua Filter
                    </a>
                </div>
            </form>
        </div>

        {{-- MAIN --}}
        <div class="cl-main">
            <div class="cl-topbar">
                <div class="cl-count">
                    Menampilkan <strong>{{ $totalJobs }}</strong> lowongan ditemukan
                </div>
                <div class="cl-sort">
                    Urutkan:
                    <select name="sort" onchange="location.href='{{ route('jobs.index') }}?sort='+this.value+'{{ request('search') ? '&search='.request('search') : '' }}{{ request('kategori') ? '&kategori='.request('kategori') : '' }}'">
                        <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
            </div>

            <div class="cl-grid">
                @forelse($jobs as $i => $job)
                @php
                    $isFeatured  = ($i === 0 && $jobs->currentPage() === 1 && !request('search') && !request('kategori'));
                    $sudahLamar  = $appliedJobIds->contains($job->id);
                    $sudahSimpan = isset($savedJobIds) && $savedJobIds->contains($job->id);
                    $initials    = strtoupper(substr($job->posisi, 0, 2));
                    $isExpiring  = $job->deadline && \Carbon\Carbon::parse($job->deadline)->diffInDays(now()) <= 7;
                @endphp

            
                {{-- REGULAR CARD --}}
                <div class="jc" onclick="window.location='{{ route('jobs.show', $job->id) }}'">
                    <button class="jc-bookmark {{ $sudahSimpan ? 'saved' : '' }}"
                            data-job-id="{{ $job->id }}"
                            title="{{ $sudahSimpan ? 'Hapus dari simpanan' : 'Simpan lowongan' }}"
                            onclick="event.stopPropagation(); toggleSimpan(this, {{ $job->id }})">
                        <svg width="15" height="17" viewBox="0 0 24 24"
                             fill="{{ $sudahSimpan ? 'currentColor' : 'none' }}"
                             stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                    </button>

                    <div class="jc-logo">{{ $initials }}</div>

                    <div class="jc-title">{{ $job->posisi }}</div>
                    <div class="jc-company">{{ $company->name ?? 'Perusahaan' }}</div>

                    <div class="jc-tags">
                        <span class="jc-tag">{{ Str::limit($job->jenis_bidang) }}</span>
                        <span class="jc-tag">{{ Str::limit($job->kategori, 12) }}</span>
                        @if($isExpiring)
                            <span class="jc-tag" style="border-color:#fca5a5; color:#e74c3c; background:#fff5f5;">Segera Tutup</span>

                    </div>

                    <div class="jc-footer">
                        <div>
                            <div class="jc-salary-label">Gaji Pokok</div>
                            <div class="jc-salary">Rp {{ number_format($job->gaji_minimum, 0, ',', '.') }} – {{ number_format($job->gaji_maksimum, 0, ',', '.') }}</div>
                            <div class="jc-location">
                                <svg width="10" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                    <circle cx="12" cy="9" r="2.5"/>
                                </svg>
                                {{ $company->hq ?? 'Indonesia' }}
                            </div>
                        </div>
                        @if($sudahLamar)
                            <span class="applied-badge">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                Dilamar
                            </span>
                        @else
                            <a href="{{ route('jobs.show', $job->id) }}" class="btn-apply" onclick="event.stopPropagation()">Lamar</a>
                        @endif
                    </div>
                </div>
                @endif

                @empty
                <div class="cl-empty">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d0d5e3" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <p>Tidak ada lowongan yang ditemukan.</p>
                </div>
                @endforelse
            </div>

            @if($jobs->hasPages())
            <div class="cl-pagination">{{ $jobs->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Toast notifikasi simpan --}}
<div id="simpanToast" style="
    position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
    background:#1a2235; color:#fff; padding:0.75rem 1.3rem;
    border-radius:12px; font-size:0.85rem; font-weight:600;
    box-shadow:0 4px 20px rgba(0,0,0,0.18);
    opacity:0; transition:opacity 0.3s; pointer-events:none;
"></div>

<script>
// ── Filter Gaji: preset & terapkan ──
(function () {
    const presets = document.querySelectorAll('.salary-preset-btn');
    const minInput = document.getElementById('gaji_min_input');
    const maxInput = document.getElementById('gaji_max_input');
    const btnTerapkan = document.getElementById('btnTerapkanGaji');

    // Klik preset → isi input lalu highlight
    presets.forEach(function (btn) {
        btn.addEventListener('click', function () {
            presets.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            minInput.value = this.dataset.min ? this.dataset.min + 'jt' : '';
            maxInput.value = this.dataset.max ? this.dataset.max + 'jt' : '';
        });
    });

    // Ketik manual → hapus highlight preset
    [minInput, maxInput].forEach(function (inp) {
        if (!inp) return;
        inp.addEventListener('input', function () {
            presets.forEach(p => p.classList.remove('active'));
        });
    });

    // Tombol Terapkan → submit form
    if (btnTerapkan) {
        btnTerapkan.addEventListener('click', function () {
            document.getElementById('filterForm').submit();
        });
    }

    // Enter di input gaji juga submit
    [minInput, maxInput].forEach(function (inp) {
        if (!inp) return;
        inp.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                document.getElementById('filterForm').submit();
            }
        });
    });

    // Hitung & tampilkan jumlah filter aktif
    function updateActiveCount() {
        const params = new URLSearchParams(window.location.search);
        let count = 0;
        if (params.get('jenis')) count++;
        if (params.get('gaji_min') || params.get('gaji_max')) count++;
        if (params.get('kategori')) count++;
        const badge = document.getElementById('filterActiveCount');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }
    updateActiveCount();
})();

// ── Toggle simpan/hapus lowongan via AJAX ──
function toggleSimpan(btn, jobId) {
    const userId = (function() {
        const url = new URL(window.location.href);
        const uid = url.searchParams.get('user_id');
        if (uid) return uid;
        try {
        const u = JSON.parse(
            localStorage.getItem('jobseeker_user') ||
            localStorage.getItem('user') ||
            sessionStorage.getItem('user') ||
            '{}'
        );
            return u.id || null;
        } catch(e) { return null; }
    })();

    if (!userId) {
        showToast('Silakan login terlebih dahulu.');
        return;
    }

    fetch(`/jobs/${jobId}/simpan?user_id=${userId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        const svg = btn.querySelector('svg');
        if (data.saved) {
            svg.setAttribute('fill', 'currentColor');
            btn.classList.add('saved');
            btn.title = 'Hapus dari simpanan';
        } else {
            svg.setAttribute('fill', 'none');
            btn.classList.remove('saved');
            btn.title = 'Simpan lowongan';
        }
        showToast(data.message || (data.saved ? 'Lowongan disimpan.' : 'Lowongan dihapus dari simpanan.'));
    })
    .catch(() => showToast('Terjadi kesalahan, coba lagi.'));
}

function showToast(msg) {
    const toast = document.getElementById('simpanToast');
    toast.textContent = msg;
    toast.style.opacity = '1';
    setTimeout(() => toast.style.opacity = '0', 2500);
}
</script>
@endsection
