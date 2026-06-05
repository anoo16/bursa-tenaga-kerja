@extends('layouts.jobseeker')

@section('content')
<style>
* { box-sizing: border-box; }

.sc-wrap {
    min-height: 100vh;
    background: #f5f5e8;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    font-family: 'Poppins', 'Segoe UI', sans-serif;
}

.sc-card {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 20px 60px rgba(15,40,84,0.10);
    max-width: 860px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 1.1fr;
    overflow: hidden;
    min-height: 420px;
}

/* ── LEFT PANEL ── */
.sc-left {
    background: linear-gradient(160deg, #f0f4ff 0%, #e8edf8 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 2.5rem;
    position: relative;
    overflow: hidden;
}

/* blur blobs */
.sc-left::before {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(28, 77, 141, 0.12);
    top: -60px;
    left: -60px;
    filter: blur(40px);
}
.sc-left::after {
    content: '';
    position: absolute;
    width: 160px;
    height: 160px;
    border-radius: 50%;
    background: rgba(28, 77, 141, 0.10);
    bottom: -50px;
    right: -40px;
    filter: blur(35px);
}

.sc-check-wrap {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #fff;
    box-shadow: 0 8px 30px rgba(28,77,141,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.4rem;
    position: relative;
    z-index: 1;
    animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
}
@keyframes popIn {
    from { transform: scale(0.5); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}

.sc-check-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0F2854, #1C4D8D);
    display: flex;
    align-items: center;
    justify-content: center;
}
.sc-check-circle svg {
    color: #fff;
    animation: drawCheck 0.4s 0.3s ease both;
}
@keyframes drawCheck {
    from { opacity: 0; transform: scale(0.5) rotate(-20deg); }
    to   { opacity: 1; transform: scale(1) rotate(0deg); }
}

.sc-submission-badge {
    background: rgba(255,255,255,0.7);
    border: 1px solid #d0d8ee;
    border-radius: 999px;
    padding: 0.28rem 0.9rem;
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.13em;
    text-transform: uppercase;
    color: #1C4D8D;
    margin-bottom: 0.8rem;
    position: relative;
    z-index: 1;
}

.sc-left-title {
    font-size: 1.7rem;
    font-weight: 800;
    color: #0F2854;
    margin-bottom: 0.5rem;
    text-align: center;
    position: relative;
    z-index: 1;
}

.sc-left-quote {
    font-size: 0.85rem;
    color: #5a6a8a;
    font-style: italic;
    text-align: center;
    max-width: 230px;
    line-height: 1.6;
    position: relative;
    z-index: 1;
}

/* ── RIGHT PANEL ── */
.sc-right {
    padding: 3rem 2.8rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.sc-right-title {
    font-size: 2rem;
    font-weight: 900;
    color: #0F2854;
    line-height: 1.2;
    margin-bottom: 0.9rem;
}

.sc-right-desc {
    font-size: 0.92rem;
    color: #4a5568;
    line-height: 1.7;
    margin-bottom: 1.6rem;
}
.sc-right-desc strong {
    color: #0F2854;
}

/* Next Step card */
.sc-next-card {
    background: #f7f9ff;
    border: 1.5px solid #e2e8f4;
    border-radius: 16px;
    padding: 1.1rem 1.3rem;
    display: flex;
    align-items: flex-start;
    gap: 0.9rem;
    margin-bottom: 2rem;
}
.sc-next-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #e8f0fe;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}
.sc-next-label {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0F2854;
    margin-bottom: 0.2rem;
}
.sc-next-sub {
    font-size: 0.80rem;
    color: #7a8599;
    line-height: 1.5;
}

/* Action buttons */
.sc-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.btn-sc-primary {
    background: linear-gradient(135deg, #0F2854 0%, #1C4D8D 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    padding: 0.85rem 1.8rem;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: opacity 0.2s;
}
.btn-sc-primary:hover { opacity: 0.88; color: #fff; }
.btn-sc-secondary {
    background: #fff;
    color: #0F2854;
    border: 2px solid #d0d8ee;
    border-radius: 12px;
    padding: 0.85rem 1.6rem;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    font-family: inherit;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: border-color 0.2s;
}
.btn-sc-secondary:hover { border-color: #1C4D8D; color: #0F2854; }

@media (max-width: 680px) {
    .sc-card { grid-template-columns: 1fr; }
    .sc-left { padding: 2.5rem 2rem; }
    .sc-right { padding: 2rem 1.8rem; }
    .sc-right-title { font-size: 1.5rem; }
}
</style>

<div class="sc-wrap">
    <div class="sc-card">

        {{-- LEFT --}}
        <div class="sc-left">
            <div class="sc-check-wrap">
                <div class="sc-check-circle">
                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="3">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
            </div>

            <div class="sc-submission-badge">Submission Success</div>

            <div class="sc-left-title">Terima Kasih!</div>

            <p class="sc-left-quote">
                "Perjalanan karir baru Anda dimulai dari langkah ini."
            </p>
        </div>

        {{-- RIGHT --}}
        <div class="sc-right">
            <h1 class="sc-right-title">
                Lamaran Berhasil<br>Terkirim!
            </h1>

            <p class="sc-right-desc">
                Lamaran Anda sedang diproses oleh tim rekrutmen
                <strong>{{ $company->name ?? 'perusahaan' }}</strong>.
                Anda dapat memantau statusnya di menu
                <strong>Lamaran Saya</strong> secara real-time.
            </p>

            {{-- Langkah Berikutnya --}}
            <div class="sc-next-card">
                <div class="sc-next-icon">🚀</div>
                <div>
                    <div class="sc-next-label">Langkah Berikutnya</div>
                    <div class="sc-next-sub">
                        Tim kami akan meninjau profil dan dokumen Anda
                        dalam 3–5 hari kerja.
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="sc-actions">
                <a href="{{ route('dashboard') }}" class="btn-sc-primary">
                    Kembali ke Dashboard
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                <a href="{{ route('applications.lamaran-saya') }}" class="btn-sc-secondary">
                    Lihat Lamaran
                </a>
            </div>
        </div>

    </div>
</div>

@endsection