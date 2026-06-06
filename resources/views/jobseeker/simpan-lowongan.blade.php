@extends('layouts.jobseeker')

@section('content')

<style>
/* ══ BASE ══ */
.sl-wrap {
    padding: 2rem 2.5rem;
    background: #f7f7f0;
    min-height: 100vh;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

/* ══ HEADER ══ */
.sl-header { margin-bottom: 1.6rem; }
.sl-header h1 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1a2235;
    line-height: 1.15;
    margin-bottom: 0.35rem;
}
.sl-header h1 span { color: #2563EB; }
.sl-header p {
    color: #7a8599;
    font-size: 0.88rem;
    max-width: 480px;
}

/* ══ TOP BAR (sort + search) ══ */
.sl-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.4rem;
    flex-wrap: wrap;
}
.sl-sort-row {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    font-size: 0.82rem;
    color: #7a8599;
    font-weight: 500;
}
.sort-select {
    border: 1.5px solid #e2e6f0;
    border-radius: 10px;
    padding: 0.42rem 0.85rem;
    font-size: 0.84rem;
    color: #1a2235;
    background: #fff;
    outline: none;
    cursor: pointer;
    font-family: inherit;
    font-weight: 600;
}
.sl-search-form {
    display: flex;
    align-items: center;
    gap: 0;
    background: #fff;
    border: 1.5px solid #e2e6f0;
    border-radius: 12px;
    overflow: hidden;
    padding: 0 0.8rem;
    flex: 0 0 260px;
}
.sl-search-form svg { color: #b0b8cb; flex-shrink: 0; }
.sl-search-form input {
    border: none;
    outline: none;
    font-size: 0.84rem;
    color: #1a2235;
    padding: 0.52rem 0.5rem;
    width: 100%;
    font-family: inherit;
    background: transparent;
}
.sl-search-form input::placeholder { color: #c0c8d8; }

/* ══ GRID ══ */
.saved-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* ══ KARTU SIMPAN ══ */
.saved-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #ebebeb;
    padding: 1.3rem;
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    transition: box-shadow 0.18s, border-color 0.18s, transform 0.18s;
}
.saved-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,0.09);
    border-color: #d0d5e3;
    transform: translateY(-2px);
}

/* Tombol hapus (bookmark merah di kanan atas) */
.btn-unsave {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #e74c3c;
    padding: 0;
    line-height: 0;
    transition: opacity 0.18s, transform 0.15s;
}
.btn-unsave:hover { opacity: 0.75; transform: scale(1.1); }

/* Ikon / inisial */
.sc-logo {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    background: #f4f6fb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    font-weight: 800;
    color: #1a2235;
    flex-shrink: 0;
    margin-bottom: 0.9rem;
}
.sc-logo svg { width: 22px; height: 22px; color: #9aa3b8; }

/* Kategori badge */
.sc-cat {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.3rem;
}

/* Judul & perusahaan */
.sc-title {
    font-size: 1rem;
    font-weight: 800;
    color: #1a2235;
    line-height: 1.3;
    margin-bottom: 0.15rem;
}
.sc-company { font-size: 0.8rem; color: #9aa3b8; margin-bottom: 0.65rem; }

/* Meta info */
.sc-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem 0.85rem;
    font-size: 0.72rem;
    color: #9aa3b8;
    margin-bottom: 1rem;
    flex: 1;
}
.sc-meta span {
    display: flex;
    align-items: center;
    gap: 0.22rem;
}
.sc-meta .deadline-warn { color: #e74c3c; font-weight: 600; }

/* Footer tombol */
.sc-footer {
    display: flex;
    gap: 0.55rem;
    align-items: center;
    margin-top: auto;
}
.btn-apply-now {
    flex: 1;
    background: #1a2235;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.62rem 1rem;
    font-size: 0.84rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    display: block;
    transition: background 0.18s;
    font-family: inherit;
}
.btn-apply-now:hover { background: #2563EB; color: #fff; }
.btn-apply-now.sudah-lamar {
    background: #e8f5e9;
    color: #1a8040;
    cursor: default;
    font-size: 0.75rem;
}
.btn-detail-sm {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    border: 1.5px solid #e2e6f0;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5a667a;
    cursor: pointer;
    text-decoration: none;
    transition: border-color 0.18s, color 0.18s;
    flex-shrink: 0;
}
.btn-detail-sm:hover { border-color: #1a2235; color: #1a2235; }

/* ══ INSIGHTS CARD ══ */
.insights-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid #ebebeb;
    padding: 1.4rem;
    display: flex;
    gap: 1.2rem;
    align-items: center;
}
.insights-text { flex: 1; }
.insights-text h3 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1a2235;
    margin-bottom: 0.5rem;
}
.insights-text p {
    font-size: 0.8rem;
    color: #7a8599;
    line-height: 1.55;
    margin-bottom: 1rem;
}
.insights-stats {
    display: flex;
    gap: 1.5rem;
}
.insights-stat-num {
    font-size: 1.6rem;
    font-weight: 800;
    color: #1a2235;
    line-height: 1;
    margin-bottom: 0.18rem;
}
.insights-stat-label {
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #9aa3b8;
}
.insights-chart {
    width: 130px;
    height: 90px;
    background: #f8f9fc;
    border-radius: 12px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 6px;
    padding: 14px 14px 10px;
    flex-shrink: 0;
}
.chart-bar {
    background: #1a2235;
    border-radius: 3px 3px 0 0;
    width: 18px;
    transition: height 0.4s ease;
}

/* ══ EMPTY STATE ══ */
.sl-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #b0b8cb;
}
.sl-empty p {
    font-size: 0.93rem;
    margin-top: 1rem;
    margin-bottom: 1.4rem;
}
.sl-empty a {
    display: inline-block;
    background: #1a2235;
    color: #fff;
    text-decoration: none;
    padding: 0.65rem 1.6rem;
    border-radius: 12px;
    font-size: 0.87rem;
    font-weight: 700;
    transition: background 0.18s;
}
.sl-empty a:hover { background: #2563EB; }

/* ══ ALERT ══ */
.sl-alert {
    border-radius: 10px;
    padding: 0.75rem 1.1rem;
    font-size: 0.85rem;
    margin-bottom: 1.2rem;
    font-weight: 500;
}
.sl-alert-success { background: #e8f5e9; color: #1a8040; }
.sl-alert-error   { background: #ffeaea; color: #c0392b; }

/* ══ CLEAR ALL ══ */
.btn-clear-all {
    background: none;
    border: 1.5px solid #fca5a5;
    color: #e74c3c;
    border-radius: 10px;
    padding: 0.42rem 1rem;
    font-size: 0.78rem;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    transition: all 0.18s;
    white-space: nowrap;
}
.btn-clear-all:hover { background: #ffeaea; }

/* ══ PAGINATION ══ */
.sl-pagination { display: flex; justify-content: center; margin-top: 0.5rem; }

@media (max-width: 900px) {
    .saved-grid { grid-template-columns: repeat(2, 1fr); }
    .sl-wrap { padding: 1rem; }
}
@media (max-width: 600px) {
    .saved-grid { grid-template-columns: 1fr; }
    .insights-card { flex-direction: column; }
    .insights-chart { width: 100%; height: 70px; }
}
</style>

{{-- Auto inject user_id ke URL dari localStorage --}}
<script>
(function() {
    const url = new URL(window.location.href);
    if (!url.searchParams.get('user_id')) {
        try {
            const u = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user') || '{}');
            if (u && u.id) {
                url.searchParams.set('user_id', u.id);
                window.location.replace(url.toString());
            }
        } catch(e) {}
    }
})();
</script>

<div class="sl-wrap">

    {{-- HEADER --}}
    <div class="sl-header">
        <h1>Lowongan<br><span>Tersimpan</span></h1>
        <p>Tinjau lowongan yang Anda tandai dan selesaikan lamaran Anda.</p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="sl-alert sl-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="sl-alert sl-alert-error">{{ session('error') }}</div>
    @endif

    @if($savedJobs->isNotEmpty())

    {{-- TOPBAR: sort + search + clear --}}
    <div class="sl-topbar">
        <div class="sl-sort-row">
            <span>Urutkan:</span>
            <select class="sort-select" onchange="window.location=this.value">
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}"
                    {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>
                    Terbaru Disimpan
                </option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'az']) }}"
                    {{ request('sort') === 'az' ? 'selected' : '' }}>
                    A → Z
                </option>
                <option value="{{ request()->fullUrlWithQuery(['sort' => 'deadline']) }}"
                    {{ request('sort') === 'deadline' ? 'selected' : '' }}>
                    Deadline Terdekat
                </option>
            </select>
        </div>

        <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
            {{-- Search --}}
            <form method="GET" action="{{ route('jobseeker.simpan') }}" class="sl-search-form">
                @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}">@endif
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" placeholder="Cari lowongan tersimpan..."
                       value="{{ request('search') }}">
            </form>

            {{-- Clear all --}}
            <form action="{{ route('jobseeker.simpan.clear') }}" method="POST"
                  onsubmit="return confirm('Hapus semua lowongan tersimpan?')">
                @csrf
                <button type="submit" class="btn-clear-all">Hapus Semua</button>
            </form>
        </div>
    </div>

    {{-- GRID --}}
    <div class="saved-grid">

        {{-- INSIGHTS CARD (selalu posisi pertama) --}}
        <div class="insights-card">
            <div class="insights-text">
                <h3>Ringkasan Simpanan</h3>
                <p>
                    Anda telah menyimpan
                    <strong>{{ $totalSimpan }}</strong> lowongan.
                    @if($segeraDeadline > 0)
                        <strong>{{ $segeraDeadline }}</strong> lowongan akan segera ditutup dalam 7 hari ke depan.
                    @else
                        Pantau terus agar tidak ketinggalan peluang terbaik.
                    @endif
                </p>
                <div class="insights-stats">
                    <div>
                        <div class="insights-stat-num">{{ str_pad($totalSimpan, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="insights-stat-label">Lowongan Tersimpan</div>
                    </div>
                    <div>
                        <div class="insights-stat-num">{{ str_pad($segeraDeadline, 2, '0', STR_PAD_LEFT) }}</div>
                        <div class="insights-stat-label">Segera Tutup</div>
                    </div>
                </div>
            </div>
            {{-- Mini bar chart --}}
            <div class="insights-chart" id="insightsChart">
                @php
                    $maxBar = max($totalSimpan, 1);
                    $barData = [
                        min(90, round(($sudahDilamar / $maxBar) * 90)),
                        min(90, round(($segeraDeadline / $maxBar) * 90)),
                        min(90, round(($totalSimpan / max($totalSimpan, 1)) * 90)),
                    ];
                @endphp
                @foreach($barData as $h)
                    <div class="chart-bar" style="height: {{ max(8, $h) }}px;"></div>
                @endforeach
            </div>
        </div>

        {{-- KARTU LOWONGAN TERSIMPAN --}}
        @foreach($savedJobs as $saved)
        @php
            $job      = $saved->job;
            $initials = strtoupper(substr($job->posisi ?? 'JB', 0, 2));
            $deadline = $job->deadline ? \Carbon\Carbon::parse($job->deadline) : null;
            $sisaHari = $deadline ? now()->diffInDays($deadline, false) : null;
            $isWarn   = $sisaHari !== null && $sisaHari >= 0 && $sisaHari <= 7;
            $sudahLamar = $appliedJobIds->contains($job->id);
        @endphp
        <div class="saved-card">

            {{-- Tombol hapus dari simpanan --}}
            <form action="{{ route('jobseeker.simpan.remove', $saved->id) }}"
                  method="POST" style="position:absolute;top:0.9rem;right:0.9rem;"
                  onsubmit="return confirm('Hapus lowongan ini dari simpanan?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-unsave" title="Hapus dari simpanan">
                    <svg width="16" height="18" viewBox="0 0 24 24" fill="#e74c3c" stroke="#e74c3c" stroke-width="1.5">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                    </svg>
                </button>
            </form>

            {{-- Ikon --}}
            <div class="sc-logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="7" width="20" height="14" rx="2"/>
                    <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                </svg>
            </div>

            {{-- Info --}}
            <div class="sc-cat">{{ $job->kategori ?? '-' }}</div>
            <div class="sc-title">{{ $job->posisi ?? '-' }}</div>
            <div class="sc-company">{{ $company->name ?? 'Perusahaan' }}</div>

            <div class="sc-meta">
                @if($company->hq ?? null)
                <span>
                    <svg width="10" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    {{ $company->hq }}
                </span>
                @endif
                @if($job->gaji)
                <span>
                    <svg width="10" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    Rp {{ $job->gaji }}
                </span>
                @endif
                @if($deadline)
                <span class="{{ $isWarn ? 'deadline-warn' : '' }}">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    @if($isWarn)
                        Tutup {{ $sisaHari == 0 ? 'hari ini' : 'dalam '.$sisaHari.' hari' }}
                    @else
                        {{ $deadline->translatedFormat('d M Y') }}
                    @endif
                </span>
                @endif
            </div>

            {{-- Tombol aksi --}}
            <div class="sc-footer">
                @if($sudahLamar)
                    <span class="btn-apply-now sudah-lamar">
                        ✓ Sudah Dilamar
                    </span>
                @else
                    <a href="{{ route('jobs.show', $job->id) }}" class="btn-apply-now">
                        Lamar Sekarang
                    </a>
                @endif
                <a href="{{ route('jobs.show', $job->id) }}" class="btn-detail-sm" title="Lihat detail">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                        <polyline points="15 3 21 3 21 9"/>
                        <line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                </a>
            </div>

        </div>
        @endforeach

    </div>

    {{-- PAGINATION --}}
    @if(method_exists($savedJobs, 'hasPages') && $savedJobs->hasPages())
    <div class="sl-pagination">{{ $savedJobs->appends(request()->query())->links() }}</div>
    @endif

    @else

    {{-- EMPTY STATE --}}
    <div class="sl-empty">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#c0c8d8" stroke-width="1.5">
            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
        </svg>
        <p>Belum ada lowongan yang Anda simpan.<br>Jelajahi lowongan dan klik ikon simpan untuk menambahkannya.</p>
        <a href="{{ route('jobs.index') }}">Cari Lowongan Sekarang</a>
    </div>

    @endif

</div>

@endsection
