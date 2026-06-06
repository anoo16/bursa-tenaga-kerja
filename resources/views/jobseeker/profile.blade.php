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

                <img src="{{ asset('assets/profile.png') }}"
                    id="profile-photo"
                    alt="Profile"
                    class="profile-avatar">

                <div class="avatar-badge">
                    <i class='bx bx-pencil'></i>
                </div>

            </div>

            <div>

                <h2 class="profile-name" id="profile-name">
                    Bryan Larumunde
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

                <p class="summary-text" id="profile-summary">
                    I am a first semester student studying at Sam Ratulangi University...
                </p>

            </div>

            {{-- Pengalaman --}}
            <div class="card">

                <div class="section-header">

                    <h3 class="section-title">
                        Pengalaman
                    </h3>

                </div>

                @if($user)

                    @forelse($user->experiences as $experience)

                        <div class="experience-item">

                            <div class="exp-header">

                                <h4 class="exp-org">
                                    {{ $experience->company }}
                                </h4>

                                <span class="exp-period">
                                    {{ $experience->period }}
                                </span>

                            </div>

                            <div class="exp-role">
                                {{ $experience->position }}
                            </div>

                            <p class="exp-desc">
                                {{ $experience->description }}
                            </p>

                        </div>

                    @empty

                        <p class="exp-desc">
                            Belum ada pengalaman kerja
                        </p>

                    @endforelse

                @else

                    {{-- DUMMY UI --}}
                    <div class="experience-item">

                        <div class="exp-header">

                            <h4 class="exp-org">
                                Himpunan Sistem Informasi
                            </h4>

                            <span class="exp-period">
                                2025 — 2026
                            </span>

                        </div>

                        <div class="exp-role">
                            Kepala Departemen Multimedia & Jurnalistik
                        </div>

                        <p class="exp-desc">
                            Mengelola media sosial dan publikasi organisasi.
                        </p>

                    </div>

                @endif

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

                    @if($user)

                        @forelse($user->educations as $education)

                            <div class="edu-item">

                                <div class="edu-level">
                                    {{ strtoupper($education->level) }}
                                </div>

                                <div class="edu-major">
                                    {{ $education->major }}
                                </div>

                                <div class="edu-school">
                                    {{ $education->school }}
                                    •
                                    {{ $education->graduation_year }}
                                </div>

                            </div>

                        @empty

                            <p>Belum ada pendidikan</p>

                        @endforelse

                    @else

                        {{-- DUMMY UI --}}
                        <div class="edu-item">

                            <div class="edu-level">
                                BACHELORS DEGREE
                            </div>

                            <div class="edu-major">
                                Information System
                            </div>

                            <div class="edu-school">
                                Unsrat • 2027
                            </div>

                        </div>

                    @endif

                </div>

                {{-- CV --}}
                <div class="card credentials-card">

                    <div class="section-header">

                        <h3 class="section-title">
                            CV(Curiculum Vitae)
                        </h3>

                    </div>

                    <p class="credentials-hint">
                        Pastikan profil dan CV Anda selalu diperbarui.
                    </p>

                    <div class="credentials-actions">

                        {{-- PILIH TEMPLATE --}}
                        <a href="{{ route('cv.templates') }}"
                        class="btn-outline">

                            <i class='bx bx-layout'></i>
                            Edit CV

                        </a>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="profile-right">

            {{-- IDENTITAS --}}
            <div class="card identity-card">

                <div class="identity-label">
                    Detai Identitas
                </div>

                <div class="identity-item">

                    <i class='bx bx-envelope'></i>

                    <span id="profile-email">
                    </span>

                </div>

                <div class="identity-item">

                    <i class='bx bx-map'></i>

                    <span id="profile-location">
                        Manado, Sulawesi Utara
                    </span>

                </div>

            </div>

            @if($user?->linkedin)

            <div class="identity-item">

                <i class='bx bxl-linkedin'></i>

                <a href="{{ $user->linkedin }}"
                target="_blank">
                    LinkedIn
                </a>

            </div>

            @endif


            @if($user?->github)

            <div class="identity-item">

                <i class='bx bxl-github'></i>

                <a href="{{ $user->github }}"
                target="_blank">
                    GitHub
                </a>

            </div>

            @endif

            {{-- SERTIFIKASI --}}
            <div class="card sertifikasi-card">

                <div class="section-header">

                    <div class="identity-label">
                        SERTIFIKASI
                    </div>

                </div>

                <ul class="sertifikasi-list">

                    @if($user)

                        @forelse($user->certifications as $certification)

                            <li class="sertifikasi-item">
                                {{ $certification->title }}
                            </li>

                        @empty

                            <li class="sertifikasi-item">
                                Belum ada sertifikasi
                            </li>

                        @endforelse

                    @else

                        {{-- DUMMY UI --}}
                        <li class="sertifikasi-item">
                            Sertifikasi Junior Cyber Security
                        </li>

                    @endif

                </ul>

            </div>

            {{-- KEAHLIAN --}}
            <div class="card">

                <div class="section-header">

                    <h3 class="section-title">
                        Keahlian
                    </h3>

                </div>

                <div class="skills-grid">

                    @if($user)

                        @forelse($user->skills as $skill)

                            <span class="skill-tag">
                                {{ $skill->name }}
                            </span>

                        @empty

                            <span class="skill-tag">
                                Belum ada skill
                            </span>

                        @endforelse

                    @else

                        {{-- DUMMY UI --}}
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">React.js</span>
                        <span class="skill-tag">UI/UX</span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const user = JSON.parse(
        localStorage.getItem('user')
    );

    if(!user) return;

    // nama
    const profileName =
        document.getElementById('profile-name');

    if(profileName){
        profileName.textContent = user.name;
    }

    // email
    const profileEmail =
        document.getElementById('profile-email');

    if(profileEmail){
        profileEmail.textContent = user.email;
    }

    // lokasi
    const profileLocation =
        document.getElementById('profile-location');

    if(profileLocation && user.location){
        profileLocation.textContent =
            user.location;
    }

    // summary
    const profileSummary =
        document.getElementById('profile-summary');

    if(profileSummary && user.summary){
        profileSummary.textContent =
            user.summary;
    }

    // photo
    const profilePhoto =
        document.getElementById('profile-photo');

    if(profilePhoto && user.photo){
        profilePhoto.src =
            '/storage/' + user.photo;
    }

});
</script>

@endsection