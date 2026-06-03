@extends('layouts.recruiter')

@section('title', 'Profil Perusahaan' . ($company['name'] ? ' - ' . $company['name'] : ''))

@section('content')
<div class="space-y-6 lg:space-y-8">

    <div class="relative w-full rounded-3xl overflow-hidden shadow-sm flex-shrink-0 min-w-0 min-h-[160px]">
        
        @if($company->banner_path)
            <img src="{{ asset('storage/' . $company->banner_path) }}" class="absolute inset-0 w-full h-full object-cover" alt="Banner Perusahaan">
        @else
            <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-navy-500 to-navy-700"></div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-r from-[#0C1A2B]/95 via-[#0C1A2B]/60 to-transparent"></div>
        
        <div class="absolute inset-0 p-4 md:p-6 flex items-center justify-between gap-6">
            
            <!-- Logo & Text Container -->
            <div class="flex items-center gap-5 flex-1 min-w-0">
                
                <!-- Kotak Logo Putih -->
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white rounded-2xl flex items-center justify-center p-2.5 shadow-lg border border-white/20 flex-shrink-0">
                    @if($company->logo_path)
                        <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
                    @else
                        <svg class="w-12 h-12 text-navy-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="10" width="20" height="12" rx="2" />
                            <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18" />
                            <line x1="10" y1="12" x2="10" y2="12.01" />
                            <line x1="14" y1="12" x2="14" y2="12.01" />
                        </svg>
                    @endif
                </div>
                
                <!-- Teks Judul & Deskripsi -->
                <div class="space-y-1 flex-1 min-w-0">
                    <h2 id="profileCompanyName" class="text-3xl sm:text-4xl text-white drop-shadow-md truncate" style="font-family: 'Super Wonder', sans-serif;">{{ $company->name ?: 'Nama Perusahaan Anda' }}</h2>
                    <p class="text-sm font-semibold text-slate-200 drop-shadow truncate md:whitespace-normal line-clamp-2">{{ $company->description ?: 'Belum ada deskripsi singkat perusahaan.' }}</p>
                </div>
                
            </div>

            <!-- Buttons Container -->
            <div class="flex justify-end gap-3 flex-wrap flex-shrink-0">
                <a href="#" class="flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-extrabold text-xs py-2.5 px-4 rounded-xl border border-white/30 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="hidden md:inline">Preview as Candidate</span>
                    <span class="md:hidden">Preview</span>
                </a>
                
                <a href="{{ route('company.profile.edit') }}" class="flex items-center gap-2 bg-[#143E72] hover:bg-[#0c2c54] text-white font-extrabold text-xs py-2.5 px-5 rounded-xl transition-all shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4z" />
                    </svg>
                    <span class="hidden md:inline">Edit Profile</span>
                    <span class="md:hidden">Edit</span>
                </a>
            </div>

        </div>
    </div>
    
    <!-- MAIN CONTENT GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- LEFT COLUMN (About, Mission, Culture) -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            
            <!-- ABOUT THE COMPANY -->
            <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm flex flex-col h-fit">
                <h3 class="text-[22px] font-extrabold text-[#113255] mb-5 tracking-tight">Tentang Perusahaan</h3>
                <div class="text-slate-600 text-[15px] leading-relaxed">
                    <p>{{ $company->about ?: 'Belum ada penjelasan detail mengenai perusahaan.' }}</p>
                </div>
            </div>

            <!-- MISSION & CULTURE -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- MISSION -->
                <div class="bg-kuning-renyah rounded-[24px] p-6 sm:p-8 shadow-sm border border-[#F3EFE0] flex flex-col h-fit">
                    <svg class="w-8 h-8 text-[#113255] mb-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.5 3.5C18.5 2 14.5 2 10.5 6L8.5 8L4.5 8C3.7 8 3 8.7 3 9.5C3 10.1 3.4 10.6 3.9 10.9L8.5 13.5L7 15L3 14L2 15L5.5 18.5L9 22L10 21L9 17L10.5 15.5L13.1 20.1C13.4 20.6 13.9 21 14.5 21C15.3 21 16 20.3 16 19.5L16 15.5L18 13.5C22 9.5 22 5.5 20.5 3.5ZM16.5 8.5C15.4 8.5 14.5 7.6 14.5 6.5C14.5 5.4 15.4 4.5 16.5 4.5C17.6 4.5 18.5 5.4 18.5 6.5C18.5 7.6 17.6 8.5 16.5 8.5Z" />
                    </svg>
                    <h3 class="text-[18px] font-extrabold text-[#113255] mb-3 tracking-tight">Misi Kami</h3>
                    <div class="text-slate-600 text-[14px] leading-relaxed">
                        <p>{{ $company->mission ?: 'Belum ada misi perusahaan.' }}</p>
                    </div>
                </div>

                <!-- CULTURE -->
                <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm border border-[#F3EFE0] flex flex-col h-fit">
                    <svg class="w-8 h-8 text-[#113255] mb-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 15L17.5 18.5L14 20L17.5 21.5L19 25L20.5 21.5L24 20L20.5 18.5L19 15ZM10 1L7 8L0 11L7 14L10 21L13 14L20 11L13 8L10 1ZM10 15.1L8.7 12.3L5.9 11L8.7 9.7L10 6.9L11.3 9.7L14.1 11L11.3 12.3L10 15.1Z" />
                    </svg>
                    <h3 class="text-[18px] font-extrabold text-[#113255] mb-3 tracking-tight">Kultur Kami</h3>
                    <div class="text-slate-600 text-[14px] leading-relaxed">
                        <p>{{ $company->culture ?: 'Belum ada budaya perusahaan.' }}</p>
                    </div>
                </div>
            </div>

            <!-- COMPANY PHOTOS PLACEHOLDER -->
            <div class="flex flex-col gap-4 mt-2">
                <h3 class="text-[22px] font-extrabold text-[#113255] tracking-tight">Gallery Di <span id="galleryCompanyName">{{ $company->name ?: 'Perusahaan' }}</span></h3>
                
                @if($company->galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($company->galleries as $gallery)
                    <div class="w-full h-40 rounded-[24px] overflow-hidden border border-slate-200 shadow-sm">
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Galeri" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @else
                <!-- Upload Placeholder Box -->
                <div class="w-full h-[256px] rounded-[24px] border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-slate-100 hover:border-[#143E72] hover:text-[#143E72] transition-colors cursor-pointer group">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="w-8 h-8 opacity-70 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-semibold">Upload Gambar Perusahaan anda disini</span>
                    </div>
                </div>
                @endif
            </div>

        </div>

        <!-- RIGHT COLUMN (Detail, Perks) -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            
            <!-- COMPANY DETAILS -->
            <div class="bg-white rounded-[24px] p-6 sm:p-8 shadow-sm flex flex-col h-fit">
            <h3 class="text-[18px] font-extrabold text-[#113255] mb-6 tracking-tight">Detail Perusahaan</h3>
            
            <div class="space-y-6">
                <!-- Size -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F2FE] flex items-center justify-center flex-shrink-0 text-[#143E72]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Skala Karyawan</p>
                        <p class="text-[14px] font-extrabold text-slate-800">{{ $company->size ?: 'Belum diisi' }}</p>
                    </div>
                </div>

                <!-- Industry -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F2FE] flex items-center justify-center flex-shrink-0 text-[#143E72]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Industri</p>
                        <p class="text-[14px] font-extrabold text-slate-800 leading-snug">
                            @if($company->industry)
                                {{ [
                                    'tech' => 'Teknologi & Informasi',
                                    'ecommerce' => 'E-Commerce',
                                    'finance' => 'Fintech & Keuangan',
                                    'logistics' => 'Logistik & Transportasi'
                                ][$company->industry] ?? $company->industry }}
                            @else
                                Belum diisi
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Headquarters -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F2FE] flex items-center justify-center flex-shrink-0 text-[#143E72]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kantor Pusat</p>
                        <p class="text-[14px] font-extrabold text-slate-800">{{ $company->hq ?: 'Belum diisi' }}</p>
                    </div>
                </div>

                <!-- Address -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F2FE] flex items-center justify-center flex-shrink-0 text-[#143E72]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Alamat</p>
                        <p class="text-[14px] font-extrabold text-slate-800 leading-snug">{{ $company->address ?: 'Belum diisi' }}</p>
                    </div>
                </div>

                <!-- Website -->
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-[#E6F2FE] flex items-center justify-center flex-shrink-0 text-[#143E72]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Situs Web</p>
                        @if($company->website)
                            <a href="{{ str_starts_with($company->website, 'http') ? $company->website : 'https://'.$company->website }}" target="_blank" class="text-[14px] font-extrabold text-[#387CD9] hover:text-[#143E72] transition-colors">{{ $company->website }}</a>
                        @else
                            <span class="text-[14px] font-extrabold text-slate-800">Belum diisi</span>
                        @endif
                    </div>
                </div>
            </div>

            </div>

            <!-- HIRING PERKS -->
            <div class="bg-kuning-renyah rounded-[24px] p-6 sm:p-8 shadow-sm border border-[#F3EFE0] flex flex-col flex-1">
                <div class="flex items-center gap-3 mb-6">
                    <svg class="w-6 h-6 text-[#143E72]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <h3 class="text-[18px] font-extrabold text-[#113255] tracking-tight">Hiring Perks</h3>
                </div>
                
                <ul class="space-y-4">
                    @forelse($company->perks as $perk)
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 bg-white rounded-full p-1 shadow-sm border border-slate-100 flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="text-[14px] font-bold text-slate-700 leading-snug">{{ $perk->perk_name }}</span>
                    </li>
                    @empty
                    <li class="text-xs text-slate-400 font-semibold">Belum ada perks/benefit yang ditambahkan.</li>
                    @endforelse
                </ul>
            </div>

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
                const profileEl = document.getElementById('profileCompanyName');
                if (profileEl) profileEl.textContent = user.company_name;
                const galleryEl = document.getElementById('galleryCompanyName');
                if (galleryEl) galleryEl.textContent = user.company_name;
            }
        }
    })();

    // Dynamic sync from API when loaded
    window.syncCompanyName = function(name) {
        const companyNamePHP = "{{ $company->name }}";
        if (!companyNamePHP && name) {
            const profileEl = document.getElementById('profileCompanyName');
            if (profileEl) profileEl.textContent = name;
            const galleryEl = document.getElementById('galleryCompanyName');
            if (galleryEl) galleryEl.textContent = name;
        }
    };
</script>
@endsection