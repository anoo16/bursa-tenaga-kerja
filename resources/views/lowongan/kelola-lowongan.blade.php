@extends('layouts.recruiter')
@section('content')

{{-- ===================== NOTIFIKASI SUKSES / ERROR ===================== --}}
@if(session('success'))
<div id="notif-sukses"
    class="fixed top-6 right-6 z-[9999] flex items-center gap-3
           bg-white border border-green-200 shadow-xl rounded-2xl px-5 py-4
           animate-slide-in">
    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5"
             viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>
    <p class="text-sm font-semibold text-slate-700">{{ session('success') }}</p>
    <button onclick="document.getElementById('notif-sukses').remove()"
            class="ml-2 text-slate-400 hover:text-slate-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
</div>
@endif

@if($errors->any())
<div id="notif-error-backend"
    class="fixed top-6 right-6 z-[9999] flex flex-col gap-2
           bg-white border border-red-200 shadow-xl rounded-2xl px-5 py-4
           animate-slide-in">
    <div class="flex items-center justify-between gap-3 border-b pb-2 mb-1">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span class="text-sm font-bold text-red-600 text-left">Terjadi Kesalahan Validasi</span>
        </div>
        <button onclick="document.getElementById('notif-error-backend').remove()" class="text-slate-400 hover:text-slate-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <ul class="list-disc pl-5 space-y-1 text-left">
        @foreach($errors->all() as $error)
        <li class="text-xs font-semibold text-slate-600">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session('error'))
<div id="notif-error"
    class="fixed top-6 right-6 z-[9999] flex items-center gap-3
           bg-white border border-red-200 shadow-xl rounded-2xl px-5 py-4
           animate-slide-in">
    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5"
             viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </div>
    <p class="text-sm font-semibold text-slate-700">{{ session('error') }}</p>
    <button onclick="document.getElementById('notif-error').remove()"
            class="ml-2 text-slate-400 hover:text-slate-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
    </button>
</div>
@endif

<div class="p-6">

    {{-- ===================== HEADER ===================== --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#143E72]">Kelola Lowongan</h1>
            <p class="text-gray-500">Kelola lowongan pekerjaan perusahaan</p>
        </div>
        {{-- Tombol buka popup --}}
        <button
            id="btn-buka-modal"
            onclick="bukaModal()"
            class="flex items-center gap-2 bg-[#143E72] hover:bg-[#0f2d54]
                   text-white px-5 py-3 rounded-xl font-semibold text-sm
                   transition-all duration-200 shadow-md hover:shadow-lg
                   hover:-translate-y-0.5 active:translate-y-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Pasang Lowongan Baru
        </button>
    </div>

    {{-- ===================== STATISTIK ===================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        {{-- Lowongan aktif --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Lowongan Aktif</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['aktif'] }}</h2>
        </div>
        {{-- Total pelamar --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Total Pelamar</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['pelamar'] }}</h2>
        </div>
        {{-- Perekrutan berhasil --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Perekrutan Berhasil</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['sukses'] }}%</h2>
        </div>
    </div>

    {{-- ===================== TABEL ===================== --}}
    <div class="bg-white rounded-3xl border border-[#EBE8DF] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="text-white">
                        <th class="text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72] rounded-tl-3xl">Lowongan</th>
                        <th class="text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Status</th>
                        <th class="text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Pelamar</th>
                        <th class="text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Deadline</th>
                        <th class="text-right px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72] rounded-tr-3xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F3EFE0]">
                    @forelse($jobs as $job)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        {{-- Posisi & Kategori --}}
                        <td class="px-6 py-5 whitespace-normal">
                            <p class="text-sm font-extrabold text-[#113255] leading-tight mb-1">{{ $job->posisi }}</p>
                            <span class="text-xs text-slate-400 font-semibold">{{ $job->kategori }}</span>
                        </td>
                        
                        {{-- Status Badge --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            @if($job->status === 'buka')
                            <span class="inline-flex items-center justify-center bg-[#E6F2FE] text-[#143E72] text-[10px] font-extrabold px-[10px] py-[4px] rounded-full uppercase tracking-wider">
                                AKTIF
                            </span>
                            @else
                            <span class="inline-flex items-center justify-center bg-red-50 text-red-600 text-[10px] font-extrabold px-[10px] py-[4px] rounded-full uppercase tracking-wider">
                                TUTUP
                            </span>
                            @endif
                        </td>

                        {{-- Pelamar --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            <a href="{{ route('company.applicants') }}" 
                               class="text-sm font-semibold text-slate-500 hover:text-[#143E72] hover:underline transition-colors"
                               title="Lihat Pelamar">
                                {{ $job->applications_count }} Pelamar
                            </a>
                        </td>

                        {{-- Batas Waktu / Deadline --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-500">
                                {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') : 'Tidak ada' }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Lihat (Detail) --}}
                                <button type="button" 
                                        onclick='lihatLowongan("{{ $job->id }}", "{{ $job->posisi }}", "{{ $job->kategori }}", "{{ $job->gaji }}", "{{ $job->deadline }}", @json($job->tanggung_jawab), @json($job->kualifikasi))'
                                        class="w-10 h-10 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 text-[#143E72] flex items-center justify-center transition-all duration-200 shadow-sm"
                                        title="Lihat Detail">
                                    <!-- Info Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                    </svg>
                                </button>

                                {{-- Buka / Tutup --}}
                                <form action="{{ route('company.jobs.toggle', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($job->status == 'buka')
                                    <button type="submit" 
                                            class="w-10 h-10 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 text-orange-500 hover:text-orange-600 flex items-center justify-center transition-all duration-200 shadow-sm"
                                            title="Tutup Lowongan">
                                        <!-- Ban/Deactivate Icon -->
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                                        </svg>
                                    </button>
                                    @else
                                    <button type="submit" 
                                            class="w-10 h-10 flex items-center justify-center text-green-600 hover:text-green-700 hover:scale-115 active:scale-95 transition-all duration-200"
                                            title="Buka Lowongan">
                                        <!-- Centang Hijau Icon (Checkmark) (Only green checkmark logo) -->
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </button>
                                    @endif
                                </form>

                                {{-- Hapus --}}
                                <form id="hapus-form-{{ $job->id }}" action="{{ route('company.jobs.delete', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="bukaHapus({{ $job->id }})" class="w-10 h-10 border border-red-100 rounded-xl bg-white hover:bg-red-50 hover:-translate-y-0.5 active:translate-y-0 text-red-500 flex items-center justify-center transition-all duration-200 shadow-sm" title="Hapus Lowongan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            <line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-10 text-slate-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M9 12h6m-3-3v6M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                            </svg>
                            Belum ada lowongan. Pasang lowongan pertama Anda!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $jobs->links() }}</div>
    </div>
</div>


{{-- ============================================================ --}}
{{-- ====================== MODAL POPUP ========================= --}}
{{-- ============================================================ --}}
<div id="modal-overlay"
     class="fixed inset-0 z-[1000] flex items-center justify-center p-4
            bg-black/50 backdrop-blur-sm
            opacity-0 pointer-events-none transition-all duration-300">

    {{-- Kotak modal --}}
    <div id="modal-box"
         class="relative bg-white rounded-3xl shadow-2xl w-[980px]
                flex overflow-hidden
                scale-95 opacity-0 transition-all duration-300">

        {{-- -------- PANEL KIRI (Dekoratif) -------- --}}
        <div class="hidden md:flex w-[200px] shrink-0 bg-[#143E72] flex-col justify-between p-6">
            {{-- Logo / Icon --}}
            <div>
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                         stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <h2 class="text-white text-2xl font-bold leading-tight mb-3">
                    Bangun Tim<br>Impian Anda
                </h2>
                <p class="text-blue-200 text-sm leading-relaxed">
                    Setiap posisi adalah peluang untuk mengubah masa depan industri bersama talenta yang tepat.
                </p>
            </div>

            {{-- Dekorasi bawah --}}
            <div class="space-y-3">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-300"></div>
                    <span class="text-blue-200 text-xs">Mudah & Cepat</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-300"></div>
                    <span class="text-blue-200 text-xs">Jangkau Ribuan Pelamar</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-300"></div>
                    <span class="text-blue-200 text-xs">Kelola dengan Mudah</span>
                </div>
            </div>
        </div>

        {{-- -------- PANEL KANAN (Form) -------- --}}
        <div class="flex-1 flex flex-col max-h-[90vh] overflow-y-auto">
            {{-- Header form --}}
            <div class="flex items-center justify-between px-8 pt-7 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-xl font-bold text-[#143E72]">Pasang Lowongan Baru</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Lengkapi detail posisi yang sedang Anda cari.</p>
                </div>
                <button onclick="tutupModal()"
                        class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200
                               flex items-center justify-center transition-colors shrink-0">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor"
                         stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            {{-- Form --}}
            <form id="form-lowongan"
                  action="{{ route('company.jobs.store') }}" method="POST"
                  class="px-8 py-6 space-y-5">
                @csrf

                {{-- Baris 1: Judul Posisi + Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Judul Posisi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Judul Posisi
                        </label>
                        <input
                            type="text"
                            name="posisi"
                            id="input-posisi"
                            placeholder="Contoh: Senior UI Designer"
                            value="{{ old('posisi') }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-sm text-slate-800
                                   focus:outline-none focus:border-[#143E72] focus:bg-white
                                   transition-all duration-200 placeholder-slate-400">
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Kategori
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach(['KONTRAK','TETAP','PARUH WAKTU','MAGANG'] as $kat)
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="kategori" value="{{ $kat }}"
                                       {{ old('kategori') === $kat ? 'checked' : '' }}
                                       required
                                       class="accent-[#143E72] w-4 h-4">
                                <span class="text-sm text-slate-700 group-hover:text-[#143E72] transition-colors">
                                    {{ $kat }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Baris 2: Batas Waktu + Rentang Gaji --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Batas Waktu --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Batas Waktu (Deadline)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                     stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                            <input
                                type="date"
                                name="deadline"
                                id="input-deadline"
                                value="{{ old('deadline') }}"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200">
                        </div>
                    </div>

                    {{-- Rentang Gaji --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Rentang Gaji
                        </label>

                        <div class="grid grid-cols-2 gap-3">

                            {{-- Gaji minimum --}}
                            <div class="relative">

                                <input type="text" id="gaji-min" placeholder="Minimum" class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-sm text-slate-800
                                   focus:outline-none focus:border-[#143E72]
                                   focus:bg-white transition-all duration-200">

                            </div>


                            {{-- Gaji maksimum --}}
                            <div class="relative">

                                <input type="text" id="gaji-max" placeholder="Maksimum"
                                    class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72]
                                       focus:bg-white transition-all duration-200">

                            </div>

                        </div>

                        {{-- Nilai gabungan untuk dikirim ke database --}}
                        <input type="hidden" name="gaji" id="gaji-final">

                    </div>
                </div>

                {{-- Tanggung Jawab (dinamis) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggung Jawab
                    </label>
                    <div id="list-tanggung-jawab" class="space-y-2">
                        <div class="flex items-start gap-2 item-tanggung-jawab">
                            <textarea
                                name="tanggung_jawab[]"
                                rows="2"
                                placeholder="Jelaskan peran ini secara ringkas dan menarik..."
                                required
                                class="flex-1 px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200 placeholder-slate-400 resize-none"
                            ></textarea>
                            <button type="button" onclick="hapusItem(this, 'list-tanggung-jawab')"
                                    class="mt-1 w-8 h-8 rounded-full bg-red-50 hover:bg-red-100
                                           flex items-center justify-center transition-colors shrink-0
                                           text-red-400 hover:text-red-600 hidden-remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                     viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button"
                            onclick="tambahItem('list-tanggung-jawab','tanggung_jawab[]','Jelaskan peran ini secara ringkas dan menarik...')"
                            class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54]
                                   text-sm font-semibold transition-colors">
                        <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3"
                                 viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        Tambah Poin
                    </button>
                </div>

                {{-- Kualifikasi (dinamis) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Kualifikasi
                    </label>
                    <div id="list-kualifikasi" class="space-y-2">
                        <div class="flex items-start gap-2 item-kualifikasi">
                            <textarea
                                name="kualifikasi[]"
                                rows="2"
                                placeholder="Jelaskan peran ini secara ringkas dan menarik..."
                                required
                                class="flex-1 px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200 placeholder-slate-400 resize-none"
                            ></textarea>
                            <button type="button" onclick="hapusItem(this, 'list-kualifikasi')"
                                    class="mt-1 w-8 h-8 rounded-full bg-red-50 hover:bg-red-100
                                           flex items-center justify-center transition-colors shrink-0
                                           text-red-400 hover:text-red-600 hidden-remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                     viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18"/>
                                    <line x1="6" y1="6" x2="18" y2="18"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="button"
                            onclick="tambahItem('list-kualifikasi','kualifikasi[]','Jelaskan peran ini secara ringkas dan menarik...')"
                            class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54]
                                   text-sm font-semibold transition-colors">
                        <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3"
                                 viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                        </div>
                        Tambah Poin
                    </button>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="tutupModal()"
                            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600
                                   hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit"
                            class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold
                                   bg-[#143E72] hover:bg-[#0f2d54] text-white
                                   transition-all duration-200 shadow-md hover:shadow-lg
                                   hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                             viewBox="0 0 24 24">
                            <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                        </svg>
                        Pasang Lowongan
                    </button>
                </div>
            </form>
        </div>{{-- end panel kanan --}}
    </div>{{-- end modal-box --}}
</div>{{-- end modal-overlay --}}

{{-- ======================================================= --}}
{{-- ================= MODAL DETAIL ======================== --}}
{{-- ======================================================= --}}
<div id="detail-modal" class="fixed inset-0 z-[2000] bg-black/50 backdrop-blur-sm hidden items-center justify-center">
    <div class="bg-white rounded-3xl w-[50%] max-h-[90vh] shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-6 bg-[#143E72]">
            <div>
                <h2 id="detail-posisi" class="text-2xl font-bold text-white"></h2>
                <p class="text-sm text-blue-100 mt-1">
                    Informasi lengkap lowongan
                </p>
            </div>

            <button onclick="tutupDetail()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        {{-- Isi --}}
        <div class="detail-scroll px-7 pt-7 pb-1 space-y-5 overflow-y-auto max-h-[65vh]">
            {{-- Kategori --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kategori</h3>
                <p id="detail-kategori" class="text-sm text-slate-700"></p>
            </div>

            {{-- Deadline --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Deadline</h3>
                <p id="detail-deadline" class="text-sm text-slate-700"></p>
            </div>

            {{-- Rentang Gaji --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Rentang Gaji</h3>
                <p id="detail-gaji" class="text-sm text-slate-700"></p>
            </div>

            {{-- Tanggung Jawab --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-3">Tanggung Jawab</h3>
                <ul id="detail-tanggung" class="list-disc pl-5 space-y-2 text-sm text-slate-700"></ul>
            </div>

            {{-- Kualifikasi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-3">Kualifikasi</h3>
                <ul id="detail-kualifikasi" class="list-disc pl-5 space-y-2 text-sm text-slate-700"></ul>
            </div>

            {{-- Tombol bawah --}}
            <div class="flex justify-end items-center gap-3 pt-3 pb-3 mt-4 border-t border-slate-100">
                <button type="button" onclick="tutupDetail()" class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-all duration-200">
                    Tutup
                </button>
                <button type="button" onclick="bukaEdit()" class="px-5 py-2 rounded-xl bg-[#143E72] text-white text-sm hover:bg-[#0F2F57] transition-all duration-200">
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ======================================================= --}}
{{-- ================= MODAL EDIT ========================== --}}
{{-- ======================================================= --}}
<div id="edit-modal" class="fixed inset-0 z-[3000] bg-black/50 backdrop-blur-sm hidden items-center justify-center">
    <div class="bg-white rounded-3xl w-[50%] max-h-[90vh] shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-6 bg-[#143E72]">
            <div>
                <h2 class="text-2xl font-bold text-white">Edit Lowongan</h2>
                <p class="text-sm text-blue-100 mt-1">Perbarui informasi lowongan</p>
            </div>
            <button type="button" onclick="tutupEdit()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form id="form-edit-lowongan" method="POST" class="detail-scroll px-7 pt-7 pb-1 space-y-5 overflow-y-auto max-h-[65vh]">
            @csrf
            @method('PUT')

            {{-- Posisi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Posisi Pekerjaan</h3>
                <input id="edit-posisi" name="posisi" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200" required>
            </div>

            {{-- Kategori --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kategori</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['KONTRAK', 'TETAP', 'PARUH WAKTU', 'MAGANG'] as $kat)
                    <label class="flex items-center gap-2 cursor-pointer group select-none">
                        <input type="radio" name="kategori" value="{{ $kat }}" id="edit-kat-{{ str_replace(' ', '-', $kat) }}" required class="accent-[#143E72] w-4 h-4">
                        <span class="text-sm text-slate-700 group-hover:text-[#143E72] transition-colors">{{ $kat }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Deadline & Gaji --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Deadline --}}
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Batas Waktu (Deadline)</h3>
                    <input type="date" id="edit-deadline" name="deadline" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                </div>

                {{-- Rentang Gaji --}}
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Rentang Gaji</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <input type="text" id="edit-gaji-min" placeholder="Minimum" class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                        <input type="text" id="edit-gaji-max" placeholder="Maksimum" class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                    </div>
                    <input type="hidden" name="gaji" id="edit-gaji-final">
                </div>
            </div>

            {{-- Tanggung Jawab --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Tanggung Jawab</h3>
                <div id="edit-list-tanggung-jawab" class="space-y-2"></div>
                <button type="button" onclick="tambahItem('edit-list-tanggung-jawab','tanggung_jawab[]','Jelaskan peran ini secara ringkas...')" class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54] text-sm font-semibold transition-colors">
                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    Tambah Poin
                </button>
            </div>

            {{-- Kualifikasi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kualifikasi</h3>
                <div id="edit-list-kualifikasi" class="space-y-2"></div>
                <button type="button" onclick="tambahItem('edit-list-kualifikasi','kualifikasi[]','Jelaskan kualifikasi ini...')" class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54] text-sm font-semibold transition-colors">
                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    Tambah Poin
                </button>
            </div>

            {{-- Tombol bawah --}}
            <div class="flex justify-end gap-3 pt-3 pb-3 mt-4 border-t border-slate-100">
                <button type="button" onclick="tutupEdit()" class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-all duration-200">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-[#143E72] text-white text-sm hover:bg-[#0F2F57] transition-all duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================================================= --}}
{{-- ================= MODAL HAPUS ========================= --}}
{{-- ======================================================= --}}

<div id="hapus-modal" class="fixed inset-0 z-[5000] bg-black/50 backdrop-blur-sm hidden items-center justify-center">

    <div class="bg-white rounded-3xl w-[400px] p-7 shadow-2xl">

        <div class="text-center">

            <div class="w-16 h-16 rounded-2xl bg-red-50 mx-auto mb-5 flex items-center justify-center shadow-sm">

                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                    <line x1="10" y1="11" x2="10" y2="17"/>
                    <line x1="14" y1="11" x2="14" y2="17"/>
                </svg>
            </div>

            <h3 class="text-xl font-bold text-[#143E72]">
                Hapus Lowongan
            </h3>

            <p class="text-slate-500 mt-2">
                Yakin ingin menghapus lowongan ini?
            </p>

        </div>

        <div
        class="flex justify-center gap-3 mt-7">

            <button onclick="tutupHapus()" class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">

                Batal

            </button>

            <button id="btn-konfirmasi-hapus" class="px-6 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition">

                Hapus

            </button>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- ======================= STYLES ============================ --}}
{{-- ============================================================ --}}
<style>
/* Animasi notifikasi masuk dari kanan */
@keyframes slide-in {
    from { transform: translateX(100%); opacity: 0; }
    to   { transform: translateX(0);    opacity: 1; }
}
.animate-slide-in { animation: slide-in 0.35s cubic-bezier(.22,.68,0,1.2) both; }

/* Tombol hapus item tersembunyi jika hanya 1 item */
.hidden-remove-btn { display: none; }

/* Scrollbar halus di panel kanan modal */
#modal-box > div:last-child::-webkit-scrollbar { width: 4px; }
#modal-box > div:last-child::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 9999px; }

/* Scroll detail lowongan */
.detail-scroll::-webkit-scrollbar { width: 6px; }
.detail-scroll::-webkit-scrollbar-track { background: transparent; }
.detail-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 999px; }
.detail-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

{{-- ============================================================ --}}
{{-- ====================== JAVASCRIPT ========================== --}}
{{-- ============================================================ --}}
<script>

let activeJob = null;

/* ---- Buka Modal Tambah Lowongan ---- */
function bukaModal() {
    const overlay = document.getElementById('modal-overlay');
    const box = document.getElementById('modal-box');
    overlay.classList.remove('opacity-0', 'pointer-events-none');
    overlay.classList.add('opacity-100', 'pointer-events-auto');
    setTimeout(() => {
        box.classList.remove('scale-95', 'opacity-0');
        box.classList.add('scale-100', 'opacity-100');
    }, 10);
    document.body.style.overflow = 'hidden';
}

/* ---- Tutup Modal Tambah Lowongan ---- */
function tutupModal() {
    const overlay = document.getElementById('modal-overlay');
    const box = document.getElementById('modal-box');
    box.classList.remove('scale-100', 'opacity-100');
    box.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        overlay.classList.remove('opacity-100', 'pointer-events-auto');
        overlay.classList.add('opacity-0', 'pointer-events-none');
    }, 250);
    document.body.style.overflow = '';
}

/* ---- Klik luar modal ---- */
document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});

/* ---- ESC tutup modal ---- */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        tutupModal();
        tutupDetail();
        tutupEdit();
    }
});

/* ---- Tambah item dinamis ---- */
function tambahItem(listId, fieldName, placeholder) {
    const list = document.getElementById(listId);
    const prefix = listId.includes('tanggung') ? 'item-tanggung-jawab' : 'item-kualifikasi';
    const div = document.createElement('div');
    div.className = `flex items-start gap-2 ${prefix}`;
    div.innerHTML = `
        <textarea name="${fieldName}" rows="2" placeholder="${placeholder}" required class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none"></textarea>
        <button type="button" onclick="hapusItem(this, '${listId}')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
    `;
    list.appendChild(div);
    perbaruiTombolHapus(listId, prefix);
}

/* ---- Hapus item ---- */
function hapusItem(btn, listId) {
    const prefix = listId.includes('tanggung') ? 'item-tanggung-jawab' : 'item-kualifikasi';
    const list = document.getElementById(listId);
    const items = list.querySelectorAll(`.${prefix}`);
    if (items.length <= 1) return;
    btn.closest(`.${prefix}`).remove();
    perbaruiTombolHapus(listId, prefix);
}

/* ---- Update tombol hapus ---- */
function perbaruiTombolHapus(listId, prefix) {
    const list = document.getElementById(listId);
    const items = list.querySelectorAll(`.${prefix}`);
    items.forEach(item => {
        const btn = item.querySelector('button');
        if (btn) {
            btn.style.display = items.length > 1 ? 'flex' : 'none';
        }
    });
}

/* ---- Format Rupiah ---- */
document.querySelectorAll('.format-rupiah').forEach(input => {
    input.addEventListener('input', function() {
        let angka = this.value.replace(/\D/g, '');
        let rupiah = new Intl.NumberFormat('id-ID').format(angka);
        this.value = angka ? 'Rp ' + rupiah : '';
        
        if (this.id === 'gaji-min' || this.id === 'gaji-max') {
            gabungGaji();
        } else if (this.id === 'edit-gaji-min' || this.id === 'edit-gaji-max') {
            gabungGajiEdit();
        }
    });
});

function gabungGaji() {
    let min = document.getElementById('gaji-min').value;
    let max = document.getElementById('gaji-max').value;
    document.getElementById('gaji-final').value = min + ' - ' + max;
}

function gabungGajiEdit() {
    let min = document.getElementById('edit-gaji-min').value;
    let max = document.getElementById('edit-gaji-max').value;
    document.getElementById('edit-gaji-final').value = min + ' - ' + max;
}

/* ---- Detail Lowongan ---- */
function lihatLowongan(id, posisi, kategori, gaji, deadline, tanggung, kualifikasi) {
    activeJob = { id, posisi, kategori, gaji, deadline, tanggung, kualifikasi };

    document.getElementById('detail-posisi').innerText = posisi;
    document.getElementById('detail-kategori').innerText = kategori;
    document.getElementById('detail-gaji').innerText = gaji;
    document.getElementById('detail-deadline').innerText = deadline || 'Tidak ada batas waktu';

    let tanggungList = document.getElementById('detail-tanggung');
    tanggungList.innerHTML = '';
    tanggung.forEach(item => {
        tanggungList.innerHTML += `<li>${item}</li>`;
    });

    let kualifikasiList = document.getElementById('detail-kualifikasi');
    kualifikasiList.innerHTML = '';
    kualifikasi.forEach(item => {
        kualifikasiList.innerHTML += `<li>${item}</li>`;
    });

    document.getElementById('detail-modal').classList.replace('hidden', 'flex');
}

/* ---- Tutup Detail ---- */
function tutupDetail() {
    document.getElementById('detail-modal').classList.replace('flex', 'hidden');
}

/* ---- Edit Lowongan Langsung ---- */
function editLowonganLangsung(id, posisi, kategori, gaji, deadline, tanggung, kualifikasi) {
    activeJob = { id, posisi, kategori, gaji, deadline, tanggung, kualifikasi };
    bukaEdit();
}

/* ---- Buka Edit ---- */
function bukaEdit() {
    if (!activeJob) return;
    
    // Tutup detail modal jika terbuka
    const detailModal = document.getElementById('detail-modal');
    if (detailModal && !detailModal.classList.contains('hidden')) {
        tutupDetail();
    }

    const formEdit = document.getElementById('form-edit-lowongan');
    formEdit.action = `/company/jobs/${activeJob.id}`;

    document.getElementById('edit-posisi').value = activeJob.posisi;
    
    const cleanedKategori = activeJob.kategori ? activeJob.kategori.replace(/\s+/g, '-') : '';
    const radioKat = document.getElementById(`edit-kat-${cleanedKategori}`);
    if (radioKat) {
        radioKat.checked = true;
    }

    document.getElementById('edit-deadline').value = activeJob.deadline || '';

    let gajiMin = '';
    let gajiMax = '';
    if (activeJob.gaji && activeJob.gaji.includes(' - ')) {
        const parts = activeJob.gaji.split(' - ');
        gajiMin = parts[0] ? parts[0].trim() : '';
        gajiMax = parts[1] ? parts[1].trim() : '';
    } else {
        gajiMin = activeJob.gaji || '';
    }
    
    document.getElementById('edit-gaji-min').value = gajiMin;
    document.getElementById('edit-gaji-max').value = gajiMax;
    document.getElementById('edit-gaji-final').value = activeJob.gaji;

    const tanggungContainer = document.getElementById('edit-list-tanggung-jawab');
    tanggungContainer.innerHTML = '';
    if (activeJob.tanggung && activeJob.tanggung.length > 0) {
        activeJob.tanggung.forEach(item => {
            const div = document.createElement('div');
            div.className = `flex items-start gap-2 item-tanggung-jawab`;
            div.innerHTML = `
                <textarea name="tanggung_jawab[]" rows="2" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none" required>${item}</textarea>
                <button type="button" onclick="hapusItem(this, 'edit-list-tanggung-jawab')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
            `;
            tanggungContainer.appendChild(div);
        });
    } else {
        tambahItem('edit-list-tanggung-jawab', 'tanggung_jawab[]', 'Jelaskan peran ini secara ringkas...');
    }
    perbaruiTombolHapus('edit-list-tanggung-jawab', 'item-tanggung-jawab');

    const kualifikasiContainer = document.getElementById('edit-list-kualifikasi');
    kualifikasiContainer.innerHTML = '';
    if (activeJob.kualifikasi && activeJob.kualifikasi.length > 0) {
        activeJob.kualifikasi.forEach(item => {
            const div = document.createElement('div');
            div.className = `flex items-start gap-2 item-kualifikasi`;
            div.innerHTML = `
                <textarea name="kualifikasi[]" rows="2" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none" required>${item}</textarea>
                <button type="button" onclick="hapusItem(this, 'edit-list-kualifikasi')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
            `;
            kualifikasiContainer.appendChild(div);
        });
    } else {
        tambahItem('edit-list-kualifikasi', 'kualifikasi[]', 'Jelaskan kualifikasi ini...');
    }
    perbaruiTombolHapus('edit-list-kualifikasi', 'item-kualifikasi');

    document.getElementById('edit-modal').classList.replace('hidden', 'flex');
}

/* ---- Tutup Edit ---- */
function tutupEdit() {
    document.getElementById('edit-modal').classList.replace('flex', 'hidden');
}

/* ---- Modal hapus ---- */

let formHapus=null;

function bukaHapus(id)
{
    formHapus=
    document.getElementById(
    `hapus-form-${id}`
    );

    document
    .getElementById(
    'hapus-modal'
    )
    .classList
    .replace(
    'hidden',
    'flex'
    );
}

function tutupHapus()
{
    document
    .getElementById(
    'hapus-modal'
    )
    .classList
    .replace(
    'flex',
    'hidden'
    );
}

document
.getElementById(
'btn-konfirmasi-hapus'
)
.addEventListener(
'click',
function(){

    if(formHapus)
    {
        formHapus.submit();
    }

});

/* ---- Tampilkan Peringatan Toast ---- */
function tampilkanPeringatan(pesan) {
    const existing = document.getElementById('notif-peringatan');
    if (existing) existing.remove();

    const notif = document.createElement('div');
    notif.id = 'notif-peringatan';
    notif.className = 'fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-white border border-amber-200 shadow-xl rounded-2xl px-5 py-4 animate-slide-in';
    notif.innerHTML = `
        <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-slate-700">${pesan}</p>
        <button onclick="this.parentElement.remove()" class="ml-2 text-slate-400 hover:text-slate-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    `;
    document.body.appendChild(notif);
    setTimeout(() => {
        notif.style.opacity = '0';
        setTimeout(() => notif.remove(), 500);
    }, 5000);
}

/* ---- Form Submit Validation (Create & Edit) ---- */
function validasiFormLowongan(form) {
    // 1. Validasi Posisi
    const posisi = form.querySelector('[name="posisi"]');
    if (posisi && !posisi.value.trim()) {
        tampilkanPeringatan('Judul posisi pekerjaan harus diisi.');
        posisi.focus();
        return false;
    }

    // 2. Validasi Kategori
    const kategoriChecked = form.querySelector('[name="kategori"]:checked');
    if (!kategoriChecked) {
        tampilkanPeringatan('Silakan pilih salah satu kategori pekerjaan.');
        return false;
    }

    // 3. Validasi Gaji
    const gajiMinInput = form.id === 'form-lowongan' ? document.getElementById('gaji-min') : document.getElementById('edit-gaji-min');
    const gajiMaxInput = form.id === 'form-lowongan' ? document.getElementById('gaji-max') : document.getElementById('edit-gaji-max');
    if ((gajiMinInput && !gajiMinInput.value.trim()) || (gajiMaxInput && !gajiMaxInput.value.trim())) {
        tampilkanPeringatan('Silakan isi rentang gaji minimum dan maksimum.');
        if (gajiMinInput && !gajiMinInput.value.trim()) gajiMinInput.focus();
        else if (gajiMaxInput) gajiMaxInput.focus();
        return false;
    }

    // 4. Validasi Tanggung Jawab
    const tanggungJawabFields = form.querySelectorAll('[name="tanggung_jawab[]"]');
    for (let i = 0; i < tanggungJawabFields.length; i++) {
        if (!tanggungJawabFields[i].value.trim()) {
            tampilkanPeringatan('Bagian tanggung jawab tidak boleh ada yang kosong.');
            tanggungJawabFields[i].focus();
            return false;
        }
    }

    // 5. Validasi Kualifikasi/Persyaratan
    const kualifikasiFields = form.querySelectorAll('[name="kualifikasi[]"]');
    for (let i = 0; i < kualifikasiFields.length; i++) {
        if (!kualifikasiFields[i].value.trim()) {
            tampilkanPeringatan('Bagian kualifikasi/persyaratan tidak boleh ada yang kosong.');
            kualifikasiFields[i].focus();
            return false;
        }
    }

    return true;
}

document.getElementById('form-lowongan').addEventListener('submit', function(e) {
    if (!validasiFormLowongan(this)) {
        e.preventDefault();
    }
});

document.getElementById('form-edit-lowongan').addEventListener('submit', function(e) {
    if (!validasiFormLowongan(this)) {
        e.preventDefault();
    }
});

/* ---- Auto Hide Notifikasi ---- */
document.querySelectorAll('[id^="notif-"]').forEach(notif => {
    setTimeout(() => {
        notif.style.opacity = '0';
        setTimeout(() => notif.remove(), 500);
    }, 4000);
});

</script>
@endsection
