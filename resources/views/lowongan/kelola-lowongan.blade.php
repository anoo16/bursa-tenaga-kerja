{{-- 
    Halaman Utama: Kelola Lowongan
    Menggunakan layout recruiter, memuat aset CSS dan JS secara modular menggunakan Laravel Vite,
    serta menampilkan statistik lowongan dan tabel daftar pekerjaan recruiter.
--}}
@extends('layouts.recruiter')

{{-- Bagian Stylesheet Khusus Halaman Kelola Lowongan --}}
@section('styles')
    @vite('resources/css/lowongan.css')
    <style>
    /* Sembunyikan teks "Showing x to y of z results" pada pagination bawaan Laravel */
    nav[role="navigation"] .hidden.sm\:flex-1 > div:first-child {
        display: none;
    }
    nav[role="navigation"] .hidden.sm\:flex-1 {
        justify-content: center !important;
    }
    /* Override pagination colors to stay light mode */
    nav[role="navigation"] a,
    nav[role="navigation"] span {
        background-color: #ffffff !important;
        color: #374151 !important; /* gray-700 */
        border-color: #d1d5db !important; /* gray-300 */
    }
    /* Active page (current) */
    nav[role="navigation"] span[aria-current="page"] > span {
        background-color: #F3EFE0 !important;
        border-color: #F3EFE0 !important;
        color: #143E72 !important;
    }
</style>
@endsection

{{-- Bagian Script Logika JavaScript Halaman Kelola Lowongan --}}
@section('scripts')
    @vite('resources/js/lowongan.js')
@endsection

{{-- Konten Utama Dasbor --}}
@section('content')

{{-- ===================== BANNER NOTIFIKASI SUKSES / ERROR (TOAST) ===================== --}}

{{-- Notifikasi Sukses dari Session --}}
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

{{-- Notifikasi Error Validasi Backend --}}
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

{{-- Notifikasi General Error dari Session --}}
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

    {{-- ===================== HEADER HALAMAN & TOMBOL AKSI UTAMA ===================== --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#143E72]">Kelola Lowongan</h1>
            <p class="text-gray-500 text-sm">Kelola lowongan pekerjaan perusahaan</p>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            {{-- Tombol Filter Pencarian --}}
            <button id="btn-filter" class="flex-1 sm:flex-none justify-center flex items-center gap-2 bg-gray-200 text-gray-800 hover:bg-gray-300 px-5 py-3 rounded-xl font-semibold text-sm transition-all duration-200 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0">
                Filter
            </button>
            {{-- Tombol Pasang Lowongan Baru (Membuka Pop-Up) --}}
            <button
                id="btn-buka-modal"
                onclick="bukaModal()"
                class="flex-2 sm:flex-none justify-center flex items-center gap-2 bg-[#143E72] hover:bg-[#0f2d54]
                       text-white px-5 py-3 rounded-xl font-semibold text-sm
                       transition-all duration-200 shadow-md hover:shadow-lg
                       hover:-translate-y-0.5 active:translate-y-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Pasang Lowongan Baru
            </button>
        </div>
    </div>

    {{-- ===================== RINGKASAN STATISTIK LOWONGAN ===================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        {{-- Statistik Lowongan Aktif --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Lowongan Aktif</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['aktif'] }}</h2>
        </div>
        {{-- Statistik Total Pelamar Masuk --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Total Pelamar</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['pelamar'] }}</h2>
        </div>
        {{-- Statistik Persentase Keberhasilan Rekrutmen --}}
        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-gray-500">Perekrutan Berhasil</p>
            <h2 class="text-3xl font-bold mt-2">{{ $stats['sukses'] }}%</h2>
        </div>
    </div>

    {{-- ===================== TABEL DAFTAR DATA LOWONGAN PEKERJAAN ===================== --}}
    <div class="bg-white rounded-3xl border border-[#EBE8DF] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse table-fixed min-w-[900px]">
                <thead>
                    <tr class="text-white">
                        <th class="w-[35%] text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72] rounded-tl-3xl">Lowongan</th>
                        <th class="w-[15%] text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Status</th>
                        <th class="w-[15%] text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Pelamar</th>
                        <th class="w-[15%] text-left px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72]">Deadline</th>
                        <th class="w-[20%] text-right px-6 py-4.5 text-sm font-extrabold uppercase tracking-wider text-white bg-[#143E72] rounded-tr-3xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F3EFE0]">
                    @forelse($jobs as $job)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        {{-- Posisi Pekerjaan & Kategori Lowongan --}}
                        <td class="px-6 py-5 whitespace-normal">
                            <p class="text-sm font-extrabold text-[#113255] leading-tight mb-1">{{ $job->posisi }}</p>
                            <span class="text-xs text-slate-400 font-semibold">{{ $job->jenis_bidang }} &bull; {{ $job->kategori }}</span>
                        </td>
                        
                        {{-- Badge Status Lowongan (Aktif / Tutup) --}}
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

                        {{-- Link Daftar Pelamar --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            <a href="{{ route('company.applicants') }}" 
                               class="text-sm font-semibold text-slate-500 hover:text-[#143E72] hover:underline transition-colors"
                               title="Lihat Pelamar">
                                {{ $job->applications_count }} Pelamar
                            </a>
                        </td>

                        {{-- Batas Akhir (Deadline) Pengiriman Lamaran --}}
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-sm font-semibold text-slate-500">
                                {{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->translatedFormat('d M Y') : 'Tidak ada' }}
                            </span>
                        </td>

                        {{-- Tombol Aksi Detail, Aktif/Nonaktifkan, & Hapus Lowongan --}}
                        <td class="px-6 py-5 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                {{-- Tombol Detail: Membuka Pop-Up Detail Lowongan --}}
                                <button type="button" 
                                        onclick='lihatLowongan("{{ $job->id }}", "{{ $job->posisi }}", "{{ $job->kategori }}", "{{ $job->gaji }}", "{{ $job->deadline }}", @json($job->tanggung_jawab), @json($job->kualifikasi), "{{ $job->jenis_bidang }}")'
                                        class="w-10 h-10 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 text-[#143E72] flex items-center justify-center transition-all duration-200 shadow-sm"
                                        title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                                    </svg>
                                </button>

                                {{-- Tombol Buka/Tutup Lowongan --}}
                                <form action="{{ route('company.jobs.toggle', $job->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($job->status == 'buka')
                                    <button type="submit" 
                                            class="w-10 h-10 border border-slate-200 rounded-xl bg-white hover:bg-slate-50 hover:-translate-y-0.5 active:translate-y-0 text-orange-500 hover:text-orange-600 flex items-center justify-center transition-all duration-200 shadow-sm"
                                            title="Tutup Lowongan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10"/>
                                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                                        </svg>
                                    </button>
                                    @else
                                    <button type="submit" 
                                            class="w-10 h-10 flex items-center justify-center text-green-600 hover:text-green-700 hover:scale-115 active:scale-95 transition-all duration-200"
                                            title="Buka Lowongan">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                    </button>
                                    @endif
                                </form>

                                {{-- Tombol Hapus Lowongan: Membuka Pop-Up Konfirmasi --}}
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
                    {{-- Tampilan saat data lowongan masih kosong --}}
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
        {{-- Pagination Links --}}
        <div class="mt-5">{{ $jobs->links() }}</div>
         <script>
         document.addEventListener('DOMContentLoaded', () => {
           const url = new URL(window.location);
           const page = Number(url.searchParams.get('page') || 1);
           const emptyCell = document.querySelector('td[colspan="5"]');
           const isEmpty = emptyCell && emptyCell.textContent.includes('Belum ada lowongan');
           if (page > 1 && isEmpty) {
             const prevPage = page - 1;
             url.searchParams.set('page', prevPage);
             window.location = url.toString();
           }
         });
         </script>
    </div>
</div>

{{-- Memuat Seluruh Pop-up Window (Tambah, Detail, Edit, Hapus) --}}
@include('lowongan.partials.pop-up')

@endsection