document.addEventListener('DOMContentLoaded', () => {

    // CLOSE MODAL
    const closeBtn = document.querySelector('.modal-close');
    const overlay = document.querySelector('.profile-modal-overlay');

    if(closeBtn && overlay){

        closeBtn.addEventListener('click', () => {

            // sembunyikan modal
            window.history.back();

            // atau kembali ke halaman sebelumnya:
            // window.history.back();

        });

    }

    // SKILL INPUT ENTER
    const skillInput = document.querySelector('.skill-input');
    const skillsWrapper = document.querySelector('.skills-tags');

    if(skillInput && skillsWrapper){

        skillInput.addEventListener('keypress', function(e){

            if(e.key === 'Enter'){

                e.preventDefault();

                const value = skillInput.value.trim();

                if(value !== ''){

                    const skill = document.createElement('span');

                    skill.classList.add('skill-pill');

                    skill.innerText = value;

                    skillsWrapper.appendChild(skill);

                    skillInput.value='';

                }
            }
        });
    }

});