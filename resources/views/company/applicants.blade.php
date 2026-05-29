@extends('layouts.recruiter')

@section('title', 'Pelamar Masuk - ' . $company->name)

@section('content')
    <div class="p-6">
        {{-- ===================== HEADER ===================== --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-[#143E72]">Pelamar Masuk</h1>
                <p class="text-gray-500">Kelola lamaran pekerjaan yang masuk dari calon kandidat</p>
            </div>
            <a href="{{ route('company.dashboard') }}" class="flex items-center gap-2 bg-[#143E72] hover:bg-[#0f2d54]
                      text-white px-5 py-3 rounded-xl font-semibold text-sm
                      transition-all duration-200 shadow-md hover:shadow-lg
                      hover:-translate-y-0.5 active:translate-y-0">
                Kembali ke Dasbor
            </a>
        </div>

        {{-- ===================== KOTAK KOSONG (TUGAS KELOMPOK LAIN) ===================== --}}
        <div class="bg-white rounded-3xl border border-[#EBE8DF] shadow-sm p-12 text-center">
            <div class="max-w-md mx-auto py-8">
                <div
                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path
                            d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197M13 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-[#113255] mb-2">Fitur Pelamar Masuk</h3>
                <p class="text-sm text-slate-400 leading-relaxed">
                    Halaman ini kosong karena merupakan bagian dari tugas kelompok lain. Anggota kelompok lain akan
                    mengimplementasikan pengelolaan pelamar di sini.
                </p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function () {
            const companyNamePHP = "{{ $company->name }}";
            if (!companyNamePHP) {
                const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user'));
                if (user && user.company_name) {
                    document.title = 'Pelamar Masuk - ' + user.company_name;
                }
            }
        })();
    </script>
@endsection