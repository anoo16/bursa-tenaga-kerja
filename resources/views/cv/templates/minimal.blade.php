{{-- resources/views/templates/minimal.blade.php --}}
@php $color = $profile->primary_color ?? '#1a3c8f'; @endphp
<style>
.cv-minimal { --c: {{ $color }}; font-family: 'Plus Jakarta Sans', sans-serif; max-width: 840px; margin: 0 auto; background: #fff; }
.cv-minimal .cv-top { padding: 42px 44px 28px; border-bottom: 1px solid #e2e8f0; }
.cv-minimal .cv-name { font-size: 30px; font-weight: 800; color: #0f172a; }
.cv-minimal .cv-title { font-size: 14px; color: var(--c); font-weight: 600; margin: 3px 0 14px; }
.cv-minimal .cv-contacts { display: flex; flex-wrap: wrap; gap: 6px 20px; font-size: 11.5px; color: #64748b; }
.cv-minimal .cv-contacts span { display: flex; align-items: center; gap: 5px; }
.cv-minimal .cv-body { display: grid; grid-template-columns: 1.6fr 1fr; gap: 0; }
.cv-minimal .cv-main { padding: 28px 36px 36px 44px; }
.cv-minimal .cv-aside { padding: 28px 32px 36px 24px; background: #f8faff; border-left: 1px solid #e8eeff; }
.cv-minimal .sec-title { font-size: 10px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: var(--c); margin-bottom: 12px; margin-top: 22px; }
.cv-minimal .sec-title:first-child { margin-top: 0; }
.cv-minimal .exp-item { margin-bottom: 14px; }
.cv-minimal .exp-org { font-weight: 700; font-size: 13.5px; color: #0f172a; }
.cv-minimal .exp-pos { font-size: 12.5px; color: var(--c); }
.cv-minimal .exp-period { font-size: 11px; color: #94a3b8; margin: 2px 0 5px; }
.cv-minimal .exp-desc { font-size: 12px; color: #475569; line-height: 1.65; }
.cv-minimal .edu-item { margin-bottom: 12px; }
.cv-minimal .edu-school { font-weight: 700; font-size: 13px; color: #0f172a; }
.cv-minimal .edu-info { font-size: 12px; color: #475569; }
.cv-minimal .skill-wrap { display: flex; flex-direction: column; gap: 8px; }
.cv-minimal .skill-row {}
.cv-minimal .skill-name { font-size: 12px; font-weight: 600; color: #1e293b; margin-bottom: 3px; }
.cv-minimal .skill-bar { background: #e2e8f0; border-radius: 20px; height: 5px; }
.cv-minimal .skill-fill { background: var(--c); border-radius: 20px; height: 5px; }
.cv-minimal .cert-name { font-size: 12px; font-weight: 600; color: #1e293b; }
.cv-minimal .cert-meta { font-size: 11px; color: #94a3b8; }
.cv-minimal .cert-item { margin-bottom: 10px; }
.cv-minimal .summary-text { font-size: 13px; color: #475569; line-height: 1.75; }
</style>

<div class="cv-minimal">
    <div class="cv-top">
        <div class="cv-name">{{ $profile->full_name }}</div>
        <div class="cv-title">{{ $profile->job_title }}</div>
        <div class="cv-contacts">
            @if($profile->email)    <span><i class="fas fa-envelope"></i> {{ $profile->email }}</span> @endif
            @if($profile->phone)    <span><i class="fas fa-phone"></i> {{ $profile->phone }}</span> @endif
            @if($profile->location) <span><i class="fas fa-map-marker-alt"></i> {{ $profile->location }}</span> @endif
            @if($profile->website)  <span><i class="fas fa-link"></i> {{ $profile->website }}</span> @endif
        </div>
    </div>

    <div class="cv-body">
        <div class="cv-main">
            @if($profile->summary)
            <div class="sec-title">Tentang Saya</div>
            <p class="summary-text">{{ $profile->summary }}</p>
            @endif

            @if($profile->experiences->count())
            <div class="sec-title">Pengalaman</div>
            @foreach($profile->experiences as $exp)
            <div class="exp-item">
                <div class="exp-org">{{ $exp->company }}</div>
                <div class="exp-pos">{{ $exp->position }}</div>
                <div class="exp-period">{{ $exp->start_date }} – {{ $exp->is_current ? 'Sekarang' : $exp->end_date }}</div>
                @if($exp->description)<div class="exp-desc">{{ $exp->description }}</div>@endif
            </div>
            @endforeach
            @endif

            @if($profile->educations->count())
            <div class="sec-title">Pendidikan</div>
            @foreach($profile->educations as $edu)
            <div class="edu-item">
                <div class="edu-school">{{ $edu->institution }}</div>
                <div class="edu-info">{{ $edu->degree }}@if($edu->field_of_study) · {{ $edu->field_of_study }}@endif</div>
                <div class="edu-info" style="color:#94a3b8;font-size:11px">{{ $edu->start_year }}@if($edu->end_year) – {{ $edu->end_year }}@endif@if($edu->gpa) · GPA {{ $edu->gpa }}@endif</div>
            </div>
            @endforeach
            @endif
        </div>

        <div class="cv-aside">
            @if($profile->skills->count())
            <div class="sec-title">Keahlian</div>
            <div class="skill-wrap">
                @foreach($profile->skills as $skill)
                <div class="skill-row">
                    <div class="skill-name">{{ $skill->name }}</div>
                    <div class="skill-bar"><div class="skill-fill" style="width:{{ $skill->level }}%"></div></div>
                </div>
                @endforeach
            </div>
            @endif

            @if($profile->certifications->count())
            <div class="sec-title" style="margin-top:24px">Sertifikasi</div>
            @foreach($profile->certifications as $cert)
            <div class="cert-item">
                <div class="cert-name">{{ $cert->name }}</div>
                <div class="cert-meta">{{ $cert->issuer }}@if($cert->year) · {{ $cert->year }}@endif</div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
