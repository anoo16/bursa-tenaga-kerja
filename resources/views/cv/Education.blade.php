{{-- Riwayat Pendidikan - Step 2 --}}
@extends('layouts.jobseeker')

@section('title', 'Riwayat Pendidikan - Bursa Tenaga Kerja')
@section('nav-profil', 'active')

@section('header-classes', 'bg-white border-b border-gray-100 px-6 py-3 flex items-center justify-between sticky top-0 z-30')

@section('header-actions')
    <div class="w-8 h-8 rounded-full bg-navy-500 text-white flex items-center justify-center text-sm font-bold">BL</div>
@endsection

@section('content-classes', 'flex-1 p-6')

@section('header-content')
    <p class="text-sm text-gray-500">Profil &rsaquo; Riwayat Pendidikan</p>
@endsection

@section('content')
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Riwayat Pendidikan</h1>
    <p class="text-sm text-gray-500 mb-8">Tambahkan riwayat pendidikan Anda.</p>

    <!-- Stepper -->
    <div class="flex items-center gap-0 mb-8 overflow-x-auto">
        @php $steps=['Biodata','Pendidikan','Pengalaman','Keahlian','Keluarga']; @endphp
        @foreach($steps as $i => $s)
        <div class="flex items-center {{ $i < count($steps)-1 ? 'flex-1' : '' }}">
            <div class="flex items-center gap-2 flex-shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $i < 1 ? 'bg-green-500 text-white' : ($i == 1 ? 'bg-navy-500 text-white' : 'bg-gray-200 text-gray-400') }}">
                    @if($i < 1)<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>@else{{ $i+1 }}@endif
                </div>
                <span class="text-xs font-medium {{ $i <= 1 ? 'text-navy-500' : 'text-gray-400' }} whitespace-nowrap">{{ $s }}</span>
            </div>
            @if($i < count($steps)-1)<div class="flex-1 h-0.5 mx-3 {{ $i < 1 ? 'bg-green-500' : 'bg-gray-200' }}"></div>@endif
        </div>
        @endforeach
    </div>

    <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-white shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-semibold text-gray-900">Riwayat Pendidikan</h3>
            <button class="text-xs bg-navy-500 text-white px-3 py-1.5 rounded-lg font-medium hover:bg-navy-600 transition">+ Tambah Pendidikan</button>
        </div>

        <!-- Education Card -->
        <div class="border border-gray-100 rounded-xl p-5 mb-4 bg-cream-50">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Institusi / Universitas</label>
                    <input type="text" value="Universitas Sam Ratulangi" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan / Program Studi</label>
                    <input type="text" value="Teknik Informatika" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenjang</label>
                    <select class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                        <option>SMA/SMK</option><option selected>S1</option><option>S2</option><option>S3</option><option>D3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">IPK</label>
                    <input type="text" value="3.75" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Masuk</label>
                    <input type="number" value="2018" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                    <input type="number" value="2022" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-white">
                </div>
            </div>
            <!-- Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload Ijazah / Transkrip</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center bg-white">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-xs text-gray-500">Drag & drop atau <span class="text-navy-500 font-medium cursor-pointer">pilih file</span></p>
                    <p class="text-[10px] text-gray-400 mt-1">PDF, JPG, PNG (max 5MB)</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <button class="px-5 py-2.5 border border-gray-200 text-gray-500 rounded-xl text-sm font-medium hover:bg-gray-50 transition">Sebelumnya</button>
            <button class="px-5 py-2.5 bg-navy-500 text-white rounded-xl text-sm font-medium hover:bg-navy-600 transition shadow-lg shadow-navy-500/25">Selanjutnya</button>
        </div>
    </div>
@endsection