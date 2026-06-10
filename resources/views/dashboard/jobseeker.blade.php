@extends('layouts.jobseeker')

@section('content')

@vite([
    'resources/css/dashboard.css',
    'resources/js/dashboardjobseeker.js'
])

{{-- STATISTIC --}}
<div class="stats-grid">

    <div class="stat-card">

        <div class="icon-box green">
            <i class='bx bx-file'></i>
        </div>

        <p>TOTAL LAMARAN</p>

        <h1>{{ $totalLamaran ?? 0 }}</h1>

    </div>

    <div class="stat-card">

        <div class="icon-box teal">
            <i class='bx bx-loader-circle'></i>
        </div>

        <p>SEDANG DIPROSES</p>

        <h1>{{ $diproses ?? 0 }}</h1>

    </div>

    <div class="stat-card">

        <div class="icon-box light-green">
            <i class='bx bx-check-circle'></i>
        </div>

        <p>DITERIMA</p>

        <h1>{{ $diterima ?? 0 }}</h1>

    </div>

    <div class="stat-card">

        <div class="icon-box red">
            <i class='bx bx-x-circle'></i>
        </div>

        <p>DITOLAK</p>

        <h1>{{ $ditolak ?? 0 }}</h1>

    </div>

</div>

{{-- CONTENT --}}
<div class="dashboard-content">

    {{-- TABLE --}}
    <div class="application-section">
    
        <div class="section-header">
    
            <h2>Lamaran Terbaru</h2>
    
            <a href="{{ route('applications.lamaran-saya') }}{{ request('user_id') ? '?user_id='.request('user_id') : '' }}">Lihat Semua</a>
    
        </div>
    
        <div class="application-table">
    
            <div class="table-head">
    
                <span>POSISI</span>
                <span>PERUSAHAAN</span>
                <span>STATUS</span>
                <span>TANGGAL</span>
    
            </div>
    
            @forelse ($lamaranTerbaru as $lamaran)
    
                {{-- ROW --}}
                <div class="table-row">
    
                    <h4>{{ $lamaran->job->posisi ?? '-' }}</h4>
    
                    <p>{{ optional($lamaran->job->company)->name ?? '-' }}</p>
    
                    @php
                        $status    = strtoupper($lamaran->status ?? 'BARU');
                        $statusMap = [
                            'BARU'      => ['label' => 'MENUNGGU', 'class' => 'waiting'],
                            'REVIEW'    => ['label' => 'REVIEW',   'class' => 'review'],
                            'INTERVIEW' => ['label' => 'REVIEW',   'class' => 'review'],
                            'DITERIMA'  => ['label' => 'DITERIMA', 'class' => 'accepted'],
                            'DITOLAK'   => ['label' => 'DITOLAK',  'class' => 'rejected'],
                        ];
                        $badge = $statusMap[$status] ?? ['label' => $status, 'class' => 'waiting'];
                    @endphp
    
                    <span class="status {{ $badge['class'] }}">
                        {{ $badge['label'] }}
                    </span>
    
                    <small>{{ \Carbon\Carbon::parse($lamaran->created_at)->translatedFormat('d M Y') }}</small>
    
                </div>
    
            @empty
    
                <div class="table-row">
                    <h4 style="grid-column: 1 / -1; text-align: center; color: #888;">Belum ada lamaran.</h4>
                </div>
    
            @endforelse
    
        </div>
    
    </div>

    {{-- RECOMMENDATION --}}
    <div class="recommendation-section">

        <div class="section-header">

            <h2>Rekomendasi</h2>

            <i class='bx bx-slider-alt'></i>

        </div>

        @forelse ($rekomendasiLowongan as $job)

            {{-- CARD --}}
            <div class="job-card">

                <div class="job-top">

                    <div>

                        <h3>
                            {{ $job->posisi }}
                        </h3>

                        <p>
                            {{ optional($job->company)->name ?? '-' }}
                            @if(optional($job->company)->hq)
                                • {{ $job->company->hq }}
                            @endif
                        </p>

                    </div>

                    {{-- Tombol simpan --}}
                    <form method="POST"
                          action="{{ route('jobseeker.simpan.toggle', $job->id) }}{{ request('user_id') ? '?user_id='.request('user_id') : '' }}"
                          style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                            <i class='bx bx-bookmark'></i>
                        </button>
                    </form>

                </div>

                <div class="job-tags">

                    <span>{{ $job->jenis_bidang }}</span>

                    @if($job->gaji_minimum && $job->gaji_maksimum)
                        <span>
                            IDR {{ number_format($job->gaji_minimum / 1000000, 0) }}jt
                            - {{ number_format($job->gaji_maksimum / 1000000, 0) }}jt
                        </span>
                    @endif

                </div>

            </div>

        @empty

            <p style="color: #888; font-size: 0.9rem; padding: 1rem 0;">
                Tidak ada rekomendasi lowongan saat ini.
            </p>

        @endforelse

    </div>

@endsection