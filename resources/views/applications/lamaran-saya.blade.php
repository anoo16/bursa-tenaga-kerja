@extends('layouts.jobseeker')

@section('content')

@vite([
    'resources/css/lamaran-saya.css',
    
])

<div class="lmr-wrap">

    {{-- HEADER --}}
    <h1 class="lmr-title">Lamaran Saya</h1>
    <p class="lmr-subtitle">
        Kelola dan pantau status lamaran pekerjaan Anda dalam satu galeri yang terkurasi.<br>
        Setiap langkah mendekatkan Anda ke tujuan profesional.
    </p>

    {{-- STATISTIK --}}
    <div class="stat-row">

        <div class="stat-card">
            <div class="stat-label">Total Lamaran</div>
            <div class="stat-num">12</div>
            <div class="stat-bar" style="background:#0B6E69;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Sedang Review</div>
            <div class="stat-num">4</div>
            <div class="stat-bar" style="background:#0B6E69;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Diterima</div>
            <div class="stat-num">2</div>
            <div class="stat-bar" style="background:#38D66B;"></div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Menunggu</div>
            <div class="stat-num grey">6</div>
            <div class="stat-bar" style="background:#E5EAF3;"></div>
        </div>

    </div>

    {{-- FILTER BAR --}}
    <div class="filter-row">
        <div class="filter-left">
            <button class="fpill active" onclick="setFilter(this)">Semua</button>
            <button class="fpill" onclick="setFilter(this)">Review</button>
            <button class="fpill" onclick="setFilter(this)">Diterima</button>
            <button class="fpill" onclick="setFilter(this)">Ditolak</button>
            <button class="fpill" onclick="setFilter(this)">Menunggu</button>
            <span class="showing-count">Menampilkan 1 – 4 dari 12 lamaran</span>
        </div>
        <button class="sort-btn">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="6" y1="12" x2="18" y2="12"/>
                <line x1="10" y1="18" x2="14" y2="18"/>
            </svg>
            Urutkan: Terbaru
        </button>
    </div>

    {{-- DAFTAR LAMARAN --}}
    @php
    $jobs = [
        [
            'id'      => '1',  
            'title'   => 'Senior UX Designer',
            'company' => 'Tokopedia',
            'location'=> 'Jakarta, On-Site',
            'date'    => '12 Okt 2023',
            'status'  => 'SEDANG REVIEW',
            'badge'   => 'sbadge-review',
            'updated' => 'Diperbarui 2 hari yang lalu',
            'logo'    => 'https://upload.wikimedia.org/wikipedia/commons/4/41/Tokopedia.png',
        ],
        [
            'id'      => '2',        
            'title'   => 'Product Manager',
            'company' => 'Erajaya Group',
            'location'=> 'Bandung, Remote',
            'date'    => '08 Okt 2023',
            'status'  => 'DITERIMA',
            'badge'   => 'sbadge-diterima',
            'updated' => 'Diperbarui 5 jam yang lalu',
            'logo'    => 'https://upload.wikimedia.org/wikipedia/id/thumb/b/b1/Erajaya_Group.png/250px-Erajaya_Group.png',
        ],
        [
            'id'      => '3',
            'title'   => 'Marketing Specialist',
            'company' => 'Grab Indonesia',
            'location'=> 'Jakarta Selatan',
            'date'    => '02 Okt 2023',
            'status'  => 'DITOLAK',
            'badge'   => 'sbadge-ditolak',
            'updated' => 'Diperbarui 1 minggu yang lalu',
            'logo'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b5/Grab_logo_2019.svg/250px-Grab_logo_2019.svg.png',
        ],
        [
            'id'      => '4',
            'title'   => 'Frontend Developer',
            'company' => 'Gojek',
            'location'=> 'Yogyakarta',
            'date'    => '28 Sep 2023',
            'status'  => 'MENUNGGU',
            'badge'   => 'sbadge-menunggu',
            'updated' => 'Diperbarui 3 hari yang lalu',
            'logo'    => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/8c/Gojek_logo_2022.svg/250px-Gojek_logo_2022.svg.png',
        ],
    ];
    @endphp

    @foreach ($jobs as $job)
    <div class="job-card">

        {{-- Logo --}}
        <img
            src="{{ $job['logo'] }}"
            alt="{{ $job['company'] }}"
            class="job-logo"
            onerror="this.style.display='none'"
        >

        {{-- Info --}}
        <div class="job-info">
            <div class="job-title">{{ $job['title'] }}</div>
            <div class="job-company">{{ $job['company'] }}</div>
            <div class="job-meta">
                <span>
                    {{-- Calendar icon --}}
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8"  y1="2" x2="8"  y2="6"/>
                        <line x1="3"  y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ $job['date'] }}
                </span>
                <span>
                    {{-- Location icon --}}
                    <svg width="11" height="13" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                        <circle cx="12" cy="9" r="2.5"/>
                    </svg>
                    {{ $job['location'] }}
                </span>
            </div>
        </div>

        {{-- Status --}}
        <div class="job-status">
            <span class="sbadge {{ $job['badge'] }}">{{ $job['status'] }}</span>
            <div class="update-time">{{ $job['updated'] }}</div>
        </div>

        {{-- Tombol --}}
        <a href="{{ route('applications.show', $job['id']) }}" class="btn-detail">Lihat Detail</a>
        

    </div>
    @endforeach

</div>

<script>
function setFilter(btn) {
    document.querySelectorAll('.fpill').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}
</script>

@endsection