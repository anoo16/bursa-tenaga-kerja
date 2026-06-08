document.addEventListener("DOMContentLoaded", () => {
    /* ==========================
       CLOSE MODAL
    ========================== */

    const closeButtons = document.querySelectorAll(
        ".modal-close, .modal-close-secondary",
    );

    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            window.history.back();
        });
    });

    /* ==========================
       FORM & USER DATA
    ========================== */

    const form = document.getElementById("profileForm");

    let user = JSON.parse(localStorage.getItem("user")) ?? {};

    user.experiences = Array.isArray(user.experiences) ? user.experiences : [];

    user.educations = Array.isArray(user.educations) ? user.educations : [];

    user.skills = Array.isArray(user.skills) ? user.skills : [];

    user.certifications = Array.isArray(user.certifications)
        ? user.certifications
        : [];

    /* ==========================
       TOGGLE INLINE FORM
    ========================== */

    function setupToggle(buttonId, boxId) {
        const button = document.getElementById(buttonId);
        const box = document.getElementById(boxId);

        if (button && box) {
            button.addEventListener("click", (e) => {
                e.stopPropagation();

                box.classList.toggle("active");
            });
        }
    }

    setupToggle("toggleExperienceForm", "experienceFormBox");

    setupToggle("toggleCertificationForm", "certificationFormBox");

    setupToggle("toggleEducationForm", "educationFormBox");

    /* ==========================
       INPUT ELEMENTS
    ========================== */

    const nameInput = document.querySelector('[name="name"]');
    const headlineInput = document.querySelector('[name="headline"]');
    const locationInput = document.querySelector('[name="location"]');
    const linkedinInput = document.querySelector('[name="linkedin"]');
    const githubInput = document.querySelector('[name="github"]');
    const emailInput = document.querySelector('[name="email"]');
    const phoneInput = document.querySelector('[name="phone"]');
    const summaryInput = document.getElementById("summaryInput");
    const summaryCount = document.getElementById("summaryCount");

    const photoInput = document.getElementById("photoInput");
    const profilePreview = document.getElementById("profilePreview");

    /* ==========================
       INITIAL DATA
    ========================== */

    function fillInitialData() {
        if (nameInput) nameInput.value = user.name ?? "";

        if (headlineInput) headlineInput.value = user.headline ?? "";

        if (locationInput) locationInput.value = user.location ?? "";

        if (linkedinInput) linkedinInput.value = user.linkedin ?? "";

        if (githubInput) githubInput.value = user.github ?? "";

        if (emailInput) emailInput.value = user.email ?? "";

        if (phoneInput) phoneInput.value = user.phone ?? "";

        if (summaryInput) summaryInput.value = user.summary ?? "";

        if (profilePreview) {
            if (user.photo_preview) {
                profilePreview.src = user.photo_preview;
            } else if (user.photo) {
                profilePreview.src = "/storage/" + user.photo;
            }
        }

        updateSummaryCount();

        renderExperiences();

        renderEducations();

        renderSkills();

        renderCertifications();
    }

    /* ==========================
       SUMMARY COUNT
    ========================== */

    function updateSummaryCount() {
        if (summaryInput && summaryCount) {
            summaryCount.textContent = summaryInput.value.length;
        }
    }

    if (summaryInput) {
        summaryInput.addEventListener("input", updateSummaryCount);
    }

    /* ==========================
       PHOTO PREVIEW
    ========================== */

    if (photoInput && profilePreview) {
        photoInput.addEventListener("change", () => {
            const file = photoInput.files[0];

            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                profilePreview.src = e.target.result;

                user.photo_preview = e.target.result;

                localStorage.setItem("user", JSON.stringify(user));
            };

            reader.readAsDataURL(file);
        });
    }

    /* ==========================
       EXPERIENCE
    ========================== */

    const experienceList = document.getElementById("experienceList");
    const addExperienceBtn = document.getElementById("addExperienceBtn");

    function renderExperiences() {
        if (!experienceList) return;

        if (user.experiences.length === 0) {
            experienceList.innerHTML = `
                <p class="empty-text">Belum ada pengalaman kerja</p>
            `;

            return;
        }

        experienceList.innerHTML = user.experiences
            .map((exp, index) => {
                return `
                <div class="info-card">

                    <div class="card-icon">
                        <i class='bx bx-briefcase'></i>
                    </div>

                    <div class="card-content">
                        <h4>${exp.position || "Posisi belum diisi"}</h4>
                        <p>${exp.company || "Perusahaan belum diisi"}</p>
                        <small>${exp.period || "Periode belum diisi"}</small>
                        <p class="dynamic-desc">
                            ${exp.description || "Deskripsi belum diisi"}
                        </p>
                    </div>

                    <div class="card-actions">
                        <i class='bx bx-trash' data-delete-experience="${index}"></i>
                    </div>

                </div>
            `;
            })
            .join("");
    }

    if (addExperienceBtn) {
        addExperienceBtn.addEventListener("click", () => {
            const position = document
                .getElementById("expPosition")
                .value.trim();
            const company = document.getElementById("expCompany").value.trim();
            const period = document.getElementById("expPeriod").value.trim();
            const description = document
                .getElementById("expDescription")
                .value.trim();

            if (!position && !company && !period && !description) {
                alert("Isi minimal satu data pengalaman.");

                return;
            }

            user.experiences.push({
                position,
                company,
                period,
                description,
            });

            document.getElementById("expPosition").value = "";
            document.getElementById("expCompany").value = "";
            document.getElementById("expPeriod").value = "";
            document.getElementById("expDescription").value = "";

            renderExperiences();
        });
    }

    /* ==========================
       EDUCATION
    ========================== */

    const educationList = document.getElementById("educationList");
    const addEducationBtn = document.getElementById("addEducationBtn");

    function renderEducations() {
        if (!educationList) return;

        if (user.educations.length === 0) {
            educationList.innerHTML = `
                <p class="empty-text">Belum ada riwayat pendidikan</p>
            `;

            return;
        }

        educationList.innerHTML = user.educations
            .map((edu, index) => {
                return `
                <div class="info-card">

                    <div class="card-icon">
                        <i class='bx bxs-school'></i>
                    </div>

                    <div class="card-content">
                        <h4>${edu.major || "Jurusan belum diisi"}</h4>
                        <p>${edu.school || "Institusi belum diisi"}</p>
                        <small>
                            ${edu.level || "Jenjang belum diisi"}
                            •
                            ${edu.graduation_year || "Tahun belum diisi"}
                        </small>
                    </div>

                    <div class="card-actions">
                        <i class='bx bx-trash' data-delete-education="${index}"></i>
                    </div>

                </div>
            `;
            })
            .join("");
    }

    if (addEducationBtn) {
        addEducationBtn.addEventListener("click", () => {
            const level = document.getElementById("eduLevel").value.trim();
            const major = document.getElementById("eduMajor").value.trim();
            const school = document.getElementById("eduSchool").value.trim();
            const graduation_year = document
                .getElementById("eduYear")
                .value.trim();

            if (!level && !major && !school && !graduation_year) {
                alert("Isi minimal satu data pendidikan.");

                return;
            }

            user.educations.push({
                level,
                major,
                school,
                graduation_year,
            });

            document.getElementById("eduLevel").value = "";
            document.getElementById("eduMajor").value = "";
            document.getElementById("eduSchool").value = "";
            document.getElementById("eduYear").value = "";

            renderEducations();
        });
    }

    /* ==========================
       SKILLS
    ========================== */

    const skillsList = document.getElementById("skillsList");
    const skillSelect = document.getElementById("skillSelect");
    const addSkillBtn = document.getElementById("addSkillBtn");

    function renderSkills() {
        if (!skillsList) return;

        if (user.skills.length === 0) {
            skillsList.innerHTML = `
                <span class="skill-pill">Belum ada keahlian</span>
            `;

            return;
        }

        skillsList.innerHTML = user.skills
            .map((skill, index) => {
                const skillName =
                    typeof skill === "object" ? skill.name : skill;

                return `
                <span class="skill-pill">
                    ${skillName}
                    <button type="button" data-delete-skill="${index}">
                        ×
                    </button>
                </span>
            `;
            })
            .join("");
    }

    function addSkill() {
        if (!skillSelect) return;

        const value = skillSelect.value;

        if (value === "") return;

        const alreadyExists = user.skills.some((skill) => {
            const skillName = typeof skill === "object" ? skill.name : skill;

            return skillName === value;
        });

        if (alreadyExists) {
            alert("Skill sudah ditambahkan");
            return;
        }

        user.skills.push({
            name: value,
        });

        skillSelect.value = "";

        renderSkills();
    }

    if (addSkillBtn) {
        addSkillBtn.addEventListener("click", addSkill);
    }

    /* ==========================
       CERTIFICATION
    ========================== */

    const certificationList = document.getElementById("certificationList");
    const addCertificationBtn = document.getElementById("addCertificationBtn");

    function renderCertifications() {
        if (!certificationList) return;

        if (user.certifications.length === 0) {
            certificationList.innerHTML = `
                <p class="empty-text">Belum ada sertifikat</p>
            `;

            return;
        }

        certificationList.innerHTML = user.certifications
            .map((cert, index) => {
                return `
                <div class="info-card">

                    <div class="card-icon">
                        <i class='bx bx-award'></i>
                    </div>

                    <div class="card-content">
                        <h4>${cert.title || "Sertifikat belum diisi"}</h4>
                        <p>${cert.issuer || "Penerbit belum diisi"}</p>
                        <small>${cert.year || "Tahun belum diisi"}</small>
                    </div>

                    <div class="card-actions">
                        <i class='bx bx-trash' data-delete-certification="${index}"></i>
                    </div>

                </div>
            `;
            })
            .join("");
    }

    if (addCertificationBtn) {
        addCertificationBtn.addEventListener("click", () => {
            const title = document.getElementById("certTitle").value.trim();
            const issuer = document.getElementById("certIssuer").value.trim();
            const year = document.getElementById("certYear").value.trim();

            if (!title && !issuer && !year) {
                alert("Isi minimal satu data sertifikat.");

                return;
            }

            user.certifications.push({
                title,
                issuer,
                year,
            });

            document.getElementById("certTitle").value = "";
            document.getElementById("certIssuer").value = "";
            document.getElementById("certYear").value = "";

            renderCertifications();
        });
    }

    /* ==========================
       DELETE ITEMS
    ========================== */

    document.addEventListener("click", (e) => {
        const expDelete = e.target.dataset.deleteExperience;
        const eduDelete = e.target.dataset.deleteEducation;
        const skillDelete = e.target.dataset.deleteSkill;
        const certDelete = e.target.dataset.deleteCertification;

        if (expDelete !== undefined) {
            user.experiences.splice(Number(expDelete), 1);

            renderExperiences();
        }

        if (eduDelete !== undefined) {
            user.educations.splice(Number(eduDelete), 1);

            renderEducations();
        }

        if (skillDelete !== undefined) {
            user.skills.splice(Number(skillDelete), 1);

            renderSkills();
        }

        if (certDelete !== undefined) {
            user.certifications.splice(Number(certDelete), 1);

            renderCertifications();
        }
    });

    /* ==========================
       SUBMIT PROFILE
    ========================== */

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const token = localStorage.getItem("token");

            const formData = new FormData(form);

            console.log("TOKEN:", token);

            formData.append("educations", JSON.stringify(user.educations));

            formData.append("experiences", JSON.stringify(user.experiences));

            formData.append("skills", JSON.stringify(user.skills));

            formData.append(
                "certifications",
                JSON.stringify(user.certifications),
            );

            user = {
                ...user,
                name: formData.get("name"),
                headline: formData.get("headline"),
                location: formData.get("location"),
                linkedin: formData.get("linkedin"),
                github: formData.get("github"),
                email: formData.get("email"),
                phone: formData.get("phone"),
                summary: formData.get("summary"),
                experiences: user.experiences,
                educations: user.educations,
                skills: user.skills,
                certifications: user.certifications,
            };

            localStorage.setItem("user", JSON.stringify(user));

            if (token) {
                try {
                    const response = await fetch("/api/profile/update", {
                        method: "POST",

                        headers: {
                            Accept: "application/json",
                            Authorization: `Bearer ${token}`,
                        },

                        body: formData,
                    });

                    const text = await response.text();

                    let result = null;

                    try {
                        result = JSON.parse(text);
                    } catch {
                        console.warn("Response bukan JSON:", text);
                    }

                    if (response.ok && result?.user) {
                        localStorage.setItem(
                            "user",
                            JSON.stringify(result.user),
                        );
                    }
                } catch (error) {
                    console.warn(
                        "Data tersimpan di localStorage, tetapi gagal update API:",
                        error,
                    );
                }
            }

            alert("Profil berhasil disimpan.");

            window.location.href = "/profile";
        });
    }

    fillInitialData();
});
