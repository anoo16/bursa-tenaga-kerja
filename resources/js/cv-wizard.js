document.addEventListener('DOMContentLoaded', () => {
    /* ==========================
    EDUCATION
    ========================== */

    document
    .getElementById('addEducation')
    ?.addEventListener('click', () => {

        const container =
            document.getElementById('educationContainer');

        container.insertAdjacentHTML(
            'beforeend',

            `
            <div class="education-item">

                 <button
                    type="button"
                    class="btn-delete remove-item">
                    Hapus
                </button>

                <hr>

                <div class="form-grid-2">

                    <input type="text"
                        name="educations[${educationIndex}][school]"
                        class="form-input"
                        placeholder="Nama Universitas">

                    <input type="text"
                        name="educations[${educationIndex}][major]"
                        class="form-input"
                        placeholder="Jurusan">

                    <input type="text"
                        name="educations[${educationIndex}][start_year]"
                        class="form-input"
                        placeholder="Tahun Masuk">

                    <input type="text"
                        name="educations[${educationIndex}][end_year]"
                        class="form-input"
                        placeholder="Tahun Lulus">

                    <input type="text"
                        name="educations[${educationIndex}][gpa]"
                        class="form-input"
                        placeholder="IPK">

                </div>

            </div>
            `
        );

        educationIndex++;
    });

    /* ==========================
    SKILL
    ========================== */

    document
    .getElementById('addSkill')
    ?.addEventListener('click', () => {

        const container =
            document.getElementById('skillContainer');

        container.insertAdjacentHTML(
            'beforeend',

            `
            <div class="skill-item">

                <input
                    type="text"
                    name="skills[${skillIndex}][name]"
                    class="form-input"
                    placeholder="Keahlian">

                 <button
                    type="button"
                    class="btn-delete remove-item">
                    Hapus
                </button>

            </div>
            `
        );

        skillIndex++;
    });

    /* ==========================
    EXPERIENCE
    ========================== */

    document
    .getElementById('addExperience')
    ?.addEventListener('click', () => {

        const container =
            document.getElementById('experienceContainer');

        container.insertAdjacentHTML(
            'beforeend',

            `
            <div class="experience-item">

                <div class="form-grid-2">

                    <input
                        type="text"
                        name="experiences[${experienceIndex}][company]"
                        class="form-input"
                        placeholder="Nama Perusahaan">

                    <input
                        type="text"
                        name="experiences[${experienceIndex}][position]"
                        class="form-input"
                        placeholder="Posisi">

                    <input
                        type="date"
                        name="experiences[${experienceIndex}][start_date]"
                        class="form-input">

                    <input
                        type="date"
                        name="experiences[${experienceIndex}][end_date]"
                        class="form-input">

                </div>

                <textarea
                    class="form-textarea"
                    name="experiences[${experienceIndex}][description]"
                    rows="5"
                    placeholder="Deskripsi pekerjaan"></textarea>

                <button
                    type="button"
                    class="btn-delete remove-item">
                    Hapus
                </button>

            </div>
            `
        );
        
        experienceIndex++;
    });
});

document.addEventListener('click', function(e){

    if(
        e.target.classList.contains('remove-item')
    ){

        e.target
            .closest(
                '.education-item, .experience-item, .skill-item'
            )
            ?.remove();

    }

});

document.addEventListener('DOMContentLoaded', () => {

    /* ==========================
       WIZARD STEP
    ========================== */

    let currentStep = 0;

    const steps =
        document.querySelectorAll('.step-content');

    const menu =
        document.querySelectorAll('.wizard-step');

    const nextBtn =
        document.getElementById('nextBtn');

    const prevBtn =
        document.getElementById('prevBtn');

    const submitBtn =
        document.getElementById('submitBtn');

    const titles = [
        "Personal Biodata",
        "Riwayat Pendidikan",
        "Keahlian",
        "Summary & Organisasi",
        "Pengalaman Kerja"
    ];

    function updateProgress() {

        let completed = 0;

        steps.forEach(step => {

            const inputs =
                step.querySelectorAll(
                    'input, textarea, select'
                );

            let filled = true;

            inputs.forEach(input => {

                if (
                    input.type !== 'button' &&
                    input.type !== 'hidden' &&
                    input.value.trim() === ''
                ) {
                    filled = false;
                }

            });

            if (filled && inputs.length > 0) {
                completed++;
            }

        });

        const percent =
            Math.round(
                (completed / steps.length) * 100
            );

        document.getElementById(
            'progressText'
        ).innerText =
            `Progress: ${percent}%`;

        document.getElementById(
            'progressFill'
        ).style.width =
            `${percent}%`;

    }

    function showStep() {

        steps.forEach((step, index) => {

            step.classList.remove('active');

            if (index === currentStep) {
                step.classList.add('active');
            }

        });

        menu.forEach((item, index) => {

            item.classList.remove('active');
            item.classList.remove('done');

            const circle =
                item.querySelector('.step-circle');

            if (index < currentStep) {

                item.classList.add('done');

                circle.innerHTML = '✓';

            }

            else if (index === currentStep) {

                item.classList.add('active');

                circle.innerHTML =
                    index + 1;

            }

            else {

                circle.innerHTML =
                    index + 1;

            }

        });

        document.getElementById(
            'stepTitle'
        ).innerText =
            titles[currentStep];

        document.getElementById(
            'stepCounter'
        ).innerText =
            String(currentStep + 1)
                .padStart(2, '0')
            + ' / 05';

        prevBtn.style.display =
            currentStep === 0
                ? 'none'
                : 'inline-flex';

        nextBtn.style.display =
            currentStep === steps.length - 1
                ? 'none'
                : 'inline-flex';

        const previewBtn =
            document.getElementById('previewBtn');

        previewBtn.style.display =
            currentStep === steps.length - 1
                ? 'inline-flex'
                : 'none';

        submitBtn.style.display = 'none';

        updateProgress();

    }

    nextBtn?.addEventListener('click', () => {

        if (currentStep < steps.length - 1) {

            currentStep++;

            showStep();

        }

    });

    prevBtn?.addEventListener('click', () => {

        if (currentStep > 0) {

            currentStep--;

            showStep();

        }

    });

    menu.forEach((item, index) => {

        item.addEventListener('click', () => {

            currentStep = index;

            showStep();

        });

    });

    document
        .querySelectorAll(
            'input, textarea'
        )
        .forEach(input => {

            input.addEventListener(
                'input',
                updateProgress
            );

        });

    showStep();

    /* ==========================
       ADD EDUCATION
    ========================== */

    let educationIndex = 1;

    document
        .getElementById('addEducation')
        ?.addEventListener('click', () => {

            const container =
                document.getElementById(
                    'educationContainer'
                );

            container.insertAdjacentHTML(
                'beforeend',

                `
                <div class="education-item">

                    <button
                        type="button"
                        class="btn-delete remove-item">
                        Hapus
                    </button>

                    <div class="form-grid-2">

                        <input
                            type="text"
                            name="educations[${educationIndex}][school]"
                            class="form-input"
                            placeholder="Nama Universitas">

                        <input
                            type="text"
                            name="educations[${educationIndex}][major]"
                            class="form-input"
                            placeholder="Jurusan">

                        <input
                            type="text"
                            name="educations[${educationIndex}][start_year]"
                            class="form-input"
                            placeholder="Tahun Masuk">

                        <input
                            type="text"
                            name="educations[${educationIndex}][end_year]"
                            class="form-input"
                            placeholder="Tahun Lulus">

                        <input
                            type="text"
                            name="educations[${educationIndex}][gpa]"
                            class="form-input"
                            placeholder="IPK">

                    </div>

                </div>
                `
            );

            educationIndex++;

        });

    /* ==========================
       ADD SKILL
    ========================== */

    let skillIndex = 1;

    document
        .getElementById('addSkill')
        ?.addEventListener('click', () => {

            const container =
                document.getElementById(
                    'skillContainer'
                );

            container.insertAdjacentHTML(
                'beforeend',

                `
                <div class="skill-item">

                    <input
                        type="text"
                        name="skills[${skillIndex}][name]"
                        class="form-input"
                        placeholder="Keahlian">

                    <button
                        type="button"
                        class="btn-delete remove-item">
                        Hapus
                    </button>

                </div>
                `
            );

            skillIndex++;

        });

    /* ==========================
       ADD EXPERIENCE
    ========================== */

    let experienceIndex = 1;

    document
        .getElementById('addExperience')
        ?.addEventListener('click', () => {

            const container =
                document.getElementById(
                    'experienceContainer'
                );

            container.insertAdjacentHTML(
                'beforeend',

                `
                <div class="experience-item">

                    <button
                        type="button"
                        class="btn-delete remove-item">
                        Hapus
                    </button>

                    <div class="form-grid-2">

                        <input
                            type="text"
                            name="experiences[${experienceIndex}][company]"
                            class="form-input"
                            placeholder="Nama Perusahaan">

                        <input
                            type="text"
                            name="experiences[${experienceIndex}][position]"
                            class="form-input"
                            placeholder="Posisi">

                        <input
                            type="date"
                            name="experiences[${experienceIndex}][start_date]"
                            class="form-input">

                        <input
                            type="date"
                            name="experiences[${experienceIndex}][end_date]"
                            class="form-input">

                    </div>

                    <textarea
                        class="form-textarea"
                        name="experiences[${experienceIndex}][description]"
                        rows="5"
                        placeholder="Deskripsi pekerjaan"></textarea>

                </div>
                `
            );

            experienceIndex++;

        });

    /* ==========================
       DELETE ITEM
    ========================== */

    document.addEventListener(
        'click',
        function(e) {

            if (
                e.target.classList.contains(
                    'remove-item'
                )
            ) {

                e.target
                    .closest(
                        '.education-item, .skill-item, .experience-item'
                    )
                    ?.remove();

                updateProgress();

            }

        }
    );

    document.getElementById('previewBtn')
    ?.addEventListener('click', () => {

        const form =
            document.getElementById('cvForm');

        form.action =
            '/cv/preview-draft';

        form.method =
            'POST';

        const methodInput =
            form.querySelector(
                'input[name="_method"]'
            );

        if (methodInput) {
            methodInput.remove();
        }

        form.submit();
    });

});
