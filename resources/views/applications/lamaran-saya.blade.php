@extends('layouts.jobseeker')

@section('content')

@vite(['resources/css/lamaran-saya.css'])

{{-- ✅ Inject user_id dari localStorage ke URL --}}
<script>
(function() {
    const url    = new URL(window.location.href);
    const userId = url.searchParams.get('user_id');

    if (!userId) {
        // SESUDAH
        const userRaw = localStorage.getItem('jobseeker_user') ||
                        localStorage.getItem('user') ||
                        sessionStorage.getItem('user');
        if (userRaw) {
            try {
                const user = JSON.parse(userRaw);
                if (user && user.id) {
                    url.searchParams.set('user_id', user.id);
                    // Pertahankan filter status jika ada
                    window.location.replace(url.toString());
                }
            } catch(e) {}
        }
    }
})();
</script>

<div class="lmr-wrap">

    {{-- HEADER --}}
    <h1 class="lmr-title">Lamaran Saya</h1>
    <p class="lmr-subtitle">
        Kelola dan pantau status lamaran pekerjaan Anda dalam satu tempat.<br>
        Setiap langkah mendekatkan Anda ke tujuan profesional.
    </p>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="lmr-alert lmr-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="lmr-alert lmr-alert-error">{{ session('error') }}</div>
    @endif

    {{-- STATISTIK --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-label">Total Lamaran</div>
            <div class="stat-num" style="color:#1a3570;">{{ $stats['total'] }}</div>
            <div class="stat-bar" style="background:#1a3570;"></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sedang Review</div>
            <div class="stat-num" style="color:#0b6e69;">{{ $stats['review'] }}</div>
            <div class="stat-bar" style="background:#0b6e69;"></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Diterima</div>
            <div class="stat-num" style="color:#1a8040;">{{ $stats['diterima'] }}</div>
            <div class="stat-bar" style="background:#38D66B;"></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Menunggu</div>
            <div class="stat-num grey">{{ $stats['menunggu'] }}</div>
            <div class="stat-bar" style="background:#E5EAF3;"></div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    @php
        $uid  = request('user_id');
        $base = route('applications.lamaran-saya') . ($uid ? '?user_id=' . $uid : '');
    @endphp
    <div class="filter-row">
        <div class="filter-left">
            <a href="{{ $base }}"
               class="fpill {{ !request('status') ? 'active' : '' }}">Semua</a>
            <a href="{{ $base . '&status=REVIEW' }}"
               class="fpill {{ request('status') === 'REVIEW' ? 'active' : '' }}">Review</a>
            <a href="{{ $base . '&status=INTERVIEW' }}"
               class="fpill {{ request('status') === 'INTERVIEW' ? 'active' : '' }}">Interview</a>
            <a href="{{ $base . '&status=DITERIMA' }}"
               class="fpill {{ request('status') === 'DITERIMA' ? 'active' : '' }}">Diterima</a>
            <a href="{{ $base . '&status=DITOLAK' }}"
               class="fpill {{ request('status') === 'DITOLAK' ? 'active' : '' }}">Ditolak</a>
            <a href="{{ $base . '&status=BARU' }}"
               class="fpill {{ request('status') === 'BARU' ? 'active' : '' }}">Menunggu</a>
            <span class="showing-count">
                Menampilkan {{ $applications->firstItem() ?? 0 }}–{{ $applications->lastItem() ?? 0 }}
                dari {{ $applications->total() }} lamaran
            </span>
        </div>
        <form method="GET" action="{{ route('applications.lamaran-saya') }}" style="display:inline-flex; align-items:center; margin-left:2rem;">
            @if(request('user_id'))<input type="hidden" name="user_id" value="{{ request('user_id') }}">@endif
            @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
            <select name="sort" onchange="this.form.submit()" style="
                padding: 0.4rem 1rem;
                border-radius: 20px;
                border: 1.5px solid #e2e6f0;
                font-size: 0.82rem;
                font-weight: 600;
                color: #1a2235;
                background: #fff;
                cursor: pointer;
                font-family: inherit;
                outline: none;
            ">
                <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
            </select>
        </form>
    </div>

    {{-- DAFTAR LAMARAN --}}
    @forelse($applications as $app)

    @php
        $statusMap = [
            'BARU'      => ['label' => 'MENUNGGU',      'badge' => 'sbadge-menunggu'],
            'REVIEW'    => ['label' => 'SEDANG REVIEW', 'badge' => 'sbadge-review'],
            'INTERVIEW' => ['label' => 'INTERVIEW',     'badge' => 'sbadge-interview'],
            'DITERIMA'  => ['label' => 'DITERIMA',      'badge' => 'sbadge-diterima'],
            'DITOLAK'   => ['label' => 'DITOLAK',       'badge' => 'sbadge-ditolak'],
        ];
        $s = $statusMap[$app->status] ?? ['label' => $app->status, 'badge' => 'sbadge-menunggu'];
    @endphp

    <div class="job-card">

        {{-- Inisial posisi sebagai avatar --}}
        <div class="job-logo-initial">
            {{ strtoupper(substr($app->job->posisi ?? 'J', 0, 2)) }}
        </div>

        {{-- Info Lowongan --}}
        <div class="job-info">
            <div class="job-title">{{ $app->job->posisi ?? '-' }}</div>
            <div class="job-company">{{ $app->job->kategori ?? '-' }}</div>
            <div class="job-meta">
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ ($app->applied_at ?? $app->created_at)->translatedFormat('d M Y') }}
                </span>
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    {{ $app->job->gaji ?? '-' }}
                </span>
                <span>
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $app->updated_at->diffForHumans() }}
                </span>
            </div>
        </div>

        {{-- Status --}}
        <div class="job-status">
            <span class="sbadge {{ $s['badge'] }}">{{ $s['label'] }}</span>
            <div class="update-time">
                Deadline:
                {{ $app->job->deadline
                    ? \Carbon\Carbon::parse($app->job->deadline)->translatedFormat('d M Y')
                    : '-' }}
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="job-actions">
            <a href="{{ route('applications.show', $app->id) }}" class="btn-detail">
                Lihat Detail
            </a>
            @if($app->status === 'BARU')
            <form action="{{ route('applications.withdraw', $app->id) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menarik lamaran ini?')">
                @csrf
                <button type="submit" class="btn-withdraw">Tarik Lamaran</button>
            </form>
            @endif
        </div>

    </div>

    @empty
    <div class="lmr-empty">
        <svg width="56" height="56" viewBox="0 0 24 24" fill="none"
             stroke="#c0c8d8" stroke-width="1.5">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="12" y1="18" x2="12" y2="12"/>
            <line x1="9"  y1="15" x2="15" y2="15"/>
        </svg>
        <p>Belum ada lamaran{{ request('status') ? ' dengan status ini' : '' }}.</p>
    </div>
    @endforelse

    {{-- PAGINATION --}}
    @if($applications->hasPages())
    <div class="lmr-pagination">
        {{ $applications->appends(request()->query())->links() }}
    </div>
    @endif

</div>

@endsection