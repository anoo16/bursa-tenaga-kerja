@extends('layouts.recruiter')

@section('title', 'Edit Profil Perusahaan' . ($company['name'] ? ' - ' . $company['name'] : ''))

@section('content')
<div class="space-y-8">

    <!-- HEADER TITLE -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-[#113255] tracking-tight">Profil Perusahaan</h2>
            <p class="text-sm font-medium text-slate-500">Kelola informasi publik dan detail profil rekrutmen perusahaan Anda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('company.dashboard') }}" class="flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-500 font-extrabold text-sm py-3 px-5 rounded-2xl border border-slate-200 transition-all duration-200">
                Batal
            </a>
            <button type="submit" form="editProfileForm" class="flex items-center justify-center bg-[#143E72] hover:bg-[#0c2c54] text-white font-extrabold text-sm py-3.5 px-6 rounded-2xl transition-all duration-200 shadow-md shadow-blue-900/10">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <!-- MAIN GRID FORM -->
    <form id="editProfileForm" action="{{ route('company.profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')
        
        <!-- LEFT/CENTER COLUMN: GENERAL INFO FORM (col-span-2) -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white border border-[#EBE8DF] rounded-3xl p-8 shadow-sm space-y-6">

            <h3 class="text-xl font-extrabold text-[#113255] border-b border-[#F3EFE0] pb-4">Informasi Umum</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Perusahaan -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Nama Perusahaan</label>
                    <input type="text" name="name" id="inputCompanyName" value="{{ old('name', $company->name) }}" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200">
                </div>

                <!-- Website -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Website Resmi</label>
                    <input type="url" name="website" value="{{ old('website', $company->website) }}" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200">
                </div>

                <!-- Industri -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Industri</label>
                    <input type="text" name="industry" value="{{ old('industry', $company->industry) }}" placeholder="Contoh: Teknologi & Informasi" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200">
                </div>

                <!-- Ukuran Perusahaan -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Skala Karyawan</label>
                    <select name="size" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200">
                        <option value="" {{ old('size', $company->size) == '' ? 'selected' : '' }}>Pilih Skala Karyawan</option>
                        <option value="1-50" {{ old('size', $company->size) == '1-50' ? 'selected' : '' }}>1 - 50 Karyawan</option>
                        <option value="51-250" {{ old('size', $company->size) == '51-250' ? 'selected' : '' }}>51 - 250 Karyawan</option>
                        <option value="251-1000" {{ old('size', $company->size) == '251-1000' ? 'selected' : '' }}>251 - 1000 Karyawan</option>
                        <option value="1000+" {{ old('size', $company->size) == '1000+' ? 'selected' : '' }}>Lebih dari 1000 Karyawan</option>
                    </select>
                </div>

                <!-- Lokasi Kantor Pusat -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Alamat Kantor Pusat</label>
                    <input type="text" name="address" value="{{ old('address', $company->address) }}" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200">
                </div>

                <!-- Deskripsi Perusahaan -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Deskripsi Singkat Perusahaan</label>
                    <textarea name="description" rows="4" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200 leading-relaxed">{{ old('description', $company->description) }}</textarea>
                </div>
                <!-- Tentang Perusahaan -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Tentang Perusahaan</label>
                    <textarea name="about" rows="4" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200 leading-relaxed">{{ old('about', $company->about) }}</textarea>
                </div>

                <!-- Misi Kami -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Misi Kami</label>
                    <textarea name="mission" rows="3" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200 leading-relaxed">{{ old('mission', $company->mission) }}</textarea>
                </div>

                <!-- Kultur Kami -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-xs font-extrabold text-slate-500 uppercase tracking-wider">Kultur Kami</label>
                    <textarea name="culture" rows="3" class="w-full py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200 leading-relaxed">{{ old('culture', $company->culture) }}</textarea>
                </div>
            </div>
        </div>

        <!-- HIRING PERKS SECTION -->
        <div class="bg-white border border-[#EBE8DF] rounded-3xl p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-[#F3EFE0] pb-4">
                <h3 class="text-xl font-extrabold text-[#113255]">Hiring Perks</h3>
                <button type="button" onclick="addPerk()" class="bg-[#E6F2FE] text-[#143E72] hover:bg-[#143E72] hover:text-white font-extrabold text-xs py-2 px-4 rounded-xl transition-colors shadow-sm">
                    + Tambah Perk
                </button>
            </div>
            
            <div id="perksContainer" class="space-y-3">
                @foreach($company->perks as $perk)
                <div class="flex items-center gap-3">
                    <input type="text" name="perks[]" value="{{ old('perks.'.$loop->index, $perk->perk_name) }}" class="flex-1 py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200" placeholder="Contoh: Flexible Remote Work">
                    <button type="button" onclick="this.parentElement.remove()" class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                @endforeach
                @if($company->perks->count() == 0)
                <div class="flex items-center gap-3">
                    <input type="text" name="perks[]" class="flex-1 py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200" placeholder="Contoh: Flexible Remote Work">
                    <button type="button" onclick="this.parentElement.remove()" class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
                @endif
            </div>
        </div>

        </div>

        <!-- RIGHT COLUMN: MEDIA UPLOADS (col-span-1) -->
        <div class="space-y-6">
            
            <!-- LOGO UPLOAD CARD -->
            <div class="bg-white border border-[#EBE8DF] rounded-3xl p-6 shadow-sm space-y-4">
                <h4 class="text-sm font-extrabold text-[#113255] uppercase tracking-wider border-b border-[#F3EFE0] pb-3">Logo Perusahaan</h4>
                
                <div class="flex flex-col items-center gap-4 py-4">
                    <!-- Current logo preview -->
                    <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center border border-slate-200 shadow-sm overflow-hidden relative">
                        <img id="logoPreview" src="{{ $company->logo_path ? asset('storage/' . $company->logo_path) : '' }}" alt="Logo" class="w-full h-full object-contain {{ $company->logo_path ? '' : 'hidden' }}">
                        <div id="logoPlaceholder" class="flex items-center justify-center {{ $company->logo_path ? 'hidden' : '' }}">
                            <svg class="w-12 h-12 text-navy-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="10" width="20" height="12" rx="2" />
                                <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18" />
                                <line x1="10" y1="12" x2="10" y2="12.01" />
                                <line x1="14" y1="12" x2="14" y2="12.01" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="text-center space-y-1">
                        <p class="text-xs font-bold text-[#113255]">Unggah Logo Baru</p>
                        <p class="text-[10px] text-slate-400">Rekomendasi ukuran: 500x500 px. Format JPG, PNG, atau SVG.</p>
                    </div>

                    <input type="file" name="logo" id="logoInput" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-50 file:text-[#143E72] hover:file:bg-slate-100 transition-all cursor-pointer">
                </div>
            </div>

            <!-- COVER BANNER UPLOAD CARD -->
            <div class="bg-white border border-[#EBE8DF] rounded-3xl p-6 shadow-sm space-y-4">
                <h4 class="text-sm font-extrabold text-[#113255] uppercase tracking-wider border-b border-[#F3EFE0] pb-3">Cover Banner Perusahaan</h4>
                
                <div class="space-y-4">
                    <!-- Current cover preview -->
                    <div class="w-full h-32 bg-slate-100 rounded-xl overflow-hidden relative border border-slate-200 flex items-center justify-center">
                        <img id="bannerPreview" src="{{ $company->banner_path ? asset('storage/' . $company->banner_path) : '' }}" alt="Banner" class="w-full h-full object-cover {{ $company->banner_path ? '' : 'hidden' }}">
                        <div id="bannerPlaceholder" class="absolute inset-0 bg-gradient-to-r from-navy-500 to-navy-700 flex items-center justify-center {{ $company->banner_path ? 'hidden' : '' }}">
                            <span class="text-xs font-extrabold text-white bg-slate-900/40 px-3 py-1.5 rounded-lg border border-white/20">Preview Banner</span>
                        </div>
                    </div>

                    <div class="text-center space-y-1">
                        <p class="text-xs font-bold text-[#113255]">Unggah Banner Baru</p>
                        <p class="text-[10px] text-slate-400">Rekomendasi rasio: 16:9. Maksimal ukuran file: 2 MB.</p>
                    </div>

                    <div class="flex justify-center">
                        <input type="file" name="banner" id="bannerInput" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-50 file:text-[#143E72] hover:file:bg-slate-100 transition-all cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- GALLERY PHOTOS UPLOAD & MANAGE CARD -->
            <div class="bg-white border border-[#EBE8DF] rounded-3xl p-6 shadow-sm space-y-4">
                <h4 class="text-sm font-extrabold text-[#113255] uppercase tracking-wider border-b border-[#F3EFE0] pb-3">Galeri Foto Perusahaan</h4>
                
                <div class="space-y-4">
                    <!-- Existing photos -->
                    @if($company->galleries->count() > 0)
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($company->galleries as $gallery)
                                <div class="relative group aspect-square rounded-lg overflow-hidden border border-slate-200">
                                    <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="Galeri" class="w-full h-full object-cover">
                                    <label class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 cursor-pointer opacity-85 hover:opacity-100 transition-opacity" title="Hapus Foto">
                                        <input type="checkbox" name="delete_photos[]" value="{{ $gallery->id }}" class="hidden" onchange="toggleDeletePhoto(this)">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <line x1="18" y1="6" x2="6" y2="18"/>
                                            <line x1="6" y1="6" x2="18" y2="18"/>
                                        </svg>
                                    </label>
                                    <div class="absolute inset-0 bg-red-950/60 flex items-center justify-center text-white text-[9px] font-bold opacity-0 transition-opacity pointer-events-none delete-overlay text-center">
                                        AKAN DIHAPUS
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Upload new photos -->
                    <div class="text-center space-y-1">
                        <p class="text-xs font-bold text-[#113255]">Tambah Foto Baru</p>
                        <p class="text-[10px] text-slate-400">Pilih satu atau beberapa foto untuk ditambahkan ke galeri.</p>
                    </div>

                    <div class="flex justify-center flex-col gap-3">
                        <input type="file" name="photos[]" id="photosInput" accept="image/*" multiple class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-50 file:text-[#143E72] hover:file:bg-slate-100 transition-all cursor-pointer">
                        
                        <!-- New photos preview container -->
                        <div id="photosPreviewContainer" class="grid grid-cols-3 gap-2 hidden"></div>
                    </div>
                </div>
            </div>

        </div>

    </form>

</div>

<script>
    function addPerk() {
        const container = document.getElementById('perksContainer');
        const div = document.createElement('div');
        div.className = 'flex items-center gap-3';
        div.innerHTML = `
            <input type="text" name="perks[]" class="flex-1 py-3 px-4 bg-slate-50/50 focus:bg-white text-sm text-slate-800 rounded-xl border border-slate-200 focus:border-[#143E72] outline-none transition-all duration-200" placeholder="Contoh: Asuransi Kesehatan">
            <button type="button" onclick="this.parentElement.remove()" class="p-3 text-red-500 hover:bg-red-50 rounded-xl transition-colors" title="Hapus">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Logo live preview
    document.getElementById('logoInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = document.getElementById('logoPreview');
                img.src = evt.target.result;
                img.classList.remove('hidden');
                document.getElementById('logoPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Banner live preview
    document.getElementById('bannerInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = document.getElementById('bannerPreview');
                img.src = evt.target.result;
                img.classList.remove('hidden');
                document.getElementById('bannerPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Multiple photos live preview
    document.getElementById('photosInput').addEventListener('change', function(e) {
        const files = e.target.files;
        const container = document.getElementById('photosPreviewContainer');
        container.innerHTML = '';
        
        if (files.length > 0) {
            container.classList.remove('hidden');
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const div = document.createElement('div');
                    div.className = 'aspect-square rounded-lg overflow-hidden border border-slate-200 relative';
                    div.innerHTML = `<img src="${evt.target.result}" class="w-full h-full object-cover">`;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        } else {
            container.classList.add('hidden');
        }
    });

    // Toggle delete indicator overlay on existing photos
    function toggleDeletePhoto(checkbox) {
        const overlay = checkbox.closest('.relative').querySelector('.delete-overlay');
        if (checkbox.checked) {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            checkbox.closest('label').classList.replace('bg-red-500', 'bg-slate-500');
        } else {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            checkbox.closest('label').classList.replace('bg-slate-500', 'bg-red-500');
        }
    }

    // Pre-fill company name input and handle AJAX form submission
    document.addEventListener('DOMContentLoaded', function() {
        const companyNamePHP = "{{ $company->name }}";
        const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user'));
        const nameInput = document.getElementById('inputCompanyName');

        if (!companyNamePHP && user && user.company_name) {
            if (nameInput) {
                nameInput.value = user.company_name;
            }
        }

        // Intercept form submission
        const form = document.getElementById('editProfileForm');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitBtn = document.querySelector('button[form="editProfileForm"]');
                if (submitBtn) submitBtn.disabled = true;

                const formData = new FormData(form);
                if (user && user.email) {
                    formData.append('user_email', user.email);
                }

                const token = localStorage.getItem('token') || sessionStorage.getItem('token');

                try {
                    const response = await fetch(form.action, {
                        method: 'POST', // Uses _method: PUT from the form fields
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Update local cache
                        if (user) {
                            user.company_name = nameInput.value;
                            const storage = localStorage.getItem('token') ? localStorage : sessionStorage;
                            storage.setItem('user', JSON.stringify(user));
                        }

                        alert('Profil perusahaan berhasil diperbarui.');
                        window.location.href = "{{ route('company.profile') }}";
                    } else {
                        if (result.errors) {
                            const errMsgs = Object.values(result.errors).flat().join('\n');
                            alert(errMsgs);
                        } else {
                            alert(result.message || 'Gagal memperbarui profil.');
                        }
                        if (submitBtn) submitBtn.disabled = false;
                    }
                } catch (err) {
                    console.error('Error submitting form:', err);
                    alert('Terjadi kesalahan koneksi atau server.');
                    if (submitBtn) submitBtn.disabled = false;
                }
            });
        }
    });
</script>
@endsection
