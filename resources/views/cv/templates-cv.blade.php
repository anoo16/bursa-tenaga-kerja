@extends('layouts.jobseeker')
@section('title', 'Pilih Template CV')
@section('page-title', 'Pilih Template CV')

@section('content')
<div class="cv-page">

    {{-- Stepper --}}
    <div class="cv-stepper">
        <div class="step active">
            <div class="step-circle">1</div>
            <span>Pilih Template</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
            <span>Isi Data CV</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span>Preview & Selesai</span>
        </div>
    </div>

    <h2 class="cv-section-title">Pilih Template CV Kamu</h2>
    <p class="cv-section-sub">Pilih desain yang sesuai dengan profil dan industri yang kamu tuju</p>

    <form action="{{ route('cv.templates.select') }}" method="POST" id="templateForm">
        @csrf
        <input type="hidden" name="template_id" id="selectedTemplate"
               value="{{ $profile->template_id ?? 'modern' }}">

        <div class="templates-grid">
            @foreach($templates as $tpl)
            <div class="template-card {{ ($profile->template_id ?? 'modern') === $tpl->slug ? 'selected' : '' }}"
                 onclick="selectTemplate('{{ $tpl->slug }}', this)">

                {{-- Preview area --}}
                <div class="template-preview tpl-{{ $tpl->slug }}">
                    @if($tpl->slug === 'modern')
                        @include('templates.modern')
                    @elseif($tpl->slug === 'classic')
                        @include('templates.classic')
                    @else
                        @include('templates.minimal')
                    @endif
                </div>

                <div class="template-meta">
                    <div class="template-check"><i class="fas fa-check-circle"></i></div>
                    <h4 class="template-name">{{ $tpl->name }}</h4>
                    <p class="template-desc">{{ $tpl->description }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="cv-form-footer">
            <a href="{{ route('profile.index') }}" class="btn-outline-gray">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn-primary">
                Gunakan Template Ini <i class="fas fa-arrow-right"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function selectTemplate(slug, el) {
    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedTemplate').value = slug;
}
</script>
@endpush
