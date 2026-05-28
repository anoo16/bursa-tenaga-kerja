@extends('layouts.jobseeker')

@section('content')

@vite([
    'resources/css/dashboard.css',
    'resources/js/dashbordjobseeker.js'
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

            <a href="#">Lihat Semua</a>

        </div>

        <div class="application-table">

            <div class="table-head">

                <span>POSISI</span>
                <span>PERUSAHAAN</span>
                <span>STATUS</span>
                <span>TANGGAL</span>

            </div>

            {{-- ROW --}}
            <div class="table-row">

                <h4>Senior UI Designer</h4>

                <p>Tokopedia</p>

                <span class="status review">
                    REVIEW
                </span>

                <small>12 Mei 2026</small>

            </div>

            {{-- ROW --}}
            <div class="table-row">

                <h4>Product Manager</h4>

                <p>Traveloka</p>

                <span class="status waiting">
                    MENUNGGU
                </span>

                <small>08 Feb 2026</small>

            </div>

            {{-- ROW --}}
            <div class="table-row">

                <h4>UX Researcher</h4>

                <p>Gojek</p>

                <span class="status accepted">
                    DITERIMA
                </span>

                <small>12 Jan 2026</small>

            </div>

            {{-- ROW --}}
            <div class="table-row">

                <h4>Web Developer</h4>

                <p>Shopee</p>

                <span class="status rejected">
                    DITOLAK
                </span>

                <small>22 Nov 2025</small>

            </div>

        </div>

    </div>

    {{-- RECOMMENDATION --}}
    <div class="recommendation-section">

        <div class="section-header">

            <h2>Rekomendasi</h2>

            <i class='bx bx-slider-alt'></i>

        </div>

        {{-- CARD --}}
        <div class="job-card">

            <div class="job-top">

                <div>

                    <h3>
                        Lead Experience Designer
                    </h3>

                    <p>
                        Metaverse Studio • Jakarta
                    </p>

                </div>

                <i class='bx bx-bookmark'></i>

            </div>

            <div class="job-tags">

                <span>Remote</span>

                <span>IDR 25jt - 35jt</span>

            </div>

        </div>

        {{-- CARD --}}
        <div class="job-card">

            <div class="job-top">

                <div>

                    <h3>
                        Senior Interaction Architect
                    </h3>

                    <p>
                        Fintech Nexus • BSD City
                    </p>

                </div>

                <i class='bx bx-bookmark'></i>

            </div>

            <div class="job-tags">

                <span>Full-time</span>

                <span>Hybrid</span>

            </div>

        </div>

         {{-- CARD --}}
        <div class="job-card">

            <div class="job-top">

                <div>

                    <h3>
                        Creative Design Lead
                    </h3>

                    <p>
                        Pixel Perfect • Bandung
                    </p>

                </div>

                <i class='bx bx-bookmark'></i>

            </div>

            <div class="job-tags">

                <span>Permanent</span>

            </div>

        </div>

    </div>

</div>

@endsection