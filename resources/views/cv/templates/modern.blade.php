{{-- resources/views/templates/modern.blade.php --}}
{{-- Data dari DB: $profile->experiences, ->educations, ->skills, ->certifications --}}

@php
    $color = $profile->primary_color ?? '#1a3c8f';
@endphp

<style>
.cv-modern { --cv-color: {{ $color }}; font-family: 'Plus Jakarta Sans', sans-serif; max-width: 900px; margin: 0 auto; background: #fff; }
.cv-modern .cv-header { background: var(--cv-color); color: #fff; padding: 36px 40px; display: flex; gap: 24px; align-items: center; }
.cv-modern .cv-header-photo img { width: 90px; height: 90px; border-radius: 50%; border: 3px solid rgba(255,255,255,.4); object-fit: cover; }
.cv-modern .cv-header-photo .no-photo { width: 90px; height: 90px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 800; }
.cv-modern .cv-name { font-size: 28px; font-weight: 800; margin-bottom: 4px; }
.cv-modern .cv-jobtitle { font-size: 14px; opacity: .85; margin-bottom: 12px; }
.cv-modern .cv-contacts { display: flex; flex-wrap: wrap; gap: 10px 20px; font-size: 12px; opacity: .9; }
.cv-modern .cv-contacts span { display: flex; align-items: center; gap: 5px; }
.cv-modern .cv-body { display: grid; grid-template-columns: 1fr 260px; }
.cv-modern .cv-main { padding: 30px 32px; }
.cv-modern .cv-side { background: #f8faff; border-left: 1px solid #e8eeff; padding: 28px 22px; }
.cv-modern .cv-section { margin-bottom: 28px; }
.cv-modern .cv-section-title { font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--cv-color); border-bottom: 2px solid var(--cv-color); padding-bottom: 5px; margin-bottom: 14px; }
.cv-modern .cv-summary { font-size: 13px; color: #475569; line-height: 1.75; }
.cv-modern .exp-item { margin-bottom: 18px; padding-bottom: 18px; border-bottom: 1px solid #f1f5f9; }
.cv-modern .exp-item:last-child { border-bottom: none; margin-bottom: 0; }
.cv-modern .exp-org { font-weight: 700; font-size: 14px; color: #1e293b; }
.cv-modern .exp-pos { font-size: 12.5px; color: var(--cv-color); font-weight: 600; }
.cv-modern .exp-period { font-size: 11px; color: #94a3b8; margin-bottom: 5px; }
.cv-modern .exp-desc { font-size: 12px; color: #64748b; line-height: 1.65; }
.cv-modern .edu-item { margin-bottom: 14px; }
.cv-modern .edu-school { font-weight: 700; font-size: 13px; color: #1e293b; }
.cv-modern .edu-deg { font-size: 12px; color: var(--cv-color); }
.cv-modern .edu-yr { font-size: 11px; color: #94a3b8; }
.cv-modern .skill-item { margin-bottom: 10px; }
.cv-modern .skill-label { display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; }
.cv-modern .skill-bar { background: #e2e8f0; border-radius: 20px; height: 6px; }
.cv-modern .skill-fill { background: var(--cv-color); height: 6px; border-radius: 20px; transition: width .3s; }
.cv-modern .cert-item { font-size: 12px; color: #475569; padding: 6px 0; border-bottom: 1px solid #f1f5f9; }
.cv-modern .cert-name { font-weight: 600; color: #1e293b; }
.cv-modern .cert-meta { font-size: 11px; color: #94a3b8; }
.cv-modern .skill-category { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; font-weight: 700; margin: 12px 0 6px; }
</style>

<div class="cv-modern">
    {{-- HEADER --}}
    <div class="cv-header">
        <div class="cv-header-photo">
            @if($profile->photo)
                <img src="{{ Storage::url($profile->photo) }}" alt="{{ $profile->full_name }}">
            @else
                <div class="no-photo">{{ strtoupper(substr($profile->full_name,0,2)) }}</div>
            @endif
        </div>
        <div>
            <div class="cv-name">{{ $profile->full_name }}</div>
            <div class="cv-jobtitle">{{ $profile->job_title }}</div>
            <div class="cv-contacts">
                @if($profile->email)    <span><i class="fas fa-envelope"></i> {{ $profile->email }}</span> @endif
                @if($profile->phone)    <span><i class="fas fa-phone"></i> {{ $profile->phone }}</span> @endif
                @if($profile->location) <span><i class="fas fa-map-marker-alt"></i> {{ $profile->location }}</span> @endif
                @if($profile->website)  <span><i class="fas fa-globe"></i> {{ $profile->website }}</span> @endif
                @if($profile->linkedin) <span><i class="fab fa-linkedin"></i> {{ $profile->linkedin }}</span> @endif
            </div>
        </div>
    </div>

    <div class="cv-body">
        {{-- MAIN COLUMN --}}
        <div class="cv-main">

            @if($profile->summary)
            <div class="cv-section">
                <div class="cv-section-title">Tentang Saya</div>
                <p class="cv-summary">{{ $profile->summary }}</p>
            </div>
            @endif

            @if($profile->experiences->count())
            <div class="cv-section">
                <div class="cv-section-title">Pengalaman</div>
                @foreach($profile->experiences as $exp)
                <div class="exp-item">
                    <div class="exp-org">{{ $exp->company }}</div>
                    <div class="exp-pos">{{ $exp->position }}</div>
                    <div class="exp-period">
                        {{ $exp->start_date }} — {{ $exp->is_current ? 'Sekarang' : ($exp->end_date ?? '-') }}
                    </div>
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
                    <div class="edu-school">{{ $edu->institution }}</div>
                    <div class="edu-deg">{{ $edu->degree }}@if($edu->field_of_study) — {{ $edu->field_of_study }}@endif</div>
                    <div class="edu-yr">
                        {{ $edu->start_year }}@if($edu->end_year) – {{ $edu->end_year }}@endif
                        @if($edu->gpa) &nbsp;|&nbsp; IPK {{ $edu->gpa }} @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

        {{-- SIDE COLUMN --}}
        <div class="cv-side">

            @if($profile->skills->count())
            <div class="cv-section">
                <div class="cv-section-title">Keahlian</div>
                @php $skillGroups = $profile->skills->groupBy('category'); @endphp
                @foreach($skillGroups as $cat => $skills)
                <div class="skill-category">{{ $cat }}</div>
                @foreach($skills as $skill)
                <div class="skill-item">
                    <div class="skill-label">
                        <span>{{ $skill->name }}</span>
                        <span>{{ $skill->level }}%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-fill" style="width:{{ $skill->level }}%"></div>
                    </div>
                </div>
                @endforeach
                @endforeach
            </div>
            @endif

            @if($profile->certifications->count())
            <div class="cv-section">
                <div class="cv-section-title">Sertifikasi</div>
                @foreach($profile->certifications as $cert)
                <div class="cert-item">
                    <div class="cert-name">{{ $cert->name }}</div>
                    <div class="cert-meta">
                        {{ $cert->issuer }}@if($cert->year) &bull; {{ $cert->year }}@endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</div>
