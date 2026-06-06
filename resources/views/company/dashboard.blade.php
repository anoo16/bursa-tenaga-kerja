@extends('layouts.recruiter')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="space-y-8">

    <!-- 1. BANNER PROFIL PERUSAHAAN -->
    <div class="bg-white border border-[#EBE8DF] rounded-3xl p-6 flex flex-col xl:flex-row items-start xl:items-center justify-between gap-6 shadow-sm overflow-hidden">
        <div class="flex items-center gap-4 xl:gap-6 flex-1 min-w-0">
            <!-- Generic Building SVG Logo -->
            <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100 shadow-inner flex-shrink-0">
                @if($company->logo_path)
                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Logo" class="w-full h-full object-contain rounded-xl">
                @else
                    <svg class="w-12 h-12 text-navy-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="10" width="20" height="12" rx="2" />
                        <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18" />
                        <line x1="10" y1="12" x2="10" y2="12.01" />
                        <line x1="14" y1="12" x2="14" y2="12.01" />
                        <line x1="10" y1="16" x2="10" y2="16.01" />
                        <line x1="14" y1="16" x2="14" y2="16.01" />
                    </svg>
                @endif
            </div>
            
            <div class="space-y-1.5 flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h2 id="dashboardCompanyName" class="text-3xl xl:text-4xl text-[#113255] truncate" style="font-family: 'Super Wonder', sans-serif;">{{ $company->name ?: 'Nama Perusahaan Anda' }}</h2>
                    <!-- VERIFIED BADGE -->
                    <span class="inline-flex items-center justify-center gap-[4px] bg-[#E6F2FE] text-[#143E72] text-[10px] font-bold px-[8px] py-[3px] rounded-full uppercase tracking-wider">
                        <!-- Check icon (Image Asset) -->
                        <img src="{{ asset('assets/verified.png') }}" class="w-[12px] h-[12px] object-contain" alt="Verified">
                        TERVERIFIKASI
                    </span>
                </div>
                <p class="text-sm font-medium text-slate-500 max-w-xl leading-relaxed">
                    {{ $company->description ?: 'Silakan edit profil untuk menambahkan deskripsi singkat perusahaan.' }}
                </p>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="flex items-center gap-3 w-full xl:w-auto flex-shrink-0">
            <a href="{{ route('company.profile.edit') }}" class="flex-1 xl:flex-none flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-[#143E72] font-extrabold text-sm py-3 px-5 rounded-2xl border-2 border-[#143E72]/15 hover:border-[#143E72] transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                <!-- Pencil icon -->
                <svg class="w-4 h-4 text-[#143E72]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4z" />
                </svg>
                Edit Profil
            </a>
            <a href="{{ route('company.profile') }}" class="flex-1 xl:flex-none flex items-center justify-center bg-[#143E72] hover:bg-[#0c2c54] text-white font-extrabold text-sm py-3.5 px-6 rounded-2xl transition-all duration-200 shadow-md shadow-blue-900/10 hover:-translate-y-0.5 active:translate-y-0 hover:shadow-lg">
                Lihat Profil
            </a>
        </div>
    </div>

    <!-- 2. STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- CARD 1: LOWONGAN AKTIF -->
        <div class="bg-white border-l-[6px] border-[#143E72] border-y border-r border-[#EBE8DF] rounded-2xl p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Lowongan Aktif</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-[#113255]">{{ $stats['lowongan_aktif']['value'] }}</span>
                <span class="text-xs font-bold text-[#143E72] bg-blue-50 px-2 py-0.5 rounded">{{ $stats['lowongan_aktif']['note'] }}</span>
            </div>
        </div>

        <!-- CARD 2: TOTAL PELAMAR -->
        <div class="bg-white border border-[#EBE8DF] rounded-2xl p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Total Pelamar</p>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-extrabold text-[#113255]">{{ $stats['total_pelamar']['value'] }}</span>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $stats['total_pelamar']['note'] }}</span>
            </div>
        </div>

        <!-- CARD 3: PERLU DITINJAU (BLUE BACKGROUND) -->
        <div class="bg-[#CFEDFC] border border-[#BCE1F5] rounded-2xl p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <p class="text-[11px] font-bold text-[#1F5472] uppercase tracking-wider mb-2">Perlu Ditinjau</p>
            <div class="flex items-baseline justify-between">
                <span class="text-4xl font-extrabold text-[#113255]">{{ $stats['perlu_ditinjau']['value'] }}</span>
                <span class="text-[10px] font-extrabold bg-[#113255] text-white px-2.5 py-1 rounded-md uppercase tracking-wider">{{ $stats['perlu_ditinjau']['note'] }}</span>
            </div>
        </div>

        <!-- CARD 4: DITERIMA BULAN INI -->
        <div class="bg-white border border-[#EBE8DF] rounded-2xl p-5 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Diterima Bulan Ini</p>
                <span class="text-4xl font-extrabold text-[#113255]">{{ $stats['diterima_bulan_ini']['value'] }}</span>
            </div>
            
            <!-- OVERLAPPING AVATARS STACK -->
            <div class="flex items-center -space-x-2.5 mt-2">
                @if(isset($stats['diterima_bulan_ini']['avatars']) && count($stats['diterima_bulan_ini']['avatars']) > 0)
                    @foreach($stats['diterima_bulan_ini']['avatars'] as $avatar)
                        <div class="w-6 h-6 rounded-full {{ $avatar['color'] }} border-2 border-white flex items-center justify-center text-[9px] font-bold">{{ $avatar['initial'] }}</div>
                    @endforeach
                    
                    @if($stats['diterima_bulan_ini']['value'] > 2)
                        <div class="w-6 h-6 rounded-full bg-slate-900 border-2 border-white flex items-center justify-center text-[9px] font-bold text-white">+{{ $stats['diterima_bulan_ini']['value'] - 2 }}</div>
                    @endif
                @else
                    <!-- Teks placeholder jika belum ada pelamar -->
                    <span class="text-xs text-slate-400 font-medium">Belum ada</span>
                @endif
            </div>
        </div>

    </div>

    <!-- 3. MAIN TABLES & LISTS GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- LEFT COLUMN: TABEL LOWONGAN AKTIF (col-span-2) -->
        <div class="lg:col-span-2 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-extrabold text-[#113255] tracking-tight">Tabel Lowongan Aktif</h3>
                <a href="{{ route('company.jobs') }}" class="text-sm font-bold text-[#143E72] hover:underline">Lihat Semua</a>
            </div>

            <div class="bg-white border border-[#EBE8DF] rounded-3xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                <table class="w-full border-collapse min-w-[500px]">
                    <thead>
                        <tr class="text-white">
                            <th class="px-4 py-4 lg:px-6 lg:py-4.5 text-left text-sm font-extrabold text-white bg-[#143E72] uppercase tracking-wider w-1/2 rounded-tl-3xl">Posisi</th>
                            <th class="px-4 py-4 lg:px-6 lg:py-4.5 text-center text-sm font-extrabold text-white bg-[#143E72] uppercase tracking-wider whitespace-nowrap w-1/4">Pelamar</th>
                            <th class="px-4 py-4 lg:px-6 lg:py-4.5 text-center text-sm font-extrabold text-white bg-[#143E72] uppercase tracking-wider whitespace-nowrap rounded-tr-3xl w-1/4">Tenggat Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F3EFE0]">
                        @forelse($activeJobs as $job)
                        <tr class="hover:bg-slate-50/40 transition-colors">
                            <td class="px-4 py-4 lg:px-6 lg:py-5.5 whitespace-normal w-1/2">
                                <p class="text-sm font-extrabold text-[#113255] leading-tight mb-1">{{ $job['posisi'] }}</p>
                                <span class="text-xs font-semibold text-slate-400">{{ $job['team'] }} • {{ $job['lokasi'] }}</span>
                            </td>
                            
                            <td class="px-4 py-4 lg:px-6 lg:py-5.5 whitespace-nowrap text-center w-1/4">
                                <a href="{{ route('company.applicants') }}" 
                                   class="text-sm font-semibold text-slate-500 hover:text-[#143E72] hover:underline transition-colors"
                                   title="Lihat Pelamar">
                                    {{ $job['pelamar_count'] }} Pelamar
                                </a>
                            </td>

                            <td class="px-4 py-4 lg:px-6 lg:py-5.5 whitespace-nowrap text-center w-1/4">
                                <span class="text-sm font-semibold text-slate-500">{{ $job['deadline'] }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center p-8 text-slate-400">
                                Belum ada lowongan aktif.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                
                <!-- Load More Button -->
                <div class="px-6 py-4.5 border-t border-[#F3EFE0] text-center bg-slate-50/20">
                    <a href="{{ route('company.jobs') }}" class="inline-block text-sm font-extrabold text-[#113255] hover:text-[#143E72] transition-colors">
                        Muat Lebih Banyak
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: PELAMAR TERBARU -->
        <div class="space-y-4">
            <div class="flex items-center gap-2.5">
                <h3 class="text-xl xl:text-2xl font-extrabold text-[#113255] tracking-tight whitespace-nowrap">Pelamar Terbaru</h3>
                <!-- NEW BADGE -->
                <span class="bg-[#FEE2E2] text-[#EF4444] text-[9px] font-extrabold px-2 py-0.5 rounded-md uppercase tracking-wider">New</span>
            </div>

            <!-- List of applicants -->
            <div class="flex flex-col gap-[16px]">
                @foreach($recentApplicants as $applicant)
                <div class="w-full max-w-[331px] h-[126px] flex items-start justify-between p-[20px] bg-white border border-[#EBE8DF] rounded-[16px] shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    
                    <!-- Sisi Kiri (Foto & Teks) -->
                    <div class="flex items-start gap-[12px] flex-1 min-w-0">
                        <div class="w-[44px] h-[44px] rounded-[10px] {{ $applicant['avatar_bg'] }} flex items-center justify-center font-extrabold text-sm tracking-tight border border-white shadow-inner flex-shrink-0 object-cover">
                            @php
                                $words = explode(' ', $applicant['nama']);
                                $initials = isset($words[1]) ? substr($words[0], 0, 1) . substr($words[1], 0, 1) : substr($words[0], 0, 2);
                            @endphp
                            {{ strtoupper($initials) }}
                        </div>
                        
                        <div class="flex flex-col min-w-0">
                            <h4 class="text-sm font-bold text-[#113255] whitespace-normal break-words mb-[4px]">{{ $applicant['nama'] }}</h4>
                            <p class="text-[11px] text-slate-400 font-medium">{{ $applicant['posisi'] }}</p>
                            <span class="text-[11px] text-slate-400 font-medium mt-[16px] ml-[4px]">{{ $applicant['waktu'] }}</span>
                        </div>
                    </div>

                    <!-- Sisi Kanan (Badge & Tombol) -->
                    <div class="flex flex-col items-end justify-between h-full flex-shrink-0 ml-[16px]">
                        @if($applicant['badge'] === 'BARU')
                            <span class="flex items-center justify-center h-[18px] px-[6px] py-[2px] rounded-[4px] bg-blue-900 text-white text-[10px] font-bold uppercase tracking-wider">BARU</span>
                        @else
                            <span class="flex items-center justify-center h-[18px] px-[6px] py-[2px] rounded-[4px] bg-slate-100 text-slate-500 border border-slate-200 text-[10px] font-bold uppercase tracking-wider">REVIEW</span>
                        @endif
                        
                        <button class="bg-[#143E72] hover:bg-[#0c2c54] text-white text-[11px] font-bold w-[77px] h-[28px] flex items-center justify-center text-center mt-auto rounded-[8px] transition-all duration-200 shadow-sm hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md">
                            Review
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
</div>
@endsection

@section('scripts')
<script>
    // Immediate pre-fill if database company name is empty
    (function() {
        const companyNamePHP = "{{ $company->name }}";
        if (!companyNamePHP) {
            const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user'));
            if (user && user.company_name) {
                const el = document.getElementById('dashboardCompanyName');
                if (el) el.textContent = user.company_name;
            }
        }
    })();

    // Dynamic sync from API when loaded
    window.syncCompanyName = function(name) {
        const companyNamePHP = "{{ $company->name }}";
        if (!companyNamePHP && name) {
            const el = document.getElementById('dashboardCompanyName');
            if (el) el.textContent = name;
        }
    };
</script>
@endsection