{{-- resources/views/templates/classic.blade.php --}}
<style>
.cv-classic { font-family: 'Georgia', serif; max-width: 860px; margin: 0 auto; background: #fff; padding: 50px 52px; color: #1a1a1a; }
.cv-classic .cv-name { font-size: 32px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #111; border-bottom: 3px double #111; padding-bottom: 10px; margin-bottom: 4px; }
.cv-classic .cv-jobtitle { font-size: 14px; color: #555; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 12px; font-style: italic; }
.cv-classic .cv-contacts { display: flex; flex-wrap: wrap; gap: 6px 24px; font-size: 12px; color: #444; margin-bottom: 26px; }
.cv-classic .cv-section { margin-bottom: 24px; }
.cv-classic .cv-section-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; color: #111; border-bottom: 1.5px solid #111; padding-bottom: 4px; margin-bottom: 14px; }
.cv-classic .cv-summary { font-size: 13px; line-height: 1.8; color: #333; }
.cv-classic .exp-item { margin-bottom: 16px; display: grid; grid-template-columns: 1fr 140px; gap: 0 16px; }
.cv-classic .exp-left {}
.cv-classic .exp-right { text-align: right; font-size: 11.5px; color: #666; }
.cv-classic .exp-org { font-weight: 700; font-size: 13.5px; }
.cv-classic .exp-pos { font-size: 13px; color: #333; font-style: italic; }
.cv-classic .exp-desc { font-size: 12px; color: #555; line-height: 1.65; margin-top: 4px; grid-column: 1 / -1; }
.cv-classic .edu-item { margin-bottom: 12px; display: grid; grid-template-columns: 1fr 120px; }
.cv-classic .edu-school { font-weight: 700; font-size: 13px; }
.cv-classic .edu-deg { font-size: 12px; font-style: italic; color: #444; }
.cv-classic .edu-yr { font-size: 11.5px; color: #777; text-align: right; }
.cv-classic .skills-list { display: flex; flex-wrap: wrap; gap: 6px; }
.cv-classic .skill-tag { font-size: 12px; border: 1px solid #ccc; padding: 3px 10px; border-radius: 3px; }
.cv-classic .cert-item { font-size: 12.5px; margin-bottom: 6px; }
.cv-classic .cert-name { font-weight: 600; }
.cv-classic .cert-meta { font-size: 11.5px; color: #666; }
</style>

<div class="cv-classic">
    <div class="cv-name">{{ $profile->full_name }}</div>
    <div class="cv-jobtitle">{{ $profile->job_title }}</div>
    <div class="cv-contacts">
        @if($profile->email)    <span>{{ $profile->email }}</span> @endif
        @if($profile->phone)    <span>{{ $profile->phone }}</span> @endif
        @if($profile->location) <span>{{ $profile->location }}</span> @endif
        @if($profile->website)  <span>{{ $profile->website }}</span> @endif
    </div>

    @if($profile->summary)
    <div class="cv-section">
        <div class="cv-section-title">Profil</div>
        <p class="cv-summary">{{ $profile->summary }}</p>
    </div>
    @endif

    @if($profile->experiences->count())
    <div class="cv-section">
        <div class="cv-section-title">Pengalaman</div>
        @foreach($profile->experiences as $exp)
        <div class="exp-item">
            <div class="exp-left">
                <div class="exp-org">{{ $exp->company }}</div>
                <div class="exp-pos">{{ $exp->position }}</div>
            </div>
            <div class="exp-right">{{ $exp->start_date }} – {{ $exp->is_current ? 'Sekarang' : $exp->end_date }}</div>
            @if($exp->description)
            <div class="exp-desc">{{ $exp->description }}</div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    @if($profile->educations->count())
    <div class="cv-section">
        <div class="cv-section-title">Pendidikan</div>
        @foreach($profile->educations as $edu)
        <div class="edu-item">
            <div>
                <div class="edu-school">{{ $edu->institution }}</div>
                <div class="edu-deg">{{ $edu->degree }}@if($edu->field_of_study), {{ $edu->field_of_study }}@endif @if($edu->gpa) — IPK {{ $edu->gpa }}@endif</div>
            </div>
            <div class="edu-yr">{{ $edu->start_year }}@if($edu->end_year) – {{ $edu->end_year }}@endif</div>
        </div>
        @endforeach
    </div>
    @endif

    @if($profile->skills->count())
    <div class="cv-section">
        <div class="cv-section-title">Keahlian</div>
        <div class="skills-list">
            @foreach($profile->skills as $skill)
            <span class="skill-tag">{{ $skill->name }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @if($profile->certifications->count())
    <div class="cv-section">
        <div class="cv-section-title">Sertifikasi</div>
        @foreach($profile->certifications as $cert)
        <div class="cert-item">
            <div class="cert-name">{{ $cert->name }}</div>
            <div class="cert-meta">{{ $cert->issuer }}@if($cert->year) &bull; {{ $cert->year }}@endif</div>
        </div>
        @endforeach
    </div>
    @endif
</div>
