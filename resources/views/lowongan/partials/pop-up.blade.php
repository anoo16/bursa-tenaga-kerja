{{-- ========================================================================= --}}
{{-- ======================= DAFTAR POP UP WINDOWS =========================== --}}
{{-- ========================================================================= --}}

{{--
1. POP UP: TAMBAH LOWONGAN BARU
Menampilkan form input multi-kolom beserta isian dinamis (tanggung jawab & kualifikasi)
yang dikirimkan ke route 'company.jobs.store'.
--}}
<div id="modal-overlay" class="fixed inset-0 z-[1000] flex items-center justify-center p-4
            bg-black/50 backdrop-blur-sm
            opacity-0 pointer-events-none transition-all duration-300">

    {{-- Kotak pop-up utama --}}
    <div id="modal-box" class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl mx-4 md:mx-0
                flex overflow-hidden
                scale-95 opacity-0 transition-all duration-300">

        {{-- -------- PANEL KIRI (Dekoratif & Branding) -------- --}}
        <div class="hidden md:flex w-[200px] shrink-0 bg-[#143E72] flex-col justify-between p-6">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                    </svg>
                </div>
                <h2 class="text-white text-2xl font-bold leading-tight mb-3">
                    Bangun Tim<br>Impian Anda
                </h2>
                <p class="text-blue-200 text-sm leading-relaxed">
                    Setiap posisi adalah peluang untuk mengubah masa depan industri bersama talenta yang tepat.
                </p>
            </div>

            {{-- Informasi Kelebihan Fitur --}}
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

        {{-- -------- PANEL KANAN (Form Isian Data Lowongan Baru) -------- --}}
        <div class="flex-1 flex flex-col max-h-[90vh] overflow-y-auto">
            {{-- Header form pop-up --}}
            <div class="flex items-center justify-between px-8 pt-7 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-xl font-bold text-[#143E72]">Pasang Lowongan Baru</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Lengkapi detail posisi yang sedang Anda cari.</p>
                </div>
                <button onclick="tutupModal()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200
                               flex items-center justify-center transition-colors shrink-0">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2.5"
                        viewBox="0 0 24 24">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            {{-- Form Input Data Lowongan Baru --}}
            <form id="form-lowongan" action="{{ route('company.jobs.store') }}" method="POST"
                class="px-8 py-6 space-y-5">
                @csrf

                {{-- Judul Posisi & Pilihan Kategori --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Input Judul Posisi --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Judul Posisi
                        </label>
                        <input type="text" name="posisi" id="input-posisi" placeholder="Contoh: Senior UI Designer"
                            value="{{ old('posisi') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-sm text-slate-800
                                   focus:outline-none focus:border-[#143E72] focus:bg-white
                                   transition-all duration-200 placeholder-slate-400">
                    </div>

                    {{-- Pilihan Kategori Kerja --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Kategori
                        </label>
                        {{-- New Dropdown select for category --}}
                        <div class="mt-2">
                            <label for="input-kategori-select"
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1"></label>
                            <select name="kategori" id="input-kategori-select" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                                <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>Pilih kategori
                                </option>
                                <option value="KONTRAK" {{ old('kategori') == 'KONTRAK' ? 'selected' : '' }}>KONTRAK
                                </option>
                                <option value="PEKERJA TETAP" {{ old('kategori') == 'PEKERJA TETAP' ? 'selected' : '' }}>
                                    PEKERJA TETAP</option>
                                <option value="PARUH WAKTU" {{ old('kategori') == 'PARUH WAKTU' ? 'selected' : '' }}>PARUH
                                    WAKTU</option>
                                <option value="MAGANG" {{ old('kategori') == 'MAGANG' ? 'selected' : '' }}>MAGANG</option>
                            </select>

                        </div>
                    </div>
                </div>

                {{-- Pilihan Jenis Bidang & Batas Waktu (Deadline) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Jenis Bidang --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Jenis Bidang
                        </label>
                        <select name="jenis_bidang" id="input-jenis-bidang-select" required class="w-full px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200">
                            <option value="" disabled selected>Pilih jenis bidang</option>
                            <option value="IT">IT</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="HR">HR</option>
                        </select>
                    </div>

                    {{-- Batas Waktu (Deadline) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                            Batas Waktu (Deadline)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <line x1="16" y1="2" x2="16" y2="6" />
                                    <line x1="8" y1="2" x2="8" y2="6" />
                                    <line x1="3" y1="10" x2="21" y2="10" />
                                </svg>
                            </div>
                            <input type="date" name="deadline" id="input-deadline" value="{{ old('deadline') }}" class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200
                                          bg-slate-50 text-sm text-slate-800
                                          focus:outline-none focus:border-[#143E72] focus:bg-white
                                          transition-all duration-200" />
                        </div>
                    </div>
                </div>

                {{-- Rentang Gaji (Min - Max) --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Rentang Gaji
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Gaji Minimum --}}
                        <div class="relative">
                            <input type="text" id="gaji-min" placeholder="Minimum" class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200
                                   bg-slate-50 text-sm text-slate-800
                                   focus:outline-none focus:border-[#143E72]
                                   focus:bg-white transition-all duration-200">
                        </div>
                        {{-- Gaji Maksimum --}}
                        <div class="relative">
                            <input type="text" id="gaji-max" placeholder="Maksimum" class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72]
                                       focus:bg-white transition-all duration-200">
                        </div>
                    </div>
                    {{-- Nilai akhir gabungan (Min - Max) untuk disimpan ke database --}}
                    <input type="hidden" name="gaji" id="gaji-final">
                </div>

                {{-- Kolom Dinamis Tanggung Jawab --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggung Jawab
                    </label>
                    <div id="list-tanggung-jawab" class="space-y-2">
                        <div class="flex items-start gap-2 item-tanggung-jawab">
                            <textarea name="tanggung_jawab[]" rows="2"
                                placeholder="Jelaskan peran ini secara ringkas dan menarik..." required class="flex-1 px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200 placeholder-slate-400 resize-none"></textarea>
                            <button type="button" onclick="hapusItem(this, 'list-tanggung-jawab')" class="mt-1 w-8 h-8 rounded-full bg-red-50 hover:bg-red-100
                                           flex items-center justify-center transition-colors shrink-0
                                           text-red-400 hover:text-red-600 hidden-remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    {{-- Tombol Tambah Baris Dinamis Tanggung Jawab --}}
                    <button type="button"
                        onclick="tambahItem('list-tanggung-jawab','tanggung_jawab[]','Jelaskan peran ini secara ringkas dan menarik...')"
                        class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54]
                                   text-sm font-semibold transition-colors">
                        <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </div>
                        Tambah Poin
                    </button>
                </div>

                {{-- Kolom Dinamis Kualifikasi --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Kualifikasi
                    </label>
                    <div id="list-kualifikasi" class="space-y-2">
                        <div class="flex items-start gap-2 item-kualifikasi">
                            <textarea name="kualifikasi[]" rows="2"
                                placeholder="Jelaskan peran ini secara ringkas dan menarik..." required class="flex-1 px-4 py-3 rounded-xl border border-slate-200
                                       bg-slate-50 text-sm text-slate-800
                                       focus:outline-none focus:border-[#143E72] focus:bg-white
                                       transition-all duration-200 placeholder-slate-400 resize-none"></textarea>
                            <button type="button" onclick="hapusItem(this, 'list-kualifikasi')" class="mt-1 w-8 h-8 rounded-full bg-red-50 hover:bg-red-100
                                           flex items-center justify-center transition-colors shrink-0
                                           text-red-400 hover:text-red-600 hidden-remove-btn">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5"
                                    viewBox="0 0 24 24">
                                    <line x1="18" y1="6" x2="6" y2="18" />
                                    <line x1="6" y1="6" x2="18" y2="18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    {{-- Tombol Tambah Baris Dinamis Kualifikasi --}}
                    <button type="button"
                        onclick="tambahItem('list-kualifikasi','kualifikasi[]','Jelaskan peran ini secara ringkas dan menarik...')"
                        class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54]
                                   text-sm font-semibold transition-colors">
                        <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </div>
                        Tambah Poin
                    </button>
                </div>

                {{-- Tombol Batal & Simpan --}}
                <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
                    <button type="button" onclick="tutupModal()" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600
                                   hover:bg-slate-100 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit" class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold
                                   bg-[#143E72] hover:bg-[#0f2d54] text-white
                                   transition-all duration-200 shadow-md hover:shadow-lg
                                   hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                        </svg>
                        Pasang Lowongan
                    </button>
                </div>
            </form>
        </div>{{-- end panel kanan --}}
    </div>{{-- end modal-box --}}
</div>{{-- end modal-overlay --}}


{{--
2. POP UP: DETAIL LOWONGAN
Menampilkan data lengkap lowongan terpilih secara read-only (Kategori, Deadline, Gaji,
Tanggung Jawab, Kualifikasi). Memiliki tombol redirect ke Form Edit.
--}}
<div id="detail-modal"
    class="fixed inset-0 z-[2000] bg-black/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] shadow-2xl overflow-hidden">

        {{-- Header Pop-Up Detail --}}
        <div class="flex items-center justify-between px-8 py-6 bg-[#143E72]">
            <div>
                <h2 id="detail-posisi" class="text-2xl font-bold text-white"></h2>
                <p class="text-sm text-blue-100 mt-1">
                    Informasi lengkap lowongan
                </p>
            </div>
            <button onclick="tutupDetail()"
                class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        {{-- Konten Informasi Detail Lowongan --}}
        <div class="detail-scroll px-7 pt-7 pb-1 space-y-5 overflow-y-auto max-h-[65vh]">
            {{-- Kategori --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kategori</h3>
                <p id="detail-kategori" class="text-sm text-slate-700"></p>
            </div>

            {{-- Jenis Bidang & Batas Waktu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Jenis Bidang</h3>
                    <p id="detail-jenis-bidang" class="text-sm text-slate-700"></p>
                </div>
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Deadline</h3>
                    <p id="detail-deadline" class="text-sm text-slate-700"></p>
                </div>
            </div>

            {{-- Rentang Gaji --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Rentang Gaji</h3>
                <p id="detail-gaji" class="text-sm text-slate-700"></p>
            </div>

            {{-- Daftar Tanggung Jawab --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-3">Tanggung Jawab</h3>
                <ul id="detail-tanggung" class="list-disc pl-5 space-y-2 text-sm text-slate-700"></ul>
            </div>

            {{-- Daftar Kualifikasi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-3">Kualifikasi</h3>
                <ul id="detail-kualifikasi" class="list-disc pl-5 space-y-2 text-sm text-slate-700"></ul>
            </div>

            {{-- Tombol Tutup & Edit --}}
            <div class="flex justify-end items-center gap-3 pt-3 pb-3 mt-4 border-t border-slate-100">
                <button type="button" onclick="tutupDetail()"
                    class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-all duration-200">
                    Tutup
                </button>
                <button type="button" onclick="bukaEdit()"
                    class="px-5 py-2 rounded-xl bg-[#143E72] text-white text-sm hover:bg-[#0F2F57] transition-all duration-200">
                    Edit
                </button>
            </div>
        </div>
    </div>
</div>


{{--
3. POP UP: EDIT DATA LOWONGAN
Menampilkan data lowongan yang ada dan memfasilitasi pengeditan. Form akan disubmit
melalui metode PUT ke URL action '/company/jobs/{id}' secara dinamis via JS.
--}}
<div id="edit-modal" class="fixed inset-0 z-[3000] bg-black/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] shadow-2xl overflow-hidden">

        {{-- Header Pop-Up Edit --}}
        <div class="flex items-center justify-between px-8 py-6 bg-[#143E72]">
            <div>
                <h2 class="text-2xl font-bold text-white">Edit Lowongan</h2>
                <p class="text-sm text-blue-100 mt-1">Perbarui informasi lowongan</p>
            </div>
            <button type="button" onclick="tutupEdit()"
                class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        {{-- Form Edit Data Lowongan --}}
        <form id="form-edit-lowongan" method="POST"
            class="detail-scroll px-7 pt-7 pb-1 space-y-5 overflow-y-auto max-h-[65vh]">
            @csrf
            @method('PUT')

            {{-- Input Posisi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Posisi Pekerjaan</h3>
                <input id="edit-posisi" name="posisi"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200"
                    required>
            </div>

            {{-- Pilihan Kategori --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kategori</h3>
                <select name="kategori" id="edit-kategori-select" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                    <option value="" disabled>Pilih kategori</option>
                    <option value="KONTRAK">KONTRAK</option>
                    <option value="PEKERJA TETAP">PEKERJA TETAP</option>
                    <option value="PARUH WAKTU">PARUH WAKTU</option>
                    <option value="MAGANG">MAGANG</option>
                </select>
            </div>

            {{-- Jenis Bidang & Batas Waktu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Jenis Bidang --}}
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Jenis Bidang</h3>
                    <select name="jenis_bidang" id="edit-jenis-bidang-select" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                        <option value="" disabled>Pilih jenis bidang</option>
                        <option value="IT">IT</option>
                        <option value="Finance">Finance</option>
                        <option value="Marketing">Marketing</option>
                        <option value="HR">HR</option>
                    </select>
                </div>

                {{-- Batas Waktu --}}
                <div>
                    <h3 class="font-bold text-[#143E72] mb-2">Batas Waktu (Deadline)</h3>
                    <input type="date" id="edit-deadline" name="deadline"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                </div>
            </div>

            {{-- Rentang Gaji --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Rentang Gaji</h3>
                <div class="grid grid-cols-2 gap-3">
                    <input type="text" id="edit-gaji-min" placeholder="Minimum"
                        class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                    <input type="text" id="edit-gaji-max" placeholder="Maksimum"
                        class="format-rupiah w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200">
                </div>
                {{-- Input Hidden hasil gabungan gaji --}}
                <input type="hidden" name="gaji" id="edit-gaji-final">
            </div>

            {{-- Kolom Dinamis Tanggung Jawab --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Tanggung Jawab</h3>
                <div id="edit-list-tanggung-jawab" class="space-y-2"></div>
                <button type="button"
                    onclick="tambahItem('edit-list-tanggung-jawab','tanggung_jawab[]','Jelaskan peran ini secara ringkas...')"
                    class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54] text-sm font-semibold transition-colors">
                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    Tambah Poin
                </button>
            </div>

            {{-- Kolom Dinamis Kualifikasi --}}
            <div>
                <h3 class="font-bold text-[#143E72] mb-2">Kualifikasi</h3>
                <div id="edit-list-kualifikasi" class="space-y-2"></div>
                <button type="button"
                    onclick="tambahItem('edit-list-kualifikasi','kualifikasi[]','Jelaskan kualifikasi ini...')"
                    class="mt-2 flex items-center gap-2 text-[#143E72] hover:text-[#0f2d54] text-sm font-semibold transition-colors">
                    <div class="w-6 h-6 rounded-full border-2 border-current flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    Tambah Poin
                </button>
            </div>

            {{-- Tombol Batal & Simpan --}}
            <div class="flex justify-end gap-3 pt-3 pb-3 mt-4 border-t border-slate-100">
                <button type="button" onclick="tutupEdit()"
                    class="px-4 py-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-all duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-[#143E72] text-white text-sm hover:bg-[#0F2F57] transition-all duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>


{{--
4. POP UP: KONFIRMASI HAPUS LOWONGAN
Pop-up dialog peringatan bahaya sebelum menghapus lowongan pekerjaan.
Membantu mencegah terhapusnya data secara tidak sengaja.
--}}
<div id="hapus-modal"
    class="fixed inset-0 z-[5000] bg-black/50 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-7 shadow-2xl">
        <div class="text-center">
            <div class="w-16 h-16 rounded-2xl bg-red-50 mx-auto mb-5 flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6" />
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    <line x1="10" y1="11" x2="10" y2="17" />
                    <line x1="14" y1="11" x2="14" y2="17" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-[#143E72]">
                Hapus Lowongan
            </h3>
            <p class="text-slate-500 mt-2">
                Yakin ingin menghapus lowongan ini?
            </p>
        </div>
        {{-- Tombol Batal & Konfirmasi Hapus --}}
        <div class="flex justify-center gap-3 mt-7">
            <button onclick="tutupHapus()"
                class="px-5 py-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition">
                Batal
            </button>
            <button id="btn-konfirmasi-hapus"
                class="px-6 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition">
                Hapus
            </button>
        </div>
    </div>
</div>