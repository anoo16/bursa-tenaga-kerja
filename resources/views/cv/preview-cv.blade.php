@extends('layouts.jobseeker')
@section('title', 'Preview CV')
@section('page-title', 'Preview CV')

@section('content')
<div class="cv-page">

    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Action Bar --}}
    <div class="preview-actions">
        <a href="{{ route('cv.templates') }}" class="btn-outline-gray">
            <i class="fas fa-palette"></i> Ganti Template
        </a>

        <button
            id="btn-download-pdf"
            class="btn-primary"
            onclick="downloadCvPDF()">
            <i class="fas fa-download" id="download-icon"></i>
            <span id="download-text">Download PDF</span>
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
    .sidebar, .topbar, .preview-actions { display: none !important; }
    .main-wrapper { margin: 0 !important; }
    .cv-preview-wrapper { box-shadow: none !important; }
    body { background: white !important; }
}

.preview-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.btn-primary {
    background: #0f2854;
    color: #fff;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    border: none;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.btn-outline-gray {
    background: #fff;
    border: 1px solid #d1d5db;
    color: #374151;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.cv-preview-wrapper {
    background: #fff;
    width: 210mm;
    min-height: 297mm;
    margin: auto;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    overflow: hidden;
}
</style>
@endpush

@push('scripts')
<script>
async function downloadCvPDF() {
    const btn  = document.getElementById('btn-download-pdf');
    const icon = document.getElementById('download-icon');
    const text = document.getElementById('download-text');

    const token = localStorage.getItem('token');
    if (!token) {
        alert('Sesi Anda telah berakhir. Silakan login kembali.');
        window.location.href = '/login';
        return;
    }

    btn.disabled     = true;
    icon.className   = 'fas fa-spinner fa-spin';
    text.textContent = 'Generating PDF...';

    try {
        const cvData = @json($cvRawData ?? []);

        // Debug: cek data yang dikirim
        console.log('cvData dikirim:', cvData);

        if (!cvData || Object.keys(cvData).length === 0) {
            alert('Data CV kosong. Silakan isi CV terlebih dahulu.');
            return;
        }

        const response = await fetch('/api/cv/download-draft-pdf', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/pdf',
            },
            body: JSON.stringify({ cv_data: cvData })
        });

        console.log('Response status:', response.status);
        console.log('Content-Type:', response.headers.get('Content-Type'));

        if (response.status === 401) {
            alert('Sesi Anda telah berakhir. Silakan login kembali.');
            window.location.href = '/login';
            return;
        }

        if (!response.ok) {
            // Tampilkan error detail dari server
            const responseText = await response.text();
            console.error('Server error:', responseText);
            alert('Gagal download!\nStatus: ' + response.status + '\nDetail: ' + responseText.substring(0, 300));
            return;
        }

        const contentType = response.headers.get('Content-Type');
        if (!contentType || !contentType.includes('pdf')) {
            const responseText = await response.text();
            console.error('Bukan PDF:', responseText);
            alert('Server tidak mengembalikan PDF.\nResponse: ' + responseText.substring(0, 300));
            return;
        }

        const blob     = await response.blob();
        const url      = window.URL.createObjectURL(blob);
        const a        = document.createElement('a');
        a.href         = url;
        a.download     = 'CV_{{ $profile->full_name ?? "CV" }}'.replace(/ /g, '_') + '.pdf';
        document.body.appendChild(a);
        a.click();
        a.remove();
        window.URL.revokeObjectURL(url);

    } catch (error) {
        console.error('Exception:', error);
        alert('Error: ' + error.name + '\nPesan: ' + error.message);
    } finally {
        btn.disabled     = false;
        icon.className   = 'fas fa-download';
        text.textContent = 'Download PDF';
    }
}
</script>
@endpush