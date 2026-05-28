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

                <img src="{{ $user && $user->photo
                    ? asset('storage/' . $user->photo)
                    : asset('assets/profile.png') }}"
                    alt="Profile"
                    class="profile-avatar">

                <div class="avatar-badge">
                    <i class='bx bx-pencil'></i>
                </div>

            </div>

            <div>

                <h2 class="profile-name">
                    {{ $user ? $user->name : 'Bryan Larumunde' }}
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

            {{-- SUMMARY --}}
            <div class="card summary-card">

                <p class="summary-text">
                    {{ $user && $user->summary
                        ? $user->summary
                        : 'I am a first semester student studying at Sam Ratulangi University majoring in Information Systems, with experience in project management and strategy development.' }}
                </p>

            </div>

            {{-- EXPERIENCE --}}
            <div class="card">

                <div class="section-header">

                    <h3 class="section-title">
                        Experience
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

                {{-- EDUCATION --}}
                <div class="card">

                    <div class="section-header">

                        <h3 class="section-title">
                            Education
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
                            Credentials & CV
                        </h3>

                    </div>

                    <p class="credentials-hint">
                        Keep your professional profile and CV up to date.
                    </p>

                    <div class="credentials-actions">

                        {{-- EDIT CV --}}
                        <a href="{{ route('cv.edit') }}"
                        class="btn-primary">

                            <i class='bx bx-edit'></i>
                            Edit CV

                        </a>

                        {{-- PILIH TEMPLATE --}}
                        <a href="{{ route('cv.templates') }}"
                        class="btn-outline">

                            <i class='bx bx-layout'></i>
                            Template CV

                        </a>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="profile-right">

            {{-- IDENTITY --}}
            <div class="card identity-card">

                <div class="identity-label">
                    IDENTITY DETAILS
                </div>

                <div class="identity-item">

                    <i class='bx bx-envelope'></i>

                    {{ $user
                        ? $user->email
                        : 'bryanlarumunde17@gmail.com' }}

                </div>

                <div class="identity-item">

                    <i class='bx bx-map'></i>

                    {{ $user && $user->location
                        ? $user->location
                        : 'Manado, Sulawesi Utara' }}

                </div>

            </div>

            {{-- CERTIFICATION --}}
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

            {{-- SKILLS --}}
            <div class="card">

                <div class="section-header">

                    <h3 class="section-title">
                        Expertise
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

@endsection