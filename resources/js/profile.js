document.addEventListener('DOMContentLoaded', () => {

    const user = JSON.parse(
        localStorage.getItem('user')
    );

    if(!user) return;

    // nama
    const profileName =
        document.querySelector('.profile-name');

    if(profileName){
        profileName.textContent =
            user.name ?? 'Nama User';
    }

    // foto
    const profilePhoto =
        document.getElementById('profile-photo');

    if(profilePhoto && user.photo){
        profilePhoto.src =
            '/storage/' + user.photo;
    }

    // ringkasan profesional
    const profileSummary =
        document.getElementById('profile-summary');

    if(profileSummary){

        profileSummary.textContent =
            user.summary?.trim()
                ? user.summary
                : 'Belum ada ringkasan profesional';

    }

    // pengalaman
    const experiencesContainer =
        document.getElementById('profile-experiences');

    if(experiencesContainer){

        if(user.experiences?.length){

            experiencesContainer.innerHTML =
                user.experiences.map(exp => `
                    <div class="experience-item">

                        <div class="exp-header">
                            <h4 class="exp-org">
                                ${exp.company ?? ''}
                            </h4>

                            <span class="exp-period">
                                ${exp.period ?? ''}
                            </span>
                        </div>

                        <div class="exp-role">
                            ${exp.position ?? ''}
                        </div>

                        <p class="exp-desc">
                            ${exp.description ?? ''}
                        </p>

                    </div>
                `).join('');

        }

    }

    // pendidikan
    const educationsContainer =
        document.getElementById('profile-educations');

    if(educationsContainer){

        if(user.educations?.length){

            educationsContainer.innerHTML =
                user.educations.map(edu => `
                    <div class="edu-item">

                        <div class="edu-level">
                            ${edu.level ?? ''}
                        </div>

                        <div class="edu-major">
                            ${edu.major ?? ''}
                        </div>

                        <div class="edu-school">
                            ${edu.school ?? ''}
                            •
                            ${edu.graduation_year ?? ''}
                        </div>

                    </div>
                `).join('');

        }

    }

    // sertifikasi
    const certificationsContainer =
        document.getElementById('profile-certifications');

    if(certificationsContainer){

        if(user.certifications?.length){

            certificationsContainer.innerHTML =
                user.certifications.map(cert => `
                    <li class="sertifikasi-item">
                        ${cert.title}
                    </li>
                `).join('');

        }

    }

    // skill
    const skillsContainer =
        document.getElementById('profile-skills');

    if(skillsContainer){

        if(user.skills?.length){

            skillsContainer.innerHTML =
                user.skills.map(skill => `

                    <span class="skill-tag">
                        ${typeof skill === 'object'
                            ? skill.name
                            : skill}
                    </span>

                `).join('');

        }

    }

    // email
    const profileEmail =
        document.getElementById('profile-email');

    if(profileEmail){
        profileEmail.textContent =
            user.email || 'Belum diisi';
    }

    // lokasi
    const profileLocation =
        document.getElementById('profile-location');

    if(profileLocation){
        profileLocation.textContent =
            user.location || 'Belum diisi';
    }

    // phone
    const profilePhone =
        document.getElementById('profile-phone');

    if(profilePhone){
        profilePhone.textContent =
            user.phone || 'Belum diisi';
    }

    // linkedin
    const profileLinkedin =
        document.getElementById('profile-linkedin');

    if(profileLinkedin){

        if(user.linkedin){

            profileLinkedin.href =
                user.linkedin;

            profileLinkedin.style.display =
                'inline';

        }else{

            profileLinkedin.style.display =
                'none';

        }

    }

    // github
    const profileGithub =
        document.getElementById('profile-github');

    if(profileGithub){

        if(user.github){

            profileGithub.href =
                user.github;

            profileGithub.style.display =
                'inline';

        }else{

            profileGithub.style.display =
                'none';

        }

    }
});