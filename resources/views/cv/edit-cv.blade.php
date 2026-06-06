@extends('layouts.jobseeker')

@section('title','Edit CV')

@vite([
'resources/css/cv-wizard.css',
'resources/js/cv-wizard.js'
])

@section('content')

    <div class="cv-wizard">

        <div class="wizard-topbar">

            <div class="wizard-header">

                <a href="{{ route('profile') }}" class="wizard-back">
                     <i class='bx bx-arrow-back'></i>
                        KEMBALI
                </a>

                <div class="wizard-status">
                    <span class="saved-badge">
                        ✓ Tersimpan
                    </span>

                    <span id="progressText">
                        Progress: 0%
                    </span>

                    <div class="progress-bar">
                        <div id="progressFill"></div>
                    </div>
                </div>

            </div>

            <div class="wizard-progress">

                <div class="wizard-step active">
                    <span class="step-circle">1</span>
                    <span>Profile</span>
                </div>

                <div class="wizard-line"></div>

                <div class="wizard-step">
                    <span class="step-circle">2</span>
                    <span>Pendidikan</span>
                </div>

                <div class="wizard-line"></div>

                <div class="wizard-step">
                    <span class="step-circle">3</span>
                    <span>Skill</span>
                </div>

                <div class="wizard-line"></div>

                <div class="wizard-step">
                    <span class="step-circle">4</span>
                    <span>Tentang Saya</span>
                </div>

                <div class="wizard-line"></div>

                <div class="wizard-step">
                    <span class="step-circle">5</span>
                    <span>Pengalaman</span>
                </div>

            </div>

        </div>

    </div>

    {{-- CONTENT --}}
    <div class="wizard-content">

        <small>
            STEP
            <span id="stepCounter">
                01 / 05
            </span>
        </small>

        <h1 id="stepTitle">
            Personal Biodata
        </h1>

        <p>
            Lengkapi informasi CV
        </p>

<form
action="{{ route('cv.update') }}"
method="POST"
id="cvForm"
enctype="multipart/form-data"
>

@csrf
@method('PUT')

<input
    type="hidden"
    name="user_id"
    id="user_id"
>

<input
    type="hidden"
    name="template_id"
    value="{{ session('selected_cv_template', $profile?->template_id) }}"
>

{{-- STEP 1 PROFILE --}}
<div class="step-content active">

<div class="form-grid-2">

<input
type="text"
name="full_name"
class="form-input"
placeholder="Nama lengkap"
value="{{ old('full_name',$profile?->full_name) }}"
>


<input
type="email"
name="email"
class="form-input"
placeholder="Email"
value="{{ old('email',$profile?->email) }}"
>


<input
type="text"
name="phone"
class="form-input"
placeholder="Nomor HP"
value="{{ old('phone',$profile?->phone) }}"
>


<input
type="text"
name="location"
class="form-input"
placeholder="Alamat"
value="{{ old('location',$profile?->location) }}"
>

</div>

</div>



{{-- STEP 2 EDUCATION --}}
<div class="step-content">

    <div id="educationContainer">

        <div class="education-item">

            <div class="form-grid-2">

                <input type="text"
                    name="educations[0][school]"
                    class="form-input"
                    placeholder="Nama Sekolah / Universitas">

                <input type="text"
                    name="educations[0][major]"
                    class="form-input"
                    placeholder="Jurusan">

                <input type="text"
                    name="educations[0][start_year]"
                    class="form-input"
                    placeholder="Tahun Masuk">

                <input type="text"
                    name="educations[0][end_year]"
                    class="form-input"
                    placeholder="Tahun Lulus">

                <input type="text"
                    name="educations[0][gpa]"
                    class="form-input"
                    placeholder="IPK">

            </div>

        </div>

    </div>

    <div class="education-actions">

        <button
            type="button"
            class="btn-add"
            id="addEducation">

            <i class='bx bx-plus'></i>
            Tambah Pendidikan

        </button>

    </div>

</div>

{{-- STEP 3 SKILL --}}
<div class="step-content">

    <div id="skillContainer">

        <div class="skill-item">

            <input
                type="text"
                name="skills[0][name]"
                class="form-input"
                placeholder="Keahlian">

        </div>

    </div>

    <div class="section-actions">
        <button
            type="button"
            class="btn-add"
            id="addSkill">

            <i class='bx bx-plus'></i>
            Tambah Skill

        </button>
    </div>

</div>



{{-- STEP 4 SUMMARY + ORGANISASI --}}
<div class="step-content">

<h3>Tentang Saya</h3>

<textarea
class="form-textarea"
name="summary"
rows="6"
placeholder="Ceritakan tentang dirimu..."
>{{ old('summary',$profile?->summary) }}</textarea>


<br><br>

<h3>Pengalaman Organisasi</h3>

<div id="organizationList">

<textarea
name="organization"
class="form-textarea"
rows="5"
placeholder="Masukkan pengalaman organisasi"
></textarea>

</div>

</div>




{{-- STEP 5 EXPERIENCE --}}
<div class="step-content">

    <div id="experienceContainer">

        <div class="experience-item">

            <div class="form-grid-2">

                <input
                    type="text"
                    name="experiences[0][company]"
                    class="form-input"
                    placeholder="Nama Perusahaan">

                <input
                    type="text"
                    name="experiences[0][position]"
                    class="form-input"
                    placeholder="Posisi">

                <input
                    type="date"
                    name="experiences[0][start_date]"
                    class="form-input">

                <input
                    type="date"
                    name="experiences[0][end_date]"
                    class="form-input">

            </div>

            <textarea
                class="form-textarea"
                name="experiences[0][description]"
                rows="5"
                placeholder="Deskripsi pekerjaan"></textarea>

        </div>

    </div>

    <div class="section-actions">
        <button
            type="button"
            class="btn-add"
            id="addExperience">

            <i class='bx bx-plus'></i>
            Tambah Pengalaman

        </button>
    </div>

</div>

<div class="wizard-footer">

    <button
        type="button"
        id="prevBtn"
        class="btn-outline">
        ← Kembali
    </button>

    <button
        type="button"
        id="nextBtn"
        class="btn-primary">
        Lanjut →
    </button>

    {{-- tombol preview --}}
    <button
        type="button"
        id="previewBtn"
        class="btn-outline">
        Preview CV
    </button>

    <button
        type="submit"
        id="submitBtn"
        style="display:none"
        class="btn-primary">
        Simpan CV
    </button>

</div>

@endsection