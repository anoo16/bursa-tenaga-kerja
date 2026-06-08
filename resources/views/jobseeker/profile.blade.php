@extends('layouts.jobseeker')

@section('title', 'Profil Saya')

@vite([
    'resources/css/profile.css',
    'resources/js/profile.js'
])

@section('content')

<div class="profile-page">

    {{-- HEADER --}}
    <div class="profile-header-card">

        <div class="profile-header-left">

            <div class="profile-avatar-wrapper">

                <img 
                    src="{{ optional($user)->photo
                        ? asset('storage/'.$user->photo)
                        : asset('assets/profile.png') }}"
                    id="profile-photo"
                    alt="Profile"
                    class="profile-avatar">

                <div class="avatar-badge">
                    <i class='bx bx-pencil'></i>
                </div>

            </div>

            <div>

               <h2 class="profile-name">
                    {{ $user?->name ?? 'Nama User' }}
               </h2>

            </div>

        </div>

        <a href="{{ route('jobseeker.profile-edit') }}">
            <button class="btn-edit-profile">
                Edit Profile
            </button>
        </a>

    </div>

    {{-- GRID --}}
    <div class="profile-grid">

        {{-- LEFT --}}
        <div class="profile-left">

            {{-- Tentang Saya --}}
            <div class="card summary-card">

                <p
                    class="summary-text"
                    id="profile-summary"
                >
                    Belum ada ringkasan profesional
                </p>

            </div>

            {{-- Pengalaman --}}
            <div class="card">

                <div class="section-header">
                    <h3 class="section-title">
                        Pengalaman
                    </h3>
                </div>

                <div id="profile-experiences">
                    <p class="exp-desc">
                        Belum ada pengalaman kerja
                    </p>
                </div>

            </div>

            {{-- BOTTOM --}}
            <div class="bottom-row">

                {{-- Pendidikan --}}
                <div class="card">

                    <div class="section-header">
                        <h3 class="section-title">
                            Pendidikan
                        </h3>
                    </div>

                    <div id="profile-educations">
                        <p>Belum ada pendidikan</p>
                    </div>

                </div>

                {{-- CV --}}
                <div class="card credentials-card">

                    <div class="section-header">
                        <h3 class="section-title">
                            CV (Curriculum Vitae)
                        </h3>
                    </div>

                    <p class="credentials-hint">
                        Pastikan profil dan CV Anda selalu diperbarui.
                    </p>

                    <div class="credentials-actions">

                        <a
                            href="{{ route('cv.templates') }}"
                            class="btn-outline"
                        >
                            <i class='bx bx-layout'></i>
                            Edit CV
                        </a>

                    </div>

                </div>

            </div> {{-- END bottom-row --}}

            </div> {{-- END profile-left --}}


            {{-- RIGHT --}}
            <div class="profile-right">

                {{-- IDENTITAS --}}
                <div class="card identity-card">

                    <div class="identity-label">
                        Detail Identitas
                    </div>

                    <div class="identity-item">
                        <i class='bx bx-envelope'></i>

                        <span id="profile-email">
                            {{ $user?->email ?? 'Belum diisi' }}
                        </span>
                    </div>

                    <div class="identity-item">
                        <i class='bx bx-map'></i>

                        <span id="profile-location">
                            {{ $user?->location ?? 'Belum diisi' }}
                        </span>
                    </div>

                    <div class="identity-item">
                        <i class='bx bx-phone'></i>

                        <span id="profile-phone">
                            {{ $user?->phone ?? 'Belum diisi' }}
                        </span>
                    </div>

                    <div class="identity-item">
                        <i class='bx bxl-linkedin'></i>

                        <a
                            id="profile-linkedin"
                            href="#"
                            target="_blank"
                        >
                            LinkedIn
                        </a>
                    </div>

                    <div class="identity-item">
                        <i class='bx bxl-github'></i>

                        <a
                            id="profile-github"
                            href="#"
                            target="_blank"
                        >
                            GitHub
                        </a>
                    </div>

                </div> {{-- END identity-card --}}


                {{-- SERTIFIKASI --}}
                <div class="card sertifikasi-card">

                    <div class="section-header">

                        <div class="identity-label">
                            SERTIFIKASI
                        </div>

                    </div>

                    <ul
                        class="sertifikasi-list"
                        id="profile-certifications"
                    >
                        <li class="sertifikasi-item">
                            Belum ada sertifikasi
                        </li>
                    </ul>

                </div>


                {{-- KEAHLIAN --}}
                <div class="card">

                    <div class="section-header">

                        <h3 class="section-title">
                            Keahlian
                        </h3>

                    </div>

                    <div
                        class="skills-grid"
                        id="profile-skills"
                    >

                        <span class="skill-tag">
                            Belum ada skill
                        </span>

                    </div>

                </div>

</div> {{-- END profile-right --}}

</div> {{-- END profile-grid --}}

</div> {{-- END profile-page --}}
@endsection