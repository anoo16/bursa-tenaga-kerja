/* ===============================
   ELEMENTS
================================ */

const loginForm = document.getElementById('loginForm');

const registerForm = document.getElementById('registerForm');

const recruiterRegisterForm = document.getElementById('recruiterRegisterForm');

const forgotPasswordForm = document.getElementById('forgotPasswordForm');

const resetPasswordForm = document.getElementById('resetPasswordForm');

const alertBox = document.getElementById('alertBox');

const jobseekerBtn = document.getElementById('jobseekerBtn');

const recruiterBtn = document.getElementById('recruiterBtn');

const registerLink = document.getElementById('registerLink');

const registerTabLink = document.getElementById('registerTabLink');

let selectedRole = 'jobseeker';


/* ===============================
   ROLE SELECTOR
================================ */

if (jobseekerBtn && recruiterBtn) {

    jobseekerBtn.classList.add('active-role');

    if (registerLink) {
        registerLink.href = '/register';
    }

    if (registerTabLink) {
        registerTabLink.href = '/register';
    }

    jobseekerBtn.addEventListener('click', () => {

        selectedRole = 'jobseeker';

        jobseekerBtn.classList.add('active-role');

        recruiterBtn.classList.remove('active-role');

        if (registerLink) {
            registerLink.href = '/register';
        }

        if (registerTabLink) {
            registerTabLink.href = '/register';
        }

    });

    recruiterBtn.addEventListener('click', () => {

        selectedRole = 'recruiter';

        recruiterBtn.classList.add('active-role');

        jobseekerBtn.classList.remove('active-role');

        if (registerLink) {
            registerLink.href = '/register/recruiter';
        }

        if (registerTabLink) {
            registerTabLink.href = '/register/recruiter';
        }

    });

}


/* ===============================
   ALERT HELPER
================================ */

function showAlert(type, message) {

    if (!alertBox) return;

    alertBox.classList.remove(
        'd-none',
        'alert-success',
        'alert-danger'
    );

    alertBox.classList.add(`alert-${type}`);

    alertBox.innerHTML = message;

}


function getErrorMessage(result, defaultMessage) {

    if (result.message) {
        return result.message;
    }

    if (result.errors) {

        const firstErrorKey = Object.keys(result.errors)[0];

        if (firstErrorKey && result.errors[firstErrorKey][0]) {
            return result.errors[firstErrorKey][0];
        }

    }

    return defaultMessage;

}


/* ===============================
   LOGIN
================================ */

if (loginForm) {

    loginForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const email = document.getElementById('email').value;

        const password = document.getElementById('password').value;

        try {

            const response = await fetch('/api/auth/login', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    email,
                    password
                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Login gagal. Periksa email dan kata sandi Anda.')
                );

                return;

            }

            const roleId = result.data.user.role_id;

            /* ===============================
               VALIDASI ROLE LOGIN
            ================================ */

            if (roleId != 1) {

                if (selectedRole === 'jobseeker' && roleId != 3) {

                    showAlert(
                        'danger',
                        'Akun ini bukan akun Pencari Kerja.'
                    );

                    return;

                }

                if (selectedRole === 'recruiter' && roleId != 2) {

                    showAlert(
                        'danger',
                        'Akun ini bukan akun Perekrut.'
                    );

                    return;

                }

            }

            localStorage.setItem(
                'token',
                result.data.token
            );

            localStorage.setItem(
                'user',
                JSON.stringify(result.data.user)
            );

            if (roleId == 1) {

                window.location.href = '/dashboard/admin';

            } else if (roleId == 2) {

                window.location.href = '/dashboard/recruiter';

            } else {

                window.location.href = '/dashboard/jobseeker';

            }

        } catch (error) {

            showAlert(
                'danger',
                'Terjadi kesalahan server.'
            );

            console.log(error);

        }

    });

}


/* ===============================
   REGISTER JOBSEEKER
================================ */

if (registerForm) {

    registerForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const name = document.getElementById('name').value;

        const email = document.getElementById('email').value;

        const password = document.getElementById('password').value;

        const confirmPassword = document.getElementById('confirmPassword').value;

        const education = document.getElementById('education')?.value;

        const birthDate = document.getElementById('birth_date')?.value;

        const phone = document.getElementById('phone')?.value;

        if (password !== confirmPassword) {

            showAlert(
                'danger',
                'Konfirmasi kata sandi tidak cocok.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/register', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({

                    name,
                    email,
                    password,
                    password_confirmation: confirmPassword,

                    role_id: 3,

                    education,
                    birth_date: birthDate,
                    phone

                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Pendaftaran gagal.')
                );

                return;

            }

            showAlert(
                'success',
                'Pendaftaran berhasil. Mengarahkan ke halaman login...'
            );

            setTimeout(() => {

                window.location.href = '/login';

            }, 1500);

        } catch (error) {

            showAlert(
                'danger',
                'Terjadi kesalahan server.'
            );

            console.log(error);

        }

    });

}


/* ===============================
   REGISTER RECRUITER
================================ */

if (recruiterRegisterForm) {

    recruiterRegisterForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const picName = document.getElementById('pic_name').value;

        const companyName = document.getElementById('company_name').value;

        const email = document.getElementById('email').value;

        const password = document.getElementById('password').value;

        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {

            showAlert(
                'danger',
                'Konfirmasi kata sandi tidak cocok.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/register', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({

                    name: picName,

                    email,

                    password,
                    password_confirmation: confirmPassword,

                    role_id: 2,

                    company_name: companyName

                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Pendaftaran recruiter gagal.')
                );

                return;

            }

            showAlert(
                'success',
                'Pendaftaran recruiter berhasil. Mengarahkan ke halaman login...'
            );

            setTimeout(() => {

                window.location.href = '/login';

            }, 1500);

        } catch (error) {

            showAlert(
                'danger',
                'Terjadi kesalahan server.'
            );

            console.log(error);

        }

    });

}


/* ===============================
   LOGOUT
================================ */

function logout() {

    localStorage.removeItem('token');

    localStorage.removeItem('user');

    window.location.href = '/login';

}


/* ===============================
   CHECK LOGIN
================================ */

function checkLogin() {

    const token = localStorage.getItem('token');

    if (!token) {

        window.location.href = '/login';

    }

}


/* ===============================
   FORGOT PASSWORD
================================ */

if (forgotPasswordForm) {

    forgotPasswordForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const email = document.getElementById('email').value;

        try {

            const response = await fetch('/api/auth/forgot-password', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    email
                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Email tidak ditemukan.')
                );

                return;

            }

            localStorage.setItem('reset_email', email);

            localStorage.setItem('reset_otp', result.data.otp_code);

            showAlert(
                'success',
                'Instruksi pemulihan berhasil dibuat. Mengarahkan ke halaman reset kata sandi...'
            );

            setTimeout(() => {

                window.location.href = '/reset-password';

            }, 1500);

        } catch (error) {

            showAlert(
                'danger',
                'Terjadi kesalahan server.'
            );

            console.log(error);

        }

    });

}


/* ===============================
   RESET PASSWORD
================================ */

if (resetPasswordForm) {

    resetPasswordForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        const email = localStorage.getItem('reset_email');

        const otpCode = localStorage.getItem('reset_otp');

        const passwordInput = document.getElementById('password');

        const confirmPasswordInput = document.getElementById('confirmPassword');

        const password = passwordInput.value;

        const confirmPassword = confirmPasswordInput.value;

        if (!email || !otpCode) {

            showAlert(
                'danger',
                'Data reset kata sandi tidak ditemukan. Silakan ulangi proses lupa kata sandi.'
            );

            return;

        }

        if (password !== confirmPassword) {

            showAlert(
                'danger',
                'Konfirmasi kata sandi tidak cocok.'
            );

            return;

        }

        if (password.length < 6) {

            showAlert(
                'danger',
                'Kata sandi minimal 6 karakter.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/reset-password', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({

                    email,

                    otp_code: otpCode,

                    password,

                    password_confirmation: confirmPassword

                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Reset kata sandi gagal.')
                );

                return;

            }

            localStorage.removeItem('reset_email');

            localStorage.removeItem('reset_otp');

            showAlert(
                'success',
                'Kata sandi berhasil diperbarui. Mengarahkan ke halaman login...'
            );

            setTimeout(() => {

                window.location.href = '/login';

            }, 1500);

        } catch (error) {

            showAlert(
                'danger',
                'Terjadi kesalahan server.'
            );

            console.log(error);

        }

    });

}


/* ===============================
   TOGGLE PASSWORD VISIBILITY
================================ */

window.togglePassword = function (targetOrButton, maybeButton = null) {

    let input = null;

    let button = null;

    if (targetOrButton instanceof HTMLElement) {

        button = targetOrButton;

        const wrapper = button.closest('.password-input-wrapper');

        if (wrapper) {

            input = wrapper.querySelector('input');

        }

    } else {

        const targetId = targetOrButton;

        button = maybeButton;

        input = document.getElementById(targetId);

    }

    if (!input) {

        console.log('Input kata sandi tidak ditemukan.');

        return;

    }

    if (!button) {

        console.log('Tombol toggle tidak ditemukan.');

        return;

    }

    if (input.type === 'password') {

        input.type = 'text';

        button.textContent = '👁';

    } else {

        input.type = 'password';

        button.textContent = '👁';

    }

};