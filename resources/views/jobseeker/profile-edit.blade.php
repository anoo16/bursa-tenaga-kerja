@extends('layouts.jobseeker')

@section('title', 'Edit Profile')

@vite([
    'resources/css/profile-edit.css',
    'resources/js/profile-edit.js'
])

@section('content')

{{-- BACKDROP --}}
<div class="profile-modal-overlay">

    {{-- MODAL --}}
    <div class="profile-modal">

        <button class="modal-close">
            <i class='bx bx-x'></i>
        </button>

<div class="edit-profile-page">

    <div class="edit-card">

        <h1>Edit Profile</h1>

        <form method="POST"
              action="{{ route('profile.update') }}"
              enctype="multipart/form-data">

            @csrf

            {{-- FOTO PROFILE --}}
            <div class="form-group">

                <label>Foto Profile</label>

                <input type="file"
                       name="photo">

            </div>

            {{-- NAMA --}}
            <div class="form-group">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       value="{{ $user->name ?? '' }}">

            </div>

            {{-- HEADLINE --}}
            <div class="form-group">

                <label>Professional Headline</label>

                <input type="text"
                       name="headline"
                       placeholder="UI/UX Designer | Frontend Developer"
                       value="{{ $user->headline ?? '' }}">

            </div>

            {{-- LOKASI --}}
            <div class="form-group">

                <label>Lokasi</label>

                <input type="text"
                       name="location"
                       value="{{ $user->location ?? '' }}">

            </div>

            {{-- EMAIL --}}
            <div class="form-group">

                <label>Email</label>

                <input type="email"
                       name="email"
                       value="{{ $user->email ?? '' }}">

            </div>

            {{-- RINGKASAN --}}
            <div class="form-group">

                <label>Ringkasan Professional</label>

                <textarea name="summary"
                          rows="5"
                          placeholder="Ceritakan tentang diri anda...">{{ $user->summary ?? '' }}</textarea>

            </div>

            {{-- PENGALAMAN --}}
            <div class="form-group">

                <label>Pengalaman Kerja</label>

                <textarea name="experience"
                          rows="5"
                          placeholder="Masukkan pengalaman kerja...">{{ $user->experience ?? '' }}</textarea>

            </div>

            {{-- KEAHLIAN --}}
            <div class="form-group">

                <label>Keahlian & Kompetensi</label>

                <textarea name="skills"
                          rows="4"
                          placeholder="Contoh: Figma, UI/UX, Laravel">{{ $user->skills ?? '' }}</textarea>

            </div>

            {{-- SERTIFIKAT --}}
            <div class="form-group">

                <label>Sertifikat Keahlian</label>

                <textarea name="certification"
                          rows="4"
                          placeholder="Masukkan sertifikat yang dimiliki">{{ $user->certification ?? '' }}</textarea>

            </div>

            {{-- PENDIDIKAN --}}
            <div class="form-group">

                <label>Pendidikan</label>

                <textarea name="education"
                          rows="4"
                          placeholder="Riwayat pendidikan">{{ $user->education ?? '' }}</textarea>

            </div>

            <button class="save-btn"
                    type="submit">

                Simpan Perubahan

            </button>

        </form>

    </div>

</div>

    </div>
</div>

@endsection