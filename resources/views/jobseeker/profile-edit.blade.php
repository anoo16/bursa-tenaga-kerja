@extends('layouts.jobseeker')

@section('title', 'Edit Profile')

@vite([
    'resources/css/profile-edit.css',
    'resources/js/profile-edit.js'
])

@section('content')

<div class="profile-modal-overlay">

    <div class="profile-modal">

        {{-- MODAL HEADER --}}
        <div class="profile-modal-header">

            <div>
                <h2>Edit Profil Lengkap</h2>
                <p>Lengkapi informasi profesional Anda</p>
            </div>

            <button type="button" class="modal-close">
                <i class='bx bx-x'></i>
            </button>

        </div>

        <form id="profileForm" enctype="multipart/form-data">

            {{-- IDENTITAS --}}
            <section class="edit-section">

                <div class="section-heading">
                    <div class="section-icon">
                        <i class='bx bx-user'></i>
                    </div>

                    <h3>Identitas & Kontak</h3>
                </div>

                <div class="identity-layout">

                    <div class="avatar-area">

                        <img
                            id="profilePreview"
                            src="{{ asset('assets/profile.png') }}"
                            alt="Profile"
                            class="edit-avatar"
                        >

                        <label for="photoInput" class="avatar-edit">
                            <i class='bx bx-pencil'></i>
                        </label>

                        <input
                            type="file"
                            id="photoInput"
                            name="photo"
                            accept="image/*"
                            hidden
                        >

                    </div>

                    <div class="identity-fields">

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>

                        <div class="form-group">
                            <label>Headline Profesional</label>
                            <input
                                type="text"
                                name="headline"
                                placeholder="Contoh: UI/UX Designer"
                            >
                        </div>

                        <div class="form-group input-icon">
                            <label>Lokasi</label>
                            <div class="icon-input">
                                <i class='bx bx-map'></i>
                                <input
                                    type="text"
                                    name="location"
                                    placeholder="Contoh: Manado, Indonesia"
                                >
                            </div>
                        </div>

                        <div class="form-group input-icon">
                            <label>LinkedIn</label>

                            <div class="icon-input">
                                <i class='bx bxl-linkedin'></i>

                                <input
                                    type="url"
                                    name="linkedin"
                                    placeholder="https://linkedin.com/in/username"
                                >
                            </div>
                        </div>

                        <div class="form-group input-icon">
                            <label>GitHub</label>

                            <div class="icon-input">
                                <i class='bx bxl-github'></i>

                                <input
                                    type="url"
                                    name="github"
                                    placeholder="https://github.com/username"
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                placeholder="Masukkan email"
                            >
                        </div>

                        <div class="form-group">
                            <label>No Telepon</label>
                            <input
                                type="text"
                                name="phone"
                                placeholder="Masukkan nomor telepon"
                            >
                        </div>

                    </div>

                </div>

            </section>

            {{-- RINGKASAN --}}
            <section class="edit-section">

                <div class="section-heading">
                    <div class="section-icon">
                        <i class='bx bx-file'></i>
                    </div>

                    <h3>Ringkasan Profesional</h3>
                </div>

                <div class="form-group">
                    <label>Tentang Saya</label>

                    <textarea
                        name="summary"
                        id="summaryInput"
                        maxlength="500"
                        placeholder="Ceritakan tentang pengalaman dan keahlian profesional Anda..."
                    ></textarea>

                    <div class="char-count">
                        <span id="summaryCount">0</span>/500
                    </div>
                </div>

            </section>

            {{-- PENGALAMAN --}}
            <section class="edit-section">

                <div class="section-heading between">
                    <div class="section-title-inline">
                        <div class="section-icon">
                            <i class='bx bx-briefcase'></i>
                        </div>

                        <h3>Pengalaman Kerja</h3>
                    </div>

                    <button type="button" class="add-link" id="toggleExperienceForm">
                        + Tambah Posisi
                    </button>
                </div>

                <div class="inline-add-form" id="experienceFormBox">

                    <input type="text" id="expPosition" placeholder="Posisi / Jabatan">

                    <input type="text" id="expCompany" placeholder="Perusahaan / Organisasi">

                    <input type="text" id="expPeriod" placeholder="Periode, contoh: 2025 - Present">

                    <textarea id="expDescription" placeholder="Deskripsi pengalaman"></textarea>

                    <button type="button" class="btn-add-dynamic" id="addExperienceBtn">
                        Simpan Pengalaman
                    </button>

                </div>

                <div id="experienceList" class="dynamic-list"></div>

            </section>


            {{-- SKILLS --}}
            <section class="edit-section">

                <div class="section-heading">
                    <div class="section-icon">
                        <i class='bx bx-star'></i>
                    </div>

                    <h3>Keahlian & Kompetensi</h3>
                </div>

                <label class="sub-label">Cari & Tambah Keahlian</label>

                <div class="skills-box">

                    <div class="skills-tags" id="skillsList"></div>

                    <div class="skill-input-wrap">

                        <select
                            id="skillSelect"
                            class="skill-select"
                        >
                            <option value="">
                                Pilih Keahlian
                            </option>

                            <option>IT & Software</option>
                            <option>Data Science & AI</option>
                            <option>Cyber Security</option>
                            <option>Business & Management</option>
                            <option>Finance & Accounting</option>
                            <option>Marketing & Sales</option>
                            <option>Human Resources</option>
                            <option>Education</option>
                            <option>Healthcare</option>
                            <option>Engineering</option>
                            <option>Lainnya</option>
                        </select>

                        <button
                            type="button"
                            class="skill-add"
                            id="addSkillBtn"
                        >
                            <i class='bx bx-plus'></i>
                        </button>

                    </div>

                </div>

            </section>


            {{-- SERTIFIKAT --}}
            <section class="edit-section">

                <div class="section-heading between">
                    <div class="section-title-inline">
                        <div class="section-icon">
                            <i class='bx bx-award'></i>
                        </div>

                        <h3>Sertifikat Keahlian</h3>
                    </div>

                    <button type="button" class="add-link" id="toggleCertificationForm">
                        + Tambah Sertifikat
                    </button>
                </div>

                <div class="inline-add-form" id="certificationFormBox">

                    <input type="text" id="certTitle" placeholder="Nama sertifikat">

                    <input type="text" id="certIssuer" placeholder="Penerbit / Platform">

                    <input type="text" id="certYear" placeholder="Tahun / Bulan">

                    <button type="button" class="btn-add-dynamic" id="addCertificationBtn">
                        Simpan Sertifikat
                    </button>

                </div>

                <div id="certificationList" class="dynamic-list"></div>

            </section>


            {{-- PENDIDIKAN --}}
            <section class="edit-section">

                <div class="section-heading between">
                    <div class="section-title-inline">
                        <div class="section-icon">
                            <i class='bx bxs-graduation'></i>
                        </div>

                        <h3>Pendidikan</h3>
                    </div>

                    <button type="button" class="add-link" id="toggleEducationForm">
                        + Tambah Pendidikan
                    </button>
                </div>

                <div class="inline-add-form" id="educationFormBox">

                    <input type="text" id="eduLevel" placeholder="Jenjang, contoh: S1">

                    <input type="text" id="eduMajor" placeholder="Jurusan">

                    <input type="text" id="eduSchool" placeholder="Sekolah / Universitas">

                    <input type="text" id="eduYear" placeholder="Tahun lulus">

                    <button type="button" class="btn-add-dynamic" id="addEducationBtn">
                        Simpan Pendidikan
                    </button>

                </div>

                <div id="educationList" class="dynamic-list"></div>

            </section>

            {{-- FOOTER --}}
            <div class="modal-footer">

                <button type="button" class="btn-cancel modal-close-secondary">
                    Batal
                </button>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection