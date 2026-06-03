@extends('layouts.recruiter')

@section('content')

<style>
/* ══ BASE ══ */
.pm-wrap {
    padding: 1.8rem 2.5rem 3rem;
    background: #f4f5f0;
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
}

/* ══ PAGE HEADER ══ */
.pm-title {
    font-size: 1.9rem;
    font-weight: 800;
    color: #1a3570;
    font-style: italic;
    margin-bottom: 0.3rem;
}
.pm-subtitle {
    color: #7a8599;
    font-size: 0.88rem;
    line-height: 1.5;
    margin-bottom: 1.4rem;
    max-width: 420px;
}

/* ══ FILTER ROW ══ */
.filter-row {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.7rem;
    margin-bottom: 1.3rem;
    margin-top: -2.8rem;
}
.btn-allapps {
    background: #e8e06a;
    border: none;
    border-radius: 8px;
    padding: 0.42rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 700;
    color: #3a3a1a;
    cursor: pointer;
}
.btn-advfilter {
    background: #fff;
    border: 1.5px solid #d0d5e3;
    border-radius: 8px;
    padding: 0.42rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: #4a5568;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

/* ══ STAT CARDS ══ */
.stat-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1.6rem;
}
.stat-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 1.3rem 1.5rem;
}
.stat-lbl {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    color: #9aa3b8;
    margin-bottom: 0.5rem;
}
.stat-num-row {
    display: flex;
    align-items: baseline;
    gap: 0.6rem;
}
.stat-num {
    font-size: 2.1rem;
    font-weight: 800;
    color: #1a2b4a;
    line-height: 1;
}
.stat-delta {
    font-size: 0.75rem;
    font-weight: 700;
    color: #2ecc71;
}

/* ══ CANDIDATE CARDS ══ */
.cand-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    padding: 1.1rem 1.5rem;
    margin-bottom: 0.9rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    border-left: 5px solid transparent;
    position: relative;
    overflow: hidden;
}
.cand-card.border-blue   { border-left-color: #1a3570; }
.cand-card.border-yellow { border-left-color: #e8c82a; }
.cand-card.border-grey   { border-left-color: #d0d5e3; }
.cand-card.border-navy   { border-left-color: #1a3570; }

/* photo */
.cand-photo-wrap {
    position: relative;
    flex-shrink: 0;
}
.cand-photo {
    width: 58px;
    height: 58px;
    border-radius: 12px;
    object-fit: cover;
    display: block;
    background: #e8ecf5;
}
.verified-dot {
    position: absolute;
    bottom: -2px;
    right: -2px;
    width: 18px;
    height: 18px;
    background: #1a3570;
    border-radius: 50%;
    border: 2px solid #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}
.verified-dot svg { display: block; }

/* name block */
.cand-name-block { min-width: 140px; flex-shrink: 0; }
.cand-name {
    font-size: 1rem;
    font-weight: 800;
    color: #1a2b4a;
    margin-bottom: 0.1rem;
    white-space: nowrap;
}
.cand-name.muted { color: #9aa3b8; }
.cand-role {
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #9aa3b8;
    line-height: 1.3;
}

/* applied for */
.applied-block { flex: 1; min-width: 0; }
.applied-lbl {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #b0b8cb;
    margin-bottom: 0.18rem;
}
.applied-pos {
    font-size: 0.92rem;
    font-weight: 700;
    color: #1a2b4a;
    margin-bottom: 0.1rem;
}
.applied-time {
    font-size: 0.78rem;
    color: #9aa3b8;
}

/* stage */
.stage-block { min-width: 130px; flex-shrink: 0; }
.stage-lbl {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #b0b8cb;
    margin-bottom: 0.35rem;
}
.sbadge {
    display: inline-block;
    padding: 0.28rem 0.85rem;
    border-radius: 999px;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
}
.sbadge-new          { border: 1.5px solid #0B6E69; color: #0B6E69; background: transparent; }
.sbadge-interviewing { background: #fef3cd; color: #a07000; border: none; }
.sbadge-rejected     { background: #fde8e8; color: #c0392b; border: none; }
.sbadge-offer        { background: #1a3570; color: #fff; border: none; }

/* action icons */
.action-icons {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    flex-shrink: 0;
    color: #9aa3b8;
}
.action-icons svg { cursor: pointer; transition: color .15s; }
.action-icons svg:hover { color: #1a3570; }

/* action button */
.btn-review {
    background: #1a3570;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 0.55rem 1.2rem;
    font-size: 0.83rem;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s;
    flex-shrink: 0;
    text-decoration: none;
    display: inline-block;
}
.btn-review:hover { background: #12296a; color: #fff; }
.btn-outline-action {
    background: #fff;
    color: #1a2b4a;
    border: 1.5px solid #d0d5e3;
    border-radius: 10px;
    padding: 0.52rem 1.1rem;
    font-size: 0.83rem;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    flex-shrink: 0;
    text-decoration: none;
    display: inline-block;
    transition: border-color .15s;
}
.btn-outline-action:hover { border-color: #1a3570; color: #1a3570; }

/* ══ PAGINATION ══ */
.pagination-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1.2rem;
}
.showing-text {
    font-size: 0.8rem;
    color: #9aa3b8;
}
.pag-btns {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
.pag-btn {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1.5px solid #d0d5e3;
    background: #fff;
    font-size: 0.85rem;
    font-weight: 600;
    color: #4a5568;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .15s;
}
.pag-btn:hover { border-color: #1a3570; color: #1a3570; }
.pag-btn.active { background: #1a3570; color: #fff; border-color: #1a3570; }
.pag-arrow {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: 1.5px solid #d0d5e3;
    background: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a5568;
    transition: all .15s;
}
.pag-arrow:hover { border-color: #1a3570; color: #1a3570; }

/* Responsive */
@media (max-width: 768px) {
    .stat-row { grid-template-columns: repeat(2,1fr); }
    .cand-card { flex-wrap: wrap; }
    .pm-wrap { padding: 1rem; }
    .filter-row { margin-top: 0; justify-content: flex-start; }
}
</style>

<div class="pm-wrap">

    {{-- PAGE TITLE --}}
    <h1 class="pm-title">Pelamar Masuk</h1>
    <p class="pm-subtitle">
        Manage incoming talent and advance candidates through your<br>
        recruitment dashboard.
    </p>

    {{-- FILTER ROW --}}
    <div class="filter-row">
        <button class="btn-allapps">All Apps</button>
        <button class="btn-advfilter">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5">
                <line x1="4" y1="6"  x2="20" y2="6"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
                <line x1="11" y1="18" x2="13" y2="18"/>
            </svg>
            Advanced Filters
        </button>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-lbl">New</div>
            <div class="stat-num-row">
                <span class="stat-num">{{ $newCount }}</span>
                <span class="stat-delta"></span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-lbl">Interviewing</div>
            <div class="stat-num-row">
                <span class="stat-num">{{ $interviewCount }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-lbl">Hired</div>
            <div class="stat-num-row">
                <span class="stat-num">{{ $acceptedCount }}</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-lbl">Rejected</div>
            <div class="stat-num-row">
                <span class="stat-num">{{ $rejectedCount }}</span>
            </div>
        </div>
    </div>



    @foreach($applications as $app)
    @php

$borderClass = match($app->status){

    'BARU' => 'border-blue',

    'INTERVIEW' => 'border-yellow',

    'DITERIMA' => 'border-navy',

    'DITOLAK' => 'border-grey',

    default => 'border-blue'
};

@endphp
    <div class="cand-card {{ $borderClass }}">

        {{-- Photo --}}
        <div class="cand-photo-wrap">
            <img src="{{ $app->user->photo
        ? asset('storage/'.$app->user->photo)
        : 'https://ui-avatars.com/api/?name='.urlencode($app->user->name)
        }}" alt="{{ $app->user->name }}" class="cand-photo"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($app->user->name) }}&background=e8ecf5&color=1a3570&size=58'">
            @if(false)
            <div class="verified-dot">
                <svg width="9" height="9" viewBox="0 0 24 24" fill="none"
                     stroke="#fff" stroke-width="3.5">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            @endif
        </div>

        {{-- Name --}}
        <div class="cand-name-block">
            <div class="cand-name">
                {{ $app->user->name }}
            </div>
            <div class="cand-role">{{ $app->user->summary ?? 'Pelamar' }}</div>
        </div>

        {{-- Applied For --}}
        <div class="applied-block">
            <div class="applied-lbl">Applied For</div>
            <div class="applied-pos">{{ $app->job->posisi }}</div>
            <div class="applied-time">{{ $app->created_at->diffForHumans() }}</div>
        </div>

        @php

$badgeClass = match($app->status){

    'BARU' => 'sbadge-new',

    'INTERVIEW' => 'sbadge-interviewing',

    'DITERIMA' => 'sbadge-offer',

    'DITOLAK' => 'sbadge-rejected',

    default => 'sbadge-new'
};

@endphp
        {{-- Stage --}}
        <div class="stage-block">
            <div class="stage-lbl">Stage</div>
            <span class="sbadge {{ $badgeClass }}">
    {{ $app->status }}
</span>
        </div>

        {{-- Action Icons --}}
        <div class="action-icons">

        <svg width="18" height="18" viewBox="0 0 24 24"
         fill="none" stroke="currentColor" stroke-width="2">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>

        </div>

        {{-- Action Button --}}
        <a href="{{ route('company.applicant.review', $app->id) }}" class="btn-review">
        Review Profile
        </a>

    </div>
    @endforeach

    {{-- PAGINATION --}}
<div class="pagination-row">

    <span class="showing-text">
        Showing
        {{ $applications->firstItem() }}
        -
        {{ $applications->lastItem() }}
        of
        {{ $applications->total() }}
        applicants
    </span>

</div>

<div class="mt-3">
    {{ $applications->links() }}
</div>

@endsection