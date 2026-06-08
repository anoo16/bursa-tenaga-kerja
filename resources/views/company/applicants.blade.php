@extends('layouts.recruiter')

@section('title', 'Pelamar Masuk')

@vite(['resources/css/filter-modal.css', 'resources/js/filter-modal.js'])

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#143E72]">Pelamar Masuk</h1>
            <p class="text-gray-500">Kelola lamaran pekerjaan yang masuk dari calon kandidat</p>
        </div>
        <a href="{{ route('company.dashboard') }}"
           class="flex items-center gap-2 bg-[#143E72] hover:bg-[#0f2d54]
                  text-white px-5 py-3 rounded-xl font-semibold text-sm
                  transition-all duration-200 shadow-md">
            Kembali ke Dasbor
        </a>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label' => 'Pelamar Baru',    'value' => $newCount,       'color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['label' => 'Interview',        'value' => $interviewCount, 'color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['label' => 'Diterima',         'value' => $acceptedCount,  'color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['label' => 'Ditolak',          'value' => $rejectedCount,  'color' => 'bg-red-50 text-red-700 border-red-200'],
        ] as $stat)
        <div class="bg-white rounded-2xl border border-[#EBE8DF] p-5 shadow-sm">
            <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">{{ $stat['label'] }}</div>
            <div class="text-3xl font-black text-[#143E72]">{{ $stat['value'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- FORM FILTER & SEARCH --}}
    <form action="{{ route('company.applicants') }}" method="GET" id="filterForm">

        <div class="flex flex-col md:flex-row gap-4 mb-6">

            {{-- Search --}}
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari pelamar atau posisi lowongan..."
                       class="w-full pl-11 pr-4 py-3 bg-white border border-[#EBE8DF] rounded-2xl
                              focus:outline-none focus:ring-2 focus:ring-[#143E72] shadow-sm text-sm">
            </div>

            {{-- Tombol Advanced Filter --}}
            <button type="button" id="openFilterBtn"
                    class="flex items-center justify-center gap-2 bg-white border border-[#EBE8DF]
                           text-[#143E72] hover:bg-gray-50 px-5 py-3 rounded-2xl font-semibold
                           text-sm shadow-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0
                             110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                Advanced Filters
                @if(request()->filled('kategori') || request()->filled('jenis_bidang') || request()->filled('status') || request()->filled('gaji_min') || request()->filled('gaji_max'))
                    <span class="w-2 h-2 rounded-full bg-red-500 inline-block"></span>
                @endif
            </button>

            <button type="submit"
                    class="bg-[#143E72] hover:bg-[#0f2d54] text-white px-6 py-3
                           rounded-2xl font-semibold text-sm shadow-sm">
                Cari
            </button>
        </div>

        {{-- ══ MODAL ADVANCED FILTER ══ --}}
        <div id="filterModal"
             class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="bg-white rounded-3xl max-w-xl w-full max-h-[90vh] overflow-y-auto
                        shadow-2xl p-6 relative z-10 animate-fade-in-up">

                {{-- Header Modal --}}
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                    <h2 class="text-xl font-bold text-[#143E72]">Filter Lanjutan</h2>
                    <button type="button" id="closeFilterBtn"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-5">

                    {{-- 1. Bidang Industri (dari kolom kategori milikmu) --}}
                    <div>
                        <span class="block text-xs font-bold text-gray-400 tracking-wider
                                     uppercase mb-2">Bidang Industri</span>
                        <div class="relative">
                            <select name="kategori"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800
                                           text-sm font-semibold rounded-xl p-3.5 pr-10 appearance-none
                                           focus:ring-2 focus:ring-[#143E72] focus:border-transparent">
                                <option value="">Semua Industri</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k }}"
                                        {{ request('kategori') == $k ? 'selected' : '' }}>
                                        {{ $k }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0
                                        flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Jenis Bidang (dari kolom jenis_bidang milikmu) --}}
                    <div>
                        <span class="block text-xs font-bold text-gray-400 tracking-wider
                                     uppercase mb-2">Jenis Bidang</span>
                        <div class="relative">
                            <select name="jenis_bidang"
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-800
                                           text-sm font-semibold rounded-xl p-3.5 pr-10 appearance-none
                                           focus:ring-2 focus:ring-[#143E72] focus:border-transparent">
                                <option value="">Semua Jenis</option>
                                @foreach($jenisBidangs as $j)
                                    <option value="{{ $j }}"
                                        {{ request('jenis_bidang') == $j ? 'selected' : '' }}>
                                        {{ $j }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0
                                        flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Status Lamaran --}}
                    <div>
                        <span class="block text-xs font-bold text-gray-400 tracking-wider
                                     uppercase mb-2">Status Lamaran</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['BARU' => 'Baru', 'REVIEW' => 'Review',
                                      'INTERVIEW' => 'Interview',
                                      'DITERIMA' => 'Diterima', 'DITOLAK' => 'Ditolak'] as $val => $label)
                                <label class="cursor-pointer select-none">
                                    <input type="radio" name="status" value="{{ $val }}"
                                           {{ request('status') == $val ? 'checked' : '' }}
                                           class="sr-only peer">
                                    <span class="px-4 py-2 bg-white border border-gray-200 text-sm
                                                 font-semibold text-gray-600 rounded-full inline-block
                                                 peer-checked:bg-[#143E72] peer-checked:border-[#143E72]
                                                 peer-checked:text-white transition-all">
                                        {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- 4. Rentang Gaji --}}
                    <div>
                        <span class="block text-xs font-bold text-gray-400 tracking-wider
                                     uppercase mb-2">Rentang Gaji (Rp)</span>
                        <div class="flex items-center gap-3">
                            <input type="number" name="gaji_min"
                                   value="{{ request('gaji_min') }}"
                                   placeholder="Min (contoh: 5000000)"
                                   class="flex-1 bg-gray-50 border border-gray-200 text-sm
                                          rounded-xl p-3 focus:ring-2 focus:ring-[#143E72]
                                          focus:border-transparent outline-none">
                            <span class="text-gray-400 font-bold">—</span>
                            <input type="number" name="gaji_max"
                                   value="{{ request('gaji_max') }}"
                                   placeholder="Maks (contoh: 15000000)"
                                   class="flex-1 bg-gray-50 border border-gray-200 text-sm
                                          rounded-xl p-3 focus:ring-2 focus:ring-[#143E72]
                                          focus:border-transparent outline-none">
                        </div>
                    </div>

                </div>

                {{-- Footer Modal --}}
                <div class="flex justify-between items-center border-t border-gray-100 pt-4 mt-6">
                    <a href="{{ route('company.applicants') }}"
                       class="text-sm font-bold text-red-500 hover:underline">
                        Atur Ulang
                    </a>
                    <div class="flex gap-3">
                        <button type="button" id="cancelFilterBtn"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5
                                       rounded-xl text-sm font-bold transition-all">
                            Batal
                        </button>
                        <button type="submit"
                                class="bg-[#143E72] hover:bg-[#0f2d54] text-white px-6 py-2.5
                                       rounded-xl text-sm font-bold shadow-md transition-all">
                            Terapkan Filter
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </form>

    {{-- DAFTAR PELAMAR --}}
    <div class="bg-white rounded-3xl border border-[#EBE8DF] shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <span class="text-sm font-semibold text-gray-600">
                Total: {{ $applications->total() }} pelamar
            </span>
            @if(request()->hasAny(['search','kategori','jenis_bidang','status','gaji_min','gaji_max']))
                <a href="{{ route('company.applicants') }}"
                   class="text-xs font-bold text-red-500 hover:underline">
                    Reset Filter
                </a>
            @endif
        </div>

        @if($applications->isEmpty())
            <div class="p-12 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor"
                     stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01
                             M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-base font-medium">Tidak ada pelamar yang sesuai filter.</p>
                <a href="{{ route('company.applicants') }}"
                   class="text-sm text-[#143E72] hover:underline mt-1 inline-block">
                    Reset Pencarian
                </a>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($applications as $app)
                <div class="p-6 hover:bg-slate-50/80 transition-all flex items-start
                            justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 text-[#143E72] rounded-full flex
                                    items-center justify-center font-bold text-lg flex-shrink-0">
                            {{ strtoupper(substr($app->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-base mb-0.5">
                                {{ $app->user->name ?? 'Kandidat' }}
                            </h4>
                            <p class="text-sm text-gray-500 font-medium mb-2">
                                Melamar posisi:
                                <span class="text-[#143E72] font-semibold">
                                    {{ $app->job->posisi ?? '-' }}
                                </span>
                            </p>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-400">
                                <span>💼 {{ $app->job->jenis_bidang ?? '-' }}</span>
                                <span>📂 {{ $app->job->kategori ?? '-' }}</span>
                                <span>💰 Rp {{ number_format($app->job->gaji_minimum ?? 0, 0, ',', '.') }}
                                    – Rp {{ number_format($app->job->gaji_maksimum ?? 0, 0, ',', '.') }}
                                </span>
                                <span>⏱️ {{ $app->created_at?->diffForHumans() ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wide
                                     uppercase shadow-sm
                            @if($app->status === 'BARU')      bg-blue-50 text-blue-700 border border-blue-200
                            @elseif($app->status === 'REVIEW')     bg-amber-50 text-amber-700 border border-amber-200
                            @elseif($app->status === 'INTERVIEW')  bg-purple-50 text-purple-700 border border-purple-200
                            @elseif($app->status === 'DITERIMA')   bg-emerald-50 text-emerald-700 border border-emerald-200
                            @else bg-red-50 text-red-700 border border-red-200
                            @endif">
                            {{ $app->status }}
                        </span>
                        <a href="{{ route('company.applicant.review', $app->id) }}"
                           class="text-xs font-semibold text-[#143E72] hover:underline">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>
@endsection