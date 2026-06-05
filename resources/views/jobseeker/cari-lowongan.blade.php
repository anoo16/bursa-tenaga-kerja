@extends('layouts.jobseeker')

@section('content')
<style>
/* ══ BASE ══ */
.cl-wrap {
    padding: 2rem 2.5rem;
    background: #f0f2f8;
    min-height: 100vh;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

/* ══ HERO ══ */
.cl-hero {
    margin-bottom: 2rem;
}
.cl-hero h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #0F2854;
    line-height: 1.2;
    margin-bottom: 0.4rem;
}
.cl-hero h1 span { color: #1C4D8D; }
.cl-hero p {
    color: #7a8599;
    font-size: 0.95rem;
    margin-bottom: 1.4rem;
}

/* ══ SEARCH BAR ══ */
.cl-searchbar {
    display: flex;
    gap: 0;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(15,40,84,0.10);
    overflow: hidden;
    max-width: 700px;
}
.cl-searchbar .sb-field {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0 1.2rem;
    flex: 1;
    border-right: 1px solid #edf0f7;
}
.cl-searchbar .sb-field svg { color: #9aa3b8; flex-shrink: 0; }
.cl-searchbar input {
    border: none;
    outline: none;
    font-size: 0.92rem;
    color: #1a2b4a;
    width: 100%;
    padding: 1rem 0;
    background: transparent;
    font-family: inherit;
}
.cl-searchbar input::placeholder { color: #b0b8cb; }
.cl-searchbar button {
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    padding: 0 2rem;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    font-family: inherit;
    transition: opacity 0.2s;
}
.cl-searchbar button:hover { opacity: 0.9; }

/* ══ LAYOUT GRID ══ */
.cl-body {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 1.6rem;
    align-items: start;
}

/* ══ SIDEBAR FILTER ══ */
.cl-filter {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.5rem;
    position: sticky;
    top: 1rem;
}
.cl-filter-title {
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.cl-filter-section {
    margin-bottom: 1.4rem;
    padding-bottom: 1.4rem;
    border-bottom: 1px solid #f0f2f8;
}
.cl-filter-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
.cl-filter-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: #1a2b4a;
    margin-bottom: 0.8rem;
}
.cl-filter-section select {
    width: 100%;
    padding: 0.6rem 0.9rem;
    border-radius: 10px;
    border: 1.5px solid #e2e6f0;
    font-size: 0.86rem;
    color: #1a2b4a;
    background: #f8f9fc;
    outline: none;
    cursor: pointer;
    font-family: inherit;
}
.cl-filter-section select:focus { border-color: #1C4D8D; }
.btn-reset {
    width: 100%;
    background: #fff;
    border: 1.5px solid #d0d5e3;
    border-radius: 10px;
    padding: 0.6rem;
    font-size: 0.86rem;
    font-weight: 600;
    color: #5a667a;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.2s;
    margin-top: 0.4rem;
}
.btn-reset:hover { border-color: #1C4D8D; color: #1C4D8D; }

/* ══ MAIN CONTENT ══ */
.cl-main {}
.cl-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.2rem;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.cl-count {
    font-size: 0.88rem;
    color: #7a8599;
}
.cl-count strong { color: #1a2b4a; }
.cl-sort {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.86rem;
    color: #7a8599;
}
.cl-sort select {
    border: 1.5px solid #e2e6f0;
    border-radius: 8px;
    padding: 0.4rem 0.8rem;
    font-size: 0.86rem;
    color: #1a2b4a;
    background: #fff;
    outline: none;
    cursor: pointer;
    font-family: inherit;
}

/* ══ JOB GRID ══ */
.cl-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.1rem;
    margin-bottom: 1.4rem;
}

/* ══ JOB CARD ══ */
.jc {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 1.4rem;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
    position: relative;
    transition: box-shadow 0.2s, transform 0.2s;
    border: 1.5px solid transparent;
}
.jc:hover {
    box-shadow: 0 8px 24px rgba(15,40,84,0.12);
    transform: translateY(-2px);
    border-color: rgba(28,77,141,0.15);
}

/* Card Featured */
.jc.featured {
    grid-column: 1 / -1;
    flex-direction: row;
    align-items: center;
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    gap: 1.5rem;
}

/* Logo */
.jc-logo {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #f4f6fb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    font-weight: 800;
    color: #1C4D8D;
    flex-shrink: 0;
    overflow: hidden;
}
.jc-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}
.jc.featured .jc-logo {
    background: rgba(255,255,255,0.15);
    color: #fff;
    width: 64px;
    height: 64px;
    font-size: 1.3rem;
}

/* Bookmark */
.jc-bookmark {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #c0c8d8;
    padding: 0;
    transition: color 0.2s;
}
.jc-bookmark:hover { color: #1C4D8D; }
.jc-bookmark.saved { color: #1C4D8D; }
.jc.featured .jc-bookmark { color: rgba(255,255,255,0.5); }
.jc.featured .jc-bookmark:hover { color: #fff; }

/* Content */
.jc-body { flex: 1; }
.jc-label {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.3rem;
}
.jc.featured .jc-label { color: rgba(255,255,255,0.6); }

.jc-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #1a2b4a;
    margin-bottom: 0.15rem;
    line-height: 1.3;
}
.jc.featured .jc-title { color: #fff; font-size: 1.3rem; }

.jc-company {
    font-size: 0.85rem;
    color: #7a8599;
    margin-bottom: 0.6rem;
}
.jc.featured .jc-company { color: rgba(255,255,255,0.75); }

/* Tags */
.jc-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-bottom: 0.8rem;
}
.jc-tag {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.25rem 0.7rem;
    border-radius: 999px;
    border: 1.5px solid #d0d5e3;
    color: #5a667a;
    background: transparent;
}
.jc.featured .jc-tag {
    border-color: rgba(255,255,255,0.3);
    color: rgba(255,255,255,0.85);
}

/* Footer */
.jc-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    flex-wrap: wrap;
}
.jc-salary-label {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.15rem;
}
.jc.featured .jc-salary-label { color: rgba(255,255,255,0.6); }
.jc-salary {
    font-size: 1rem;
    font-weight: 800;
    color: #1a2b4a;
}
.jc.featured .jc-salary { color: #fff; font-size: 1.1rem; }

.jc-location {
    font-size: 0.78rem;
    color: #9aa3b8;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.jc.featured .jc-location { color: rgba(255,255,255,0.7); }

/* Apply button featured */
.btn-apply-featured {
    background: #fff;
    color: #0F2854;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.6rem;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    flex-shrink: 0;
    transition: opacity 0.2s;
    font-family: inherit;
    display: inline-block;
}
.btn-apply-featured:hover { opacity: 0.9; color: #0F2854; }

/* Apply button normal */
.btn-apply {
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.55rem 1.2rem;
    font-size: 0.82rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: opacity 0.2s;
    font-family: inherit;
    display: inline-block;
}
.btn-apply:hover { opacity: 0.88; color: #fff; }
.btn-apply.sudah-lamar {
    background: #e8f5e9;
    color: #1a8040;
    cursor: default;
}

/* Deadline badge */
.jc-deadline {
    font-size: 0.72rem;
    color: #e74c3c;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* ══ EMPTY STATE ══ */
.cl-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #9aa3b8;
}
.cl-empty svg { margin-bottom: 1rem; }
.cl-empty p { font-size: 1rem; }

/* ══ PAGINATION ══ */
.cl-pagination {
    display: flex;
    justify-content: center;
    margin-top: 0.5rem;
}

/* ══ APPLIED BADGE ══ */
.applied-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: #e8f5e9;
    color: #1a8040;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.25rem 0.7rem;
    border-radius: 999px;
    letter-spacing: 0.05em;
}

@media (max-width: 900px) {
    .cl-body { grid-template-columns: 1fr; }
    .cl-grid { grid-template-columns: 1fr; }
    .jc.featured { flex-direction: column; }
    .cl-wrap { padding: 1rem; }
}
</style>

<div class="cl-wrap">

    {{-- HERO & SEARCH --}}
    <div class="cl-hero">
        <h1>Discover Your<br><span>Next Future</span></h1>
        <p>Explore the roles that interest you</p>

        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="cl-searchbar">
                <div class="sb-field">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search"
                           placeholder="Cari Posisi Pekerjaan"
                           value="{{ request('search') }}">
                </div>
                <div class="sb-field" style="border-right:none; max-width:180px;">
                    <svg width="14" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    <input type="text" name="lokasi"
                           placeholder="Lokasi"
                           value="{{ request('lokasi') }}">
                </div>
                {{-- Pertahankan filter lain saat search --}}
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <button type="submit">Search</button>
            </div>
        </form>
    </div>

    {{-- BODY --}}
    <div class="cl-body">

        {{-- ── SIDEBAR FILTER ── --}}
        <div class="cl-filter">
            <div class="cl-filter-title">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="8" y1="12" x2="16" y2="12"/>
                    <line x1="11" y1="18" x2="13" y2="18"/>
                </svg>
                Refine Collection
            </div>

            <form method="GET" action="{{ route('jobs.index') }}" id="filterForm">
                {{-- Pertahankan search --}}
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Filter Kategori --}}
                <div class="cl-filter-section">
                    <div class="cl-filter-label">Kategori</div>
                    <select name="kategori" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat }}"
                                {{ request('kategori') === $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Sort --}}
                <div class="cl-filter-section">
                    <div class="cl-filter-label">Urutkan</div>
                    <select name="sort" onchange="document.getElementById('filterForm').submit()">
                        <option value="terbaru" {{ request('sort','terbaru') === 'terbaru' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                        <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>
                            Terlama
                        </option>
                    </select>
                </div>

                {{-- Reset --}}
                <a href="{{ route('jobs.index') }}" class="btn-reset">
                    Reset Semua Filter
                </a>
            </form>
        </div>

        {{-- ── MAIN CONTENT ── --}}
        <div class="cl-main">

            {{-- Top bar --}}
            <div class="cl-topbar">
                <div class="cl-count">
                    Menampilkan
                    <strong>{{ $jobs->firstItem() ?? 0 }}–{{ $jobs->lastItem() ?? 0 }}</strong>
                    dari <strong>{{ $totalJobs }}</strong> lowongan tersedia
                </div>
            </div>

            {{-- Grid Lowongan --}}
            <div class="cl-grid">

                @forelse($jobs as $i => $job)

                @php
                    $isFeatured = ($i === 0 && $jobs->currentPage() === 1 && !request('search') && !request('kategori'));
                    $sudahLamar = $appliedJobIds->contains($job->id);
                    $initials   = strtoupper(substr($job->posisi, 0, 2));
                    $isExpiring = $job->deadline && \Carbon\Carbon::parse($job->deadline)->diffInDays(now()) <= 7;
                @endphp

                @if($isFeatured)
                {{-- ── FEATURED CARD ── --}}
                <div class="jc featured">
                    <div class="jc-logo">{{ $initials }}</div>

                    <div class="jc-body">
                        <div class="jc-label">Featured Opportunity</div>
                        <div class="jc-title">{{ $job->posisi }}</div>
                        <div class="jc-company">
                            {{ $company->name ?? 'Perusahaan' }}
                        </div>
                        <div class="jc-tags">
                            <span class="jc-tag">{{ $job->kategori }}</span>
                            <span class="jc-tag">Full-Time</span>
                            @if($job->deadline)
                                <span class="jc-tag">
                                    Deadline: {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div style="display:flex; flex-direction:column; align-items:flex-end; gap:0.8rem; flex-shrink:0;">
                        <div>
                            <div class="jc-salary-label">Offered Package</div>
                            <div class="jc-salary">Rp {{ $job->gaji }}</div>
                        </div>
                        @if($sudahLamar)
                            <span class="applied-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="3">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                Sudah Dilamar
                            </span>
                        @else
                            <a href="{{ route('jobs.show', $job->id) }}"
                               class="btn-apply-featured">
                                Apply for Role
                            </a>
                        @endif
                    </div>

                    <button class="jc-bookmark" title="Simpan">
                        <svg width="18" height="20" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                    </button>
                </div>

                @else
                {{-- ── REGULAR CARD ── --}}
                <div class="jc">
                    <button class="jc-bookmark" title="Simpan">
                        <svg width="16" height="18" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                    </button>

                    <div style="display:flex; align-items:center; gap:0.8rem;">
                        <div class="jc-logo">{{ $initials }}</div>
                        <div>
                            <div class="jc-title">{{ $job->posisi }}</div>
                            <div class="jc-company">
                                {{ $company->name ?? 'Perusahaan' }}
                            </div>
                        </div>
                    </div>

                    <div class="jc-tags">
                        <span class="jc-tag">{{ $job->kategori }}</span>
                        <span class="jc-tag">Full-Time</span>
                        @if($isExpiring)
                            <span class="jc-tag" style="border-color:#e74c3c; color:#e74c3c;">
                                Segera Tutup
                            </span>
                        @endif
                    </div>

                    <div class="jc-footer">
                        <div>
                            <div class="jc-salary-label">
                                {{ $job->deadline ? 'Salary Range' : 'Base Compensation' }}
                            </div>
                            <div class="jc-salary" style="font-size:0.92rem; color:#1a2b4a;">
                                Rp {{ $job->gaji }}
                            </div>
                            @if($job->deadline)
                                <div class="jc-deadline">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2.5">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') }}
                                </div>
                            @endif
                        </div>

                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:0.4rem;">
                            <div class="jc-location">
                                <svg width="10" height="12" viewBox="0 0 24 24" fill="none"
                                     stroke="currentColor" stroke-width="2">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                    <circle cx="12" cy="9" r="2.5"/>
                                </svg>
                                {{ $company->hq ?? 'Indonesia' }}
                            </div>

                            @if($sudahLamar)
                                <span class="applied-badge">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="3">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>
                                    Dilamar
                                </span>
                            @else
                                <a href="{{ route('jobs.show', $job->id) }}"
                                   class="btn-apply">
                                    Lamar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <div class="cl-empty">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
                         stroke="#c0c8d8" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <p>Tidak ada lowongan
                        {{ request('search') ? 'untuk "'.request('search').'"' : '' }}
                        {{ request('kategori') ? 'di kategori "'.request('kategori').'"' : '' }}
                        saat ini.
                    </p>
                </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            @if($jobs->hasPages())
            <div class="cl-pagination">
                {{ $jobs->links() }}
            </div>
            @endif

        </div>
    </div>
</div>
@endsection