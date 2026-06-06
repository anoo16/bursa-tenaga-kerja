@extends('layouts.jobseeker')

@section('title', 'Template CV')

@vite([
    'resources/css/template-cv.css',
    'resources/js/template-cv.js'
])

@section('content')

<div class="cv-template-page">

    {{-- HEADER --}}
    <div class="cv-template-header">

        <div>
            <h1>Template CV</h1>
            <p>
                Pilih template CV profesional yang sesuai dengan kebutuhan karier Anda.
            </p>
        </div>

        <a href="{{ route('profile') }}" class="back-profile-btn">
            <i class='bx bx-arrow-back'></i>
            Kembali ke Profil
        </a>

    </div>

    </div>

    {{-- TEMPLATE GRID --}}
    <div class="cv-template-grid">

        {{-- TEMPLATE 1 --}}
        <div class="cv-template-card" data-category="modern">

            <div class="template-preview modern-template">

                <div class="preview-sidebar">
                    <div class="preview-avatar"></div>
                    <div class="preview-line short"></div>
                    <div class="preview-line"></div>
                    <div class="preview-line"></div>
                </div>

                <div class="preview-content">
                    <div class="preview-title"></div>
                    <div class="preview-subtitle"></div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

            </div>

            <div class="template-info">

                <div>
                    <h3>Modern Blue</h3>
                    <p>Cocok untuk UI/UX Designer, Web Developer, dan Product Designer.</p>
                </div>

                <span class="template-badge modern">
                    Modern
                </span>

            </div>

            <div class="template-actions">

                <button class="preview-btn" data-template="modern-blue">
                    <i class='bx bx-show'></i>
                    Preview
                </button>

               <a
                    href="{{ route('cv.edit', ['template' => 'modern-blue']) }}"
                    class="use-btn"
                >
                    Gunakan
                </a>

            </div>

        </div>

        {{-- TEMPLATE 2 --}}
        <div class="cv-template-card" data-category="professional">

            <div class="template-preview professional-template">

                <div class="preview-header"></div>

                <div class="preview-content full">
                    <div class="preview-title"></div>
                    <div class="preview-subtitle"></div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

            </div>

            <div class="template-info">

                <div>
                    <h3>Professional White</h3>
                    <p>Desain formal untuk kebutuhan melamar kerja di perusahaan profesional.</p>
                </div>

                <span class="template-badge professional">
                    Profesional
                </span>

            </div>

            <div class="template-actions">

                <button class="preview-btn" data-template="professional-white">
                    <i class='bx bx-show'></i>
                    Preview
                </button>

                <a
                    href="{{ route('cv.edit', ['template' => 'professional-white']) }}"
                    class="use-btn"
                >
                    Gunakan
                </a>

            </div>

        </div>

        {{-- TEMPLATE 6 --}}
        <div class="cv-template-card" data-category="professional">

            <div class="template-preview corporate-template">

                <div class="corporate-top"></div>

                <div class="preview-content full">
                    <div class="preview-title"></div>
                    <div class="preview-subtitle"></div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="preview-section">
                        <div></div>
                        <span></span>
                        <span></span>
                    </div>
                </div>

            </div>

            <div class="template-info">

                <div>
                    <h3>Corporate Elegant</h3>
                    <p>Template elegan untuk posisi administrasi, finance, dan management.</p>
                </div>

                <span class="template-badge professional">
                    Profesional
                </span>

            </div>

            <div class="template-actions">

                <button class="preview-btn" data-template="corporate-elegant">
                    <i class='bx bx-show'></i>
                    Preview
                </button>

                <a
                    href="{{ route('cv.edit', ['template' => 'corporate-elegant']) }}"
                    class="use-btn"
                >
                    Gunakan
                </a>
            </div>

        </div>

    </div>

</div>

{{-- PREVIEW MODAL --}}
<div class="cv-preview-overlay" id="cvPreviewOverlay">

    <div class="cv-preview-modal">

        <div class="cv-preview-header">

            <div>
                <h2 id="previewTemplateName">
                    Preview Template
                </h2>

                <p>
                    Tampilan contoh CV berdasarkan template yang dipilih.
                </p>
            </div>

            <button class="close-preview" id="closePreview">
                <i class='bx bx-x'></i>
            </button>

        </div>

        <div class="cv-preview-body">

            <div class="cv-paper" id="cvPaperPreview">

                <div class="cv-paper-header">

                    <div>
                        <h1 id="cvPreviewName">Bryan Larumunde</h1>
                        <p id="cvPreviewHeadline">UI/UX Designer • Manado, Indonesia</p>
                    </div>

                    <div class="cv-paper-photo" id="cvPreviewPhoto"></div>

                </div>

                <div class="cv-paper-section">
                    <h3>Ringkasan</h3>
                    <p id="cvPreviewSummary">
                        UI/UX Designer dengan pengalaman dalam perancangan produk digital,
                        user research, prototyping, dan visual strategy.
                    </p>
                </div>

                <div class="cv-paper-section">
                    <h3>Pengalaman</h3>

                    <h4 id="cvPreviewExperienceTitle">Staff Division UI/UX</h4>
                    <span id="cvPreviewExperienceCompany">UKM Unity • 2025 - Present</span>

                    <p id="cvPreviewExperienceDesc">
                        Melakukan riset pengguna dan membantu proses perancangan antarmuka
                        untuk solusi berbasis teknologi.
                    </p>
                </div>

                <div class="cv-paper-section">
                    <h3>Keahlian</h3>

                    <div class="cv-paper-skills" id="cvPreviewSkills">
                        <span>Figma</span>
                        <span>UI Design</span>
                        <span>UX Research</span>
                        <span>Laravel</span>
                    </div>
                </div>

            </div>

        </div>

        <div class="cv-preview-footer">

            <button class="cancel-preview" id="cancelPreview">
                Batal
            </button>

            <button class="use-template-final" id="useTemplateFinal">
                Gunakan Template
            </button>

        </div>

    </div>

</div>

@endsection