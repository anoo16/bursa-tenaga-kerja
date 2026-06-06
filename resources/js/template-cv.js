document.addEventListener('DOMContentLoaded', () => {

    const filterButtons = document.querySelectorAll('.filter-btn');
    const templateCards = document.querySelectorAll('.cv-template-card');
    const searchInput = document.getElementById('cvSearch');

    const previewButtons = document.querySelectorAll('.preview-btn');
    const useButtons = document.querySelectorAll('.use-btn');

    const previewOverlay = document.getElementById('cvPreviewOverlay');
    const closePreview = document.getElementById('closePreview');
    const cancelPreview = document.getElementById('cancelPreview');
    const previewTemplateName = document.getElementById('previewTemplateName');
    const useTemplateFinal = document.getElementById('useTemplateFinal');

    const cvPreviewBody = document.querySelector('.cv-preview-body');

    let selectedTemplate = '';

    /* ===============================
       HELPERS
    ================================ */

    function safeText(value, fallback = 'Belum diisi'){
        return value && String(value).trim() !== ''
            ? value
            : fallback;
    }

    function normalizeArray(data){

        if(Array.isArray(data)){
            return data;
        }

        if(typeof data === 'string' && data.trim() !== ''){

            return data
                .split(',')
                .map(item => item.trim())
                .filter(item => item !== '');

        }

        return [];
    }

    function getUserData(){

        const user = JSON.parse(
            localStorage.getItem('user')
        ) ?? {};

        return {
            name: safeText(user.name, 'Nama belum diisi'),

            headline: safeText(user.headline, 'Headline belum diisi'),

            location: safeText(user.location, 'Lokasi belum diisi'),

            email: safeText(user.email, 'Email belum diisi'),

            phone: safeText(user.phone, 'Nomor telepon belum diisi'),

            summary: safeText(
                user.summary,
                'Ringkasan profesional belum diisi.'
            ),

            photo: user.photo
                ? `/storage/${user.photo}`
                : null,

            experiences: normalizeArray(user.experiences),

            educations: normalizeArray(user.educations),

            skills: normalizeArray(user.skills),

            certifications: normalizeArray(user.certifications)
        };

    }

    function renderSkillList(skills, className = ''){

        if(!skills || skills.length === 0){
            return `<span class="${className}">Belum ada keahlian</span>`;
        }

        return skills.map(skill => {

            const skillName =
                typeof skill === 'object'
                    ? skill.name
                    : skill;

            return `
                <span class="${className}">
                    ${safeText(skillName, 'Keahlian belum diisi')}
                </span>
            `;

        }).join('');

    }

    function renderExperienceList(experiences, type = 'default'){

        if(!experiences || experiences.length === 0){

            return `
                <div class="cv-empty-item">
                    Belum ada pengalaman kerja
                </div>
            `;

        }

        return experiences.map(exp => {

            const position =
                exp.position ?? exp.role ?? exp.title ?? 'Posisi belum diisi';

            const company =
                exp.company ?? exp.organization ?? 'Perusahaan belum diisi';

            const period =
                exp.period ?? 'Periode belum diisi';

            const description =
                exp.description ?? 'Deskripsi pengalaman belum diisi.';

            if(type === 'professional'){

                return `
                    <div class="cv-pro-row">
                        <div>
                            <h4>${position}</h4>
                            <p>${company}</p>
                        </div>
                        <span>${period}</span>
                    </div>

                    <p>${description}</p>
                `;

            }

            if(type === 'minimal'){

                return `
                    <div class="minimal-item">
                        <h4>${position}</h4>
                        <span>${company} — ${period}</span>
                    </div>

                    <p>${description}</p>
                `;

            }

            if(type === 'corporate'){

                return `
                    <div class="corp-item">
                        <h4>${position}</h4>
                        <span>${company} • ${period}</span>
                        <p>${description}</p>
                    </div>
                `;

            }

            return `
                <div class="cv-real-item">
                    <h4>${position}</h4>
                    <span>${company} • ${period}</span>
                    <p>${description}</p>
                </div>
            `;

        }).join('');

    }

    function renderEducationList(educations, type = 'default'){

        if(!educations || educations.length === 0){

            return `
                <div class="cv-empty-item">
                    Belum ada riwayat pendidikan
                </div>
            `;

        }

        return educations.map(edu => {

            const level =
                edu.level ?? 'Jenjang belum diisi';

            const major =
                edu.major ?? edu.education ?? 'Jurusan belum diisi';

            const school =
                edu.school ?? edu.university ?? 'Institusi belum diisi';

            const year =
                edu.graduation_year ?? edu.year ?? 'Tahun belum diisi';

            if(type === 'professional'){

                return `
                    <div class="cv-pro-row">
                        <div>
                            <h4>${major}</h4>
                            <p>${school}</p>
                        </div>
                        <span>${year}</span>
                    </div>
                `;

            }

            if(type === 'minimal'){

                return `
                    <div class="minimal-item">
                        <h4>${major}</h4>
                        <span>${school} — ${year}</span>
                    </div>
                `;

            }

            if(type === 'corporate'){

                return `
                    <p><strong>${major}</strong></p>
                    <p>${school} • ${year}</p>
                `;

            }

            return `
                <div class="cv-real-item">
                    <h4>${major}</h4>
                    <span>${school} • ${year}</span>
                </div>
            `;

        }).join('');

    }

    /* ===============================
       TEMPLATE: MODERN BLUE
    ================================ */

    function renderModernBlue(user){

        return `
            <div class="cv-preview-paper cv-real-modern-blue">

                <aside class="cv-real-sidebar">

                    <div
                        class="cv-real-photo"
                        style="${user.photo ? `background-image:url('${user.photo}')` : ''}">
                    </div>

                    <h3>Kontak</h3>
                    <p>${user.email}</p>
                    <p>${user.phone}</p>
                    <p>${user.location}</p>

                    <h3>Keahlian</h3>
                    <div class="cv-real-skill-list">
                        ${renderSkillList(user.skills)}
                    </div>

                </aside>

                <main class="cv-real-main">

                    <h1>${user.name}</h1>
                    <h2>${user.headline}</h2>

                    <section>
                        <h3>Ringkasan</h3>
                        <p>${user.summary}</p>
                    </section>

                    <section>
                        <h3>Pengalaman</h3>
                        ${renderExperienceList(user.experiences)}
                    </section>

                    <section>
                        <h3>Pendidikan</h3>
                        ${renderEducationList(user.educations)}
                    </section>

                </main>

            </div>
        `;

    }

    /* ===============================
       TEMPLATE: PROFESSIONAL WHITE
    ================================ */

    function renderProfessionalWhite(user){

        return `
            <div class="cv-preview-paper cv-real-professional-white">

                <div class="cv-pro-header">

                    <h1>${user.name}</h1>

                    <p>${user.headline}</p>

                    <span>
                        ${user.email} • ${user.phone} • ${user.location}
                    </span>

                </div>

                <section>
                    <h3>Professional Summary</h3>
                    <p>${user.summary}</p>
                </section>

                <section>
                    <h3>Work Experience</h3>
                    ${renderExperienceList(user.experiences, 'professional')}
                </section>

                <section>
                    <h3>Education</h3>
                    ${renderEducationList(user.educations, 'professional')}
                </section>

                <section>
                    <h3>Skills</h3>
                    <p>
                        ${
                            user.skills.length > 0
                                ? user.skills.map(skill => typeof skill === 'object' ? skill.name : skill).join(', ')
                                : 'Belum ada keahlian'
                        }
                    </p>
                </section>

            </div>
        `;

    }

    /* ===============================
       TEMPLATE: MINIMAL CLEAN
    ================================ */

    function renderMinimalClean(user){

        return `
            <div class="cv-preview-paper cv-real-minimal-clean">

                <header>
                    <h1>${user.name}</h1>
                    <p>${user.headline}</p>
                    <small>${user.email} / ${user.location}</small>
                </header>

                <section>
                    <h3>Summary</h3>
                    <p>${user.summary}</p>
                </section>

                <section>
                    <h3>Experience</h3>
                    ${renderExperienceList(user.experiences, 'minimal')}
                </section>

                <section>
                    <h3>Education</h3>
                    ${renderEducationList(user.educations, 'minimal')}
                </section>

                <section>
                    <h3>Core Skills</h3>
                    <p>
                        ${
                            user.skills.length > 0
                                ? user.skills.map(skill => typeof skill === 'object' ? skill.name : skill).join(' · ')
                                : 'Belum ada keahlian'
                        }
                    </p>
                </section>

            </div>
        `;

    }

    /* ===============================
       TEMPLATE: CORPORATE ELEGANT
    ================================ */

    function renderCorporateElegant(user){

        return `
            <div class="cv-preview-paper cv-real-corporate-elegant">

                <div class="corp-header">

                    <h1>${user.name}</h1>

                    <p>${user.headline}</p>

                    <span>
                        ${user.email} | ${user.phone} | ${user.location}
                    </span>

                </div>

                <div class="corp-grid">

                    <main>

                        <section>
                            <h3>Professional Profile</h3>
                            <p>${user.summary}</p>
                        </section>

                        <section>
                            <h3>Professional Experience</h3>
                            ${renderExperienceList(user.experiences, 'corporate')}
                        </section>

                    </main>

                    <aside>

                        <section>
                            <h3>Education</h3>
                            ${renderEducationList(user.educations, 'corporate')}
                        </section>

                        <section>
                            <h3>Skills</h3>

                            ${
                                user.skills.length > 0
                                    ? user.skills.map(skill => {

                                        const skillName =
                                            typeof skill === 'object'
                                                ? skill.name
                                                : skill;

                                        return `<p>${skillName}</p>`;

                                    }).join('')
                                    : '<p>Belum ada keahlian</p>'
                            }

                        </section>

                    </aside>

                </div>

            </div>
        `;

    }

    /* ===============================
       RENDER TEMPLATE
    ================================ */

   function renderTemplate(templateName){

        const user = getUserData();

        const templateTitles = {
            'modern-blue': 'Modern Blue',
            'professional-white': 'Professional White',
            'minimal-clean': 'Minimal Clean',
            'corporate-elegant': 'Corporate Elegant'
        };

        if(previewTemplateName){
            previewTemplateName.textContent =
                templateTitles[templateName]
                ?? 'Preview Template';
        }

        if(!cvPreviewBody) return;

        switch(templateName){

            case 'modern-blue':
                cvPreviewBody.innerHTML =
                    renderModernBlue(user);
                break;

            case 'professional-white':
                cvPreviewBody.innerHTML =
                    renderProfessionalWhite(user);
                break;

            case 'minimal-clean':
                cvPreviewBody.innerHTML =
                    renderMinimalClean(user);
                break;

            case 'corporate-elegant':
                cvPreviewBody.innerHTML =
                    renderCorporateElegant(user);
                break;

            default:
                cvPreviewBody.innerHTML =
                    renderModernBlue(user);
        }
    }

    /* ===============================
       EVENTS
    ================================ */

    previewButtons.forEach(button => {

        button.addEventListener('click', () => {

            selectedTemplate =
                button.dataset.template;

            renderTemplate(selectedTemplate);

            previewOverlay.classList.add('active');

        });

    });

    function closePreviewModal(){

        previewOverlay.classList.remove('active');

    }

    if(closePreview){

        closePreview.addEventListener(
            'click',
            closePreviewModal
        );

    }

    if(cancelPreview){

        cancelPreview.addEventListener(
            'click',
            closePreviewModal
        );

    }

    previewOverlay?.addEventListener('click', e => {

        if(e.target === previewOverlay){

            closePreviewModal();

        }

    });

    filterButtons.forEach(button => {

        button.addEventListener('click', () => {

            filterButtons.forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            filterTemplates();

        });

    });

    if(searchInput){

        searchInput.addEventListener(
            'input',
            filterTemplates
        );

    }

    if(useTemplateFinal){

        useTemplateFinal.addEventListener('click', () => {

            localStorage.setItem(
                'selected_cv_template',
                selectedTemplate
            );

            alert(
                `Template "${selectedTemplate}" berhasil dipilih.`
            );

            closePreviewModal();

        });

    }

    // ... kode template-cv.js yang lama ...

    // TAMBAHKAN KODE INI DI BAGIAN BAWAH (Sebelum }); penutup DOMContentLoaded)
    // Auto-render khusus untuk halaman Preview CV
    const cvPreviewArea = document.getElementById('cvPreviewArea');
    if (cvPreviewArea) {
        const template = cvPreviewArea.dataset.template || 'modern-blue';
        renderTemplate(template);
    }

}); // <- Ini penutup document.addEventListener('DOMContentLoaded', () => {
