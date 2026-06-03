@extends('layouts.recruiter')

@section('content')
<style>
/* ══ BASE ══ */
* { box-sizing: border-box; }
.rp-wrap {
    padding: 2rem 2.5rem 3rem;
    background: #FEF9F2;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* ══ BACK BUTTON ══ */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #3E4948;
    text-decoration: none;
    margin-bottom: 0.6rem;
}
.btn-back:hover { color: #1C4D8D; }

/* ══ PAGE HEADING ══ */
.rp-heading {
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    font-size: 1.9rem;
    font-weight: 700;
    color: #1D1C18;
    margin-bottom: 1.6rem;
}

/* ══ LAYOUT GRID ══ */
.rp-grid {
    display: grid;
    grid-template-columns: 1fr 412px;
    gap: 1.6rem;
    align-items: start;
}

/* ══ LEFT COLUMN ══ */

/* Hero card */
.rp-hero {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(9,107,104,0.08);
    padding: 2rem 2.2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.4rem;
}
.rp-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
    background: #e8ecf5;
    box-shadow: 0 0 0 3px rgba(144,209,202,0.25);
}
.rp-hero-info h2 {
    font-size: 1.55rem;
    font-weight: 700;
    color: #1C4D8D;
    margin: 0 0 0.2rem;
}
.rp-hero-info .rp-job-applied {
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.4rem;
}
.rp-hero-info .rp-job-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1D1C18;
}

/* section card */
.rp-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(9,107,104,0.08);
    padding: 2rem 2.2rem;
    margin-bottom: 1.4rem;
}
.rp-section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1C4D8D;
    margin: 0 0 1.4rem;
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
}

/* Timeline */
.rp-timeline { position: relative; padding-left: 2.5rem; }
.rp-timeline::before {
    content: '';
    position: absolute;
    left: 0.45rem;
    top: 0.5rem;
    bottom: 0.5rem;
    width: 1px;
    background: #E6E2DB;
}
.rp-timeline-item {
    position: relative;
    margin-bottom: 2rem;
}
.rp-timeline-item:last-child { margin-bottom: 0; }
.rp-timeline-dot {
    position: absolute;
    left: -2.1rem;
    top: 0.35rem;
    width: 14px;
    height: 14px;
    background: #1C4D8D;
    border: 3px solid #fff;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(9,107,104,0.15);
}
.rp-timeline-dot.inactive {
    background: #E6E2DB;
    width: 8px;
    height: 8px;
    left: -1.8rem;
    top: 0.5rem;
}
.rp-tl-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.2rem;
}
.rp-tl-company {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1D1C18;
}
.rp-tl-period {
    background: rgba(189,232,245,0.63);
    color: #0F2854;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    white-space: nowrap;
}
.rp-tl-position {
    font-size: 0.85rem;
    font-weight: 700;
    color: #0F2854;
    margin-bottom: 0.4rem;
}
.rp-tl-desc {
    font-size: 0.85rem;
    color: #6B7280;
    line-height: 1.6;
}

/* Skills canvas */
.rp-skills-wrap {
    background: #F8F3EC;
    border-radius: 24px;
    padding: 2rem 2.2rem;
    margin-bottom: 1.4rem;
}
.rp-skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    margin-top: 0.4rem;
}
.rp-skill-chip {
    background: #fff;
    border-radius: 999px;
    padding: 0.45rem 1.1rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: #1D1C18;
    box-shadow: 0 4px 12px rgba(9,107,104,0.08);
}

/* Education card */
.rp-edu-item {
    margin-bottom: 1.2rem;
    padding-bottom: 1.2rem;
    border-bottom: 1px solid #F8F3EC;
}
.rp-edu-item:last-child { margin-bottom: 0; border-bottom: none; padding-bottom: 0; }
.rp-edu-level {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #0F2854;
    margin-bottom: 0.25rem;
}
.rp-edu-major {
    font-size: 1rem;
    font-weight: 700;
    color: #1D1C18;
    margin-bottom: 0.15rem;
}
.rp-edu-school {
    font-size: 0.85rem;
    color: #6B7280;
}

/* ══ RIGHT SIDEBAR ══ */

/* Contact card */
.rp-contact-card {
    background: #FFFBDE;
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 1.2rem;
}
.rp-card-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(28,77,141,0.69);
    margin-bottom: 1rem;
}
.rp-contact-item {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    margin-bottom: 0.9rem;
    font-size: 0.9rem;
    color: #1D1C18;
}
.rp-contact-item:last-child { margin-bottom: 0; }
.rp-contact-icon {
    color: #1C4D8D;
    flex-shrink: 0;
}

/* Certifications card */
.rp-cert-item {
    font-size: 0.88rem;
    font-weight: 500;
    color: #1D1C18;
    line-height: 1.55;
    margin-bottom: 0.9rem;
    padding-bottom: 0.9rem;
    border-bottom: 1px solid rgba(28,77,141,0.08);
}
.rp-cert-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

/* Action sidebar */
.rp-action-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(9,107,104,0.08);
    padding: 2rem;
    margin-bottom: 1.2rem;
}

/* Status update form */
.rp-status-label {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #3E4948;
    margin-bottom: 1rem;
}
.rp-select {
    width: 100%;
    padding: 0.7rem 1rem;
    border-radius: 10px;
    border: 1.5px solid rgba(15,40,84,0.18);
    font-size: 0.88rem;
    color: #1D1C18;
    background: #fff;
    margin-bottom: 1rem;
    outline: none;
    cursor: pointer;
}
.rp-select:focus { border-color: #1C4D8D; }

/* Buttons */
.btn-primary-full {
    width: 100%;
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 0.9rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    text-decoration: none;
    margin-bottom: 0.8rem;
    transition: opacity 0.2s;
}
.btn-primary-full:hover { opacity: 0.9; color: #fff; }

.btn-outline-full {
    width: 100%;
    background: #fff;
    color: #1C4D8D;
    border: 2px solid rgba(15,40,84,0.2);
    border-radius: 12px;
    padding: 0.85rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    text-decoration: none;
    margin-bottom: 0.8rem;
    transition: border-color 0.2s;
}
.btn-outline-full:hover { border-color: #1C4D8D; color: #1C4D8D; }

.btn-danger-full {
    width: 100%;
    background: #fff;
    color: #BA1A1A;
    border: 2px solid rgba(186,26,26,0.15);
    border-radius: 12px;
    padding: 0.85rem 1.5rem;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    transition: border-color 0.2s;
}
.btn-danger-full:hover { border-color: #BA1A1A; }

/* Status badge */
.rp-status-badge {
    display: inline-block;
    padding: 0.3rem 0.9rem;
    border-radius: 999px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.badge-baru      { border: 1.5px solid #0B6E69; color: #0B6E69; }
.badge-review    { background: #eef2ff; color: #3730a3; }
.badge-interview { background: #fef3cd; color: #a07000; }
.badge-diterima  { background: #1a3570; color: #fff; }
.badge-ditolak   { background: #fde8e8; color: #c0392b; }

/* Empty state */
.rp-empty {
    color: #9aa3b8;
    font-size: 0.88rem;
    font-style: italic;
    padding: 0.5rem 0;
}

/* Alert success */
.rp-alert-success {
    background: #d1fae5;
    border: 1px solid #6ee7b7;
    color: #065f46;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

@media (max-width: 900px) {
    .rp-grid { grid-template-columns: 1fr; }
}
</style>

<div class="rp-wrap">

    {{-- BACK --}}
    <a href="{{ route('company.applicants') }}" class="btn-back">
        <svg width="9" height="9" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="3">
            <polyline points="15 18 9 12 15 6"/>
        </svg>
        Kembali ke Pelamar Masuk
    </a>

    {{-- HEADING --}}
    <h1 class="rp-heading">Review Profil Kandidat</h1>

    @if(session('success'))
        <div class="rp-alert-success">{{ session('success') }}</div>
    @endif

    <div class="rp-grid">

        {{-- ═══════════════ LEFT COLUMN ═══════════════ --}}
        <div>

            {{-- HERO --}}
            <div class="rp-hero">
                <img src="{{ $application->user->photo
                    ? asset('storage/'.$application->user->photo)
                    : 'https://ui-avatars.com/api/?name='.urlencode($application->user->name).'&size=72&background=e8ecf5&color=1C4D8D' }}"
                    alt="{{ $application->user->name }}"
                    class="rp-avatar"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($application->user->name) }}&size=72&background=e8ecf5&color=1C4D8D'">

                <div class="rp-hero-info">
                    <h2>{{ $application->user->name }}</h2>
                    <div class="rp-job-applied">Melamar untuk</div>
                    <div class="rp-job-name">{{ $application->job->posisi }}</div>
                </div>

                <div style="margin-left:auto;">
                    @php
                        $statusClass = match($application->status) {
                            'BARU'      => 'badge-baru',
                            'REVIEW'    => 'badge-review',
                            'INTERVIEW' => 'badge-interview',
                            'DITERIMA'  => 'badge-diterima',
                            'DITOLAK'   => 'badge-ditolak',
                            default     => 'badge-baru',
                        };
                    @endphp
                    <span class="rp-status-badge {{ $statusClass }}">
                        {{ $application->status }}
                    </span>
                </div>
            </div>

            {{-- EXPERIENCE --}}
            <div class="rp-card">
                <div class="rp-section-title">Experience</div>

                @if($application->user->experiences && $application->user->experiences->isNotEmpty())
                    <div class="rp-timeline">
                        @foreach($application->user->experiences as $i => $exp)
                        <div class="rp-timeline-item">
                            <div class="rp-timeline-dot {{ $i > 0 ? 'inactive' : '' }}"></div>
                            <div class="rp-tl-header">
                                <div class="rp-tl-company">{{ $exp->company }}</div>
                                @if($exp->period)
                                    <span class="rp-tl-period">{{ $exp->period }}</span>
                                @endif
                            </div>
                            @if($exp->position)
                                <div class="rp-tl-position">{{ $exp->position }}</div>
                            @endif
                            @if($exp->description)
                                <div class="rp-tl-desc">{{ $exp->description }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="rp-empty">Belum ada data pengalaman kerja.</p>
                @endif
            </div>

            {{-- SKILLS --}}
            <div class="rp-skills-wrap">
                <div class="rp-section-title" style="color:#1C4D8D;">Expertise</div>
                @if($application->user->skills && $application->user->skills->isNotEmpty())
                    <div class="rp-skills-list">
                        @foreach($application->user->skills as $skill)
                            <span class="rp-skill-chip">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="rp-empty">Belum ada data skill.</p>
                @endif
            </div>

            {{-- EDUCATION --}}
            <div class="rp-card">
                <div class="rp-section-title">Education</div>
                @if($application->user->educations && $application->user->educations->isNotEmpty())
                    @foreach($application->user->educations as $edu)
                    <div class="rp-edu-item">
                        <div class="rp-edu-level">{{ $edu->level }}</div>
                        <div class="rp-edu-major">{{ $edu->major }}</div>
                        <div class="rp-edu-school">
                            {{ $edu->school }}
                            @if($edu->graduation_year)
                                &bull; {{ $edu->graduation_year }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="rp-empty">Belum ada data pendidikan.</p>
                @endif
            </div>

        </div>

        {{-- ═══════════════ RIGHT SIDEBAR ═══════════════ --}}
        <div>

            {{-- ACTION CARD: UPDATE STATUS --}}
            <div class="rp-action-card">
                <div class="rp-status-label">Tindakan Rekruter</div>

                <form action="{{ route('company.applicant.update-status', $application->id) }}"
                      method="POST">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="rp-select">
                        @foreach(['BARU','REVIEW','INTERVIEW','DITERIMA','DITOLAK'] as $s)
                            <option value="{{ $s }}"
                                {{ $application->status === $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary-full">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Simpan Status
                    </button>
                </form>

                <a href="mailto:{{ $application->user->email }}"
                   class="btn-outline-full">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                        <polyline points="22,6 12,13 2,6"/>
                    </svg>
                    Kirim Email
                </a>

                <form action="{{ route('company.applicant.update-status', $application->id) }}"
                      method="POST" style="margin:0;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="DITOLAK">
                    <button type="submit" class="btn-danger-full"
                            onclick="return confirm('Tolak lamaran ini?')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6"  y1="6" x2="18" y2="18"/>
                        </svg>
                        Tolak Lamaran
                    </button>
                </form>
            </div>

            {{-- IDENTITY / CONTACT --}}
            <div class="rp-contact-card">
                <div class="rp-card-label">Identity Details</div>
                <div class="rp-contact-item">
                    <span class="rp-contact-icon">
                        <svg width="16" height="13" viewBox="0 0 24 20" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </span>
                    <span>{{ $application->user->email }}</span>
                </div>
                @if($application->user->phone)
                <div class="rp-contact-item">
                    <span class="rp-contact-icon">
                        <svg width="14" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.59 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 5.61 5.61l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </span>
                    <span>{{ $application->user->phone }}</span>
                </div>
                @endif
                @if($application->user->location)
                <div class="rp-contact-item">
                    <span class="rp-contact-icon">
                        <svg width="14" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                    </span>
                    <span>{{ $application->user->location }}</span>
                </div>
                @endif
                <div class="rp-contact-item">
                    <span class="rp-contact-icon">
                        <svg width="14" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </span>
                    <span>Melamar {{ $application->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>

            {{-- SERTIFIKASI --}}
            @if($application->user->certifications && $application->user->certifications->isNotEmpty())
            <div class="rp-contact-card">
                <div class="rp-card-label">Sertifikasi</div>
                @foreach($application->user->certifications as $cert)
                    <div class="rp-cert-item">{{ $cert->title }}</div>
                @endforeach
            </div>
            @endif

        </div>

    </div>
</div>
@endsection