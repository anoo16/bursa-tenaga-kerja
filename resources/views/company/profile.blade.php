@extends('layouts.recruiter')

@section('title', 'Profil Perusahaan' . ($company['name'] ? ' - ' . $company['name'] : ''))

@section('content')

{{-- HERO BANNER with background image --}}
<div class="relative w-full rounded-2xl overflow-hidden mb-8 h-56 shadow-md flex-shrink-0 min-w-0">
    
    {{-- Background image --}}
    @if($company->banner_path)
        <img src="{{ asset('storage/' . $company->banner_path) }}" class="absolute inset-0 w-full h-full object-cover" alt="Banner Perusahaan">
    @else
        <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-navy-500 to-navy-700"></div>
    @endif
    
    {{-- Dark overlay for readability --}}
    <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-black/30 to-transparent"></div>

    {{-- Top-right action buttons --}}
    <div class="absolute top-4 right-4 flex items-center gap-2 sm:gap-3 flex-wrap justify-end">
        <a href="#" class="flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white font-bold text-xs sm:text-sm px-3 sm:px-4 py-2 rounded-xl hover:bg-white/30 transition border border-white/30 text-center">
            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <span class="hidden sm:inline">Preview as Candidate</span>
            <span class="sm:hidden">Preview</span>
        </a>
        <a href="{{ route('company.profile.edit') }}" class="flex items-center gap-2 bg-navy-500 text-white font-bold text-xs sm:text-sm px-3 sm:px-4 py-2 rounded-xl hover:bg-navy-600 transition shadow-md text-center">
            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            <span class="hidden sm:inline">Edit Profile</span>
            <span class="sm:hidden">Edit</span>
        </a>
    </div>

    {{-- Company Logo + Name overlay on bottom-left --}}
    <div class="absolute bottom-5 left-4 sm:left-5 flex items-center gap-4 max-w-[85%] sm:max-w-full">
        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-white rounded-2xl shadow-xl flex items-center justify-center overflow-hidden border-2 border-white/80 p-1.5 flex-shrink-0">
            @if($company->logo_path)
                <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Logo" class="w-full h-full object-contain">
            @else
                <svg class="w-10 h-10 text-navy-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="10" width="20" height="12" rx="2" />
                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18" />
                    <line x1="10" y1="12" x2="10" y2="12.01" />
                    <line x1="14" y1="12" x2="14" y2="12.01" />
                </svg>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <h1 id="profileCompanyName" class="text-2xl sm:text-3xl font-extrabold text-white drop-shadow-sm truncate">{{ $company->name ?: 'Nama Perusahaan Anda' }}</h1>
            <p class="text-white/90 text-xs sm:text-sm font-medium truncate sm:whitespace-normal sm:line-clamp-2 mt-1">{{ $company->description ?: 'Belum ada deskripsi singkat perusahaan.' }}</p>
        </div>
    </div>
</div>

{{-- MAIN CONTENT GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT COLUMN (2/3 on LG) --}}
    <div class="lg:col-span-2 space-y-5 flex flex-col min-w-0">

        {{-- About the Company --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-cream-300 break-words h-fit">
            <h2 class="text-lg font-extrabold text-navy-500 mb-4">Tentang Perusahaan</h2>
            <div class="text-sm text-gray-600 leading-relaxed space-y-3">
                <p>{{ $company->about ?: 'Belum ada penjelasan detail mengenai perusahaan.' }}</p>
            </div>
        </div>

        {{-- Mission & Culture --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Mission --}}
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-cream-300 break-words h-fit">
                <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center mb-3 text-navy-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C8 2 4.5 5.5 4 9l-2 5h4v4h8v-4h4l-2-5c-.5-3.5-4-7-4-7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 21v-1m6 1v-1M12 2v3"/></svg>
                </div>
                <h3 class="font-extrabold text-navy-500 mb-2">Misi Kami</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $company->mission ?: 'Belum ada misi perusahaan.' }}</p>
            </div>
            
            {{-- Culture --}}
            <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-cream-300 break-words h-fit">
                <div class="w-10 h-10 bg-navy-50 rounded-xl flex items-center justify-center mb-3 text-navy-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="font-extrabold text-navy-500 mb-2">Kultur Kami</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $company->culture ?: 'Belum ada budaya perusahaan.' }}</p>
            </div>
        </div>

        {{-- Life at Company (Gallery) --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-cream-300 break-words h-fit">
            <h2 class="text-lg font-extrabold text-navy-500 mb-4">Galeri <span id="galleryCompanyName">{{ $company->name ?: 'Perusahaan' }}</span></h2>
            
            @if($company->galleries->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($company->galleries as $gallery)
                <div class="rounded-xl overflow-hidden h-32 sm:h-36 bg-cream-100 border border-cream-200">
                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Galeri" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
                @endforeach
            </div>
            @else
            <div class="w-full h-36 rounded-xl border-2 border-dashed border-cream-300 bg-cream-50 flex items-center justify-center text-gray-400">
                <span class="text-sm font-medium">Belum ada foto galeri</span>
            </div>
            @endif
        </div>
    </div>

    {{-- RIGHT COLUMN (1/3 on LG) --}}
    <div class="lg:col-span-1 space-y-5 flex flex-col min-w-0">

        {{-- Company Details --}}
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-cream-300 break-words h-fit">
            <h3 class="font-extrabold text-navy-500 mb-5">Detail Perusahaan</h3>
            <div class="space-y-4">
                
                {{-- Size --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cream-100 flex items-center justify-center flex-shrink-0 text-navy-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Skala Karyawan</p>
                        <p class="font-bold text-navy-500 text-sm mt-0.5 truncate">{{ $company->size ?: 'Belum diisi' }}</p>
                    </div>
                </div>
                
                {{-- Industry --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cream-100 flex items-center justify-center flex-shrink-0 text-navy-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Industri</p>
                        <p class="font-bold text-navy-500 text-sm mt-0.5 break-words">
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
                
                {{-- HQ --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cream-100 flex items-center justify-center flex-shrink-0 text-navy-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Kantor Pusat</p>
                        <p class="font-bold text-navy-500 text-sm mt-0.5 break-words">{{ $company->hq ?: 'Belum diisi' }}</p>
                    </div>
                </div>
                
                {{-- Website --}}
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-cream-100 flex items-center justify-center flex-shrink-0 text-navy-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Website</p>
                        @if($company->website)
                            <a href="{{ str_starts_with($company->website, 'http') ? $company->website : 'https://'.$company->website }}" target="_blank" class="font-bold text-navy-500 hover:text-navy-700 text-sm mt-0.5 hover:underline truncate block w-full">{{ $company->website }}</a>
                        @else
                            <p class="font-bold text-navy-500 text-sm mt-0.5">Belum diisi</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Map Dynamic Integration --}}
        <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-cream-300 flex flex-col h-fit">
            <div class="h-40 relative flex items-center justify-center flex-shrink-0 bg-slate-100">
                @if($company->address)
                    <!-- Google Maps Iframe (Dinamis berdasarkan alamat) -->
                    <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        scrolling="no" 
                        marginheight="0" 
                        marginwidth="0" 
                        src="https://maps.google.com/maps?q={{ urlencode($company->address) }}&t=&z=14&ie=UTF8&iwloc=&output=embed"
                        class="absolute inset-0 z-10"
                    ></iframe>
                @else
                    <!-- Fallback SVG jika alamat belum diisi -->
                    <svg class="w-8 h-8 text-red-500 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    <div class="absolute inset-0 opacity-10">
                        <svg width="100%" height="100%" viewBox="0 0 200 150" preserveAspectRatio="none"><path d="M0 75 Q 50 25 100 75 Q 150 125 200 75" fill="none" stroke="#1B3A5C" stroke-width="1"/><path d="M0 50 Q 50 100 100 50 Q 150 0 200 50" fill="none" stroke="#1B3A5C" stroke-width="1"/><path d="M100 0 L100 150" stroke="#1B3A5C" stroke-width="0.5"/><path d="M0 75 L200 75" stroke="#1B3A5C" stroke-width="0.5"/></svg>
                    </div>
                @endif
            </div>
            <div class="px-4 py-3 text-center break-words bg-white z-20 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                <p class="text-xs text-gray-600 font-bold leading-tight">{{ $company->address ?: 'Alamat belum diisi' }}</p>
            </div>
        </div>

        {{-- Hiring Perks --}}
        <div class="bg-navy-500 rounded-2xl p-5 sm:p-6 shadow-md h-fit">
            <h3 class="font-extrabold text-white mb-4">Keuntungan Bekerja</h3>
            <div class="space-y-3">
                @forelse($company->perks as $perk)
                <div class="flex items-start gap-2.5 text-sm text-white/90">
                    <svg class="w-4 h-4 mt-0.5 text-teal-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="leading-snug break-words">{{ $perk->perk_name }}</span>
                </div>
                @empty
                <div class="text-sm text-white/70 italic">Belum ada perks/benefit yang ditambahkan.</div>
                @endforelse
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