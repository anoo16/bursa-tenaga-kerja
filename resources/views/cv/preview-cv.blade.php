@extends('layouts.jobseeker')
@section('title', 'Preview CV')
@section('page-title', 'Preview CV')

@section('content')
<div class="cv-page">

    {{-- Stepper --}}
    <div class="cv-stepper">
        <div class="step done"><div class="step-circle"><i class="fas fa-check"></i></div><span>Pilih Template</span></div>
        <div class="step-line active"></div>
        <div class="step done"><div class="step-circle"><i class="fas fa-check"></i></div><span>Isi Data CV</span></div>
        <div class="step-line active"></div>
        <div class="step active"><div class="step-circle">3</div><span>Preview</span></div>
    </div>

    @if(session('success'))
    <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    {{-- Action Bar --}}
    <div class="preview-actions">
        <a href="{{ route('cv.edit') }}" class="btn-outline-gray">
            <i class="fas fa-edit"></i> Edit CV
        </a>
        <a href="{{ route('cv.templates') }}" class="btn-outline-gray">
            <i class="fas fa-palette"></i> Ganti Template
        </a>
        <button onclick="window.print()" class="btn-primary">
            <i class="fas fa-download"></i> Download / Print PDF
        </button>
    </div>

    {{-- Rendered CV Template --}}
    <div class="cv-preview-wrapper" id="cvPreviewArea">
        @include($templateView, ['profile' => $profile])
    </div>

</div>
@endsection

@push('styles')
<style>
@media print {
    .sidebar, .topbar, .cv-stepper, .preview-actions { display: none !important; }
    .main-wrapper { margin: 0 !important; }
    .cv-preview-wrapper { box-shadow: none !important; }
    body { background: white !important; }
}
</style>
@endpush
