/* ===============================
   ELEMENTS
================================ */

const loginForm = document.getElementById('loginForm');

const registerForm = document.getElementById('registerForm');

const recruiterRegisterForm = document.getElementById('recruiterRegisterForm');

const verifyOtpForm = document.getElementById('verifyOtpForm');

const resendOtpBtn = document.getElementById('resendOtpBtn');

const verifyResetOtpForm = document.getElementById('verifyResetOtpForm');

const resendResetOtpBtn = document.getElementById('resendResetOtpBtn');

const forgotPasswordForm = document.getElementById('forgotPasswordForm');

const resetPasswordForm = document.getElementById('resetPasswordForm');

const alertBox = document.getElementById('alertBox');

const jobseekerBtn = document.getElementById('jobseekerBtn');

const recruiterBtn = document.getElementById('recruiterBtn');

const registerLink = document.getElementById('registerLink');

const registerTabLink = document.getElementById('registerTabLink');

let selectedRole = 'jobseeker';

let otpCountdownInterval = null;


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
   OTP COUNTDOWN TIMER
================================ */

function startOtpCountdown(expiredAt) {

    const timerText = document.getElementById('otpTimerText');

    if (!timerText || !expiredAt) return;

    if (otpCountdownInterval) {
        clearInterval(otpCountdownInterval);
    }

    function updateTimer() {

        const expiredTime = new Date(expiredAt).getTime();

        const currentTime = new Date().getTime();

        const distance = expiredTime - currentTime;

        if (distance <= 0) {

            clearInterval(otpCountdownInterval);

            timerText.innerHTML = '00:00';

            showAlert(
                'danger',
                'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode OTP.'
            );

            return;

        }

        const minutes = Math.floor(distance / 1000 / 60);

        const seconds = Math.floor((distance / 1000) % 60);

        timerText.innerHTML =
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    }

    updateTimer();

    otpCountdownInterval = setInterval(updateTimer, 1000);

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

            localStorage.setItem('verify_email', result.data.email);

            localStorage.setItem('verify_otp', result.data.otp_code);

            localStorage.setItem('verify_otp_expired_at', result.data.expired_at);

            showAlert(
                'success',
                'Pendaftaran berhasil. Mengarahkan ke halaman verifikasi OTP...'
            );

            setTimeout(() => {

                window.location.href = '/verify-otp';

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

            localStorage.setItem('verify_email', result.data.email);

            localStorage.setItem('verify_otp', result.data.otp_code);

            localStorage.setItem('verify_otp_expired_at', result.data.expired_at);

            showAlert(
                'success',
                'Pendaftaran recruiter berhasil. Mengarahkan ke halaman verifikasi OTP...'
            );

            setTimeout(() => {

                window.location.href = '/verify-otp';

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
   VERIFY OTP REGISTER
================================ */

if (verifyOtpForm) {

    const verifyEmailInput = document.getElementById('verifyEmail');

    const otpTestingInfo = document.getElementById('otpTestingInfo');

    const registerEmail = localStorage.getItem('verify_email');

    const testingOtp = localStorage.getItem('verify_otp');

    const expiredAt = localStorage.getItem('verify_otp_expired_at');

    if (!registerEmail) {

        showAlert(
            'danger',
            'Data verifikasi tidak ditemukan. Silakan daftar ulang.'
        );

    } else {

        verifyEmailInput.value = registerEmail;

        if (testingOtp && otpTestingInfo) {

            otpTestingInfo.innerHTML = `Kode OTP testing: <strong>${testingOtp}</strong>`;

        }

        if (expiredAt) {

            startOtpCountdown(expiredAt);

        }

    }

    verifyOtpForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        if (typeof updateOtpHiddenInput === 'function') {

            updateOtpHiddenInput();

        }

        const email = verifyEmailInput.value;

        const otpCode = document.getElementById('otpCode').value.trim();

        if (otpCode.length !== 6) {

            showAlert(
                'danger',
                'Kode OTP harus terdiri dari 6 digit.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/verify-otp', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    email,
                    otp_code: otpCode
                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Verifikasi OTP gagal.')
                );

                return;

            }

            localStorage.removeItem('verify_email');

            localStorage.removeItem('verify_otp');

            localStorage.removeItem('verify_otp_expired_at');

            showAlert(
                'success',
                result.message || 'Verifikasi akun berhasil.'
            );

            setTimeout(() => {

                window.location.href = '/login';

            }, 1800);

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
   RESEND OTP REGISTER
================================ */

if (resendOtpBtn) {

    resendOtpBtn.addEventListener('click', async function () {

        const email = localStorage.getItem('verify_email');

        if (!email) {

            showAlert(
                'danger',
                'Data email tidak ditemukan. Silakan daftar ulang.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/resend-otp', {

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
                    getErrorMessage(result, 'Gagal mengirim ulang OTP.')
                );

                return;

            }

            localStorage.setItem('verify_otp', result.data.otp_code);

            localStorage.setItem('verify_otp_expired_at', result.data.expired_at);

            startOtpCountdown(result.data.expired_at);

            const otpTestingInfo = document.getElementById('otpTestingInfo');

            if (otpTestingInfo) {

                otpTestingInfo.innerHTML = `Kode OTP testing: <strong>${result.data.otp_code}</strong>`;

            }

            clearOtpInputs();

            showAlert(
                'success',
                'Kode OTP baru berhasil dibuat.'
            );

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

            localStorage.setItem('reset_otp_testing', result.data.otp_code);

            localStorage.setItem('reset_otp_expired_at', result.data.expired_at);

            localStorage.removeItem('reset_otp_verified');

            localStorage.removeItem('reset_otp_code');

            showAlert(
                'success',
                'Kode OTP berhasil dibuat. Mengarahkan ke halaman verifikasi OTP...'
            );

            setTimeout(() => {

                window.location.href = '/verify-reset-otp';

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
   VERIFY RESET OTP
================================ */

if (verifyResetOtpForm) {

    const resetVerifyEmailInput = document.getElementById('resetVerifyEmail');

    const resetOtpTestingInfo = document.getElementById('resetOtpTestingInfo');

    const resetEmail = localStorage.getItem('reset_email');

    const testingOtp = localStorage.getItem('reset_otp_testing');

    const expiredAt = localStorage.getItem('reset_otp_expired_at');

    if (!resetEmail) {

        showAlert(
            'danger',
            'Data reset kata sandi tidak ditemukan. Silakan ulangi proses lupa kata sandi.'
        );

    } else {

        resetVerifyEmailInput.value = resetEmail;

        if (testingOtp && resetOtpTestingInfo) {

            resetOtpTestingInfo.innerHTML = `Kode OTP testing: <strong>${testingOtp}</strong>`;

        }

        if (expiredAt) {

            startOtpCountdown(expiredAt);

        }

    }

    verifyResetOtpForm.addEventListener('submit', async function (e) {

        e.preventDefault();

        if (typeof updateOtpHiddenInput === 'function') {

            updateOtpHiddenInput();

        }

        const email = resetVerifyEmailInput.value;

        const otpCode = document.getElementById('resetVerifyOtpCode').value.trim();

        if (otpCode.length !== 6) {

            showAlert(
                'danger',
                'Kode OTP harus terdiri dari 6 digit.'
            );

            return;

        }

        try {

            const response = await fetch('/api/auth/verify-reset-otp', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    email,
                    otp_code: otpCode
                })

            });

            const result = await response.json();

            if (!response.ok) {

                showAlert(
                    'danger',
                    getErrorMessage(result, 'Verifikasi OTP gagal.')
                );

                return;

            }

            localStorage.setItem('reset_otp_verified', 'true');

            localStorage.setItem('reset_otp_code', otpCode);

            showAlert(
                'success',
                'Kode OTP berhasil diverifikasi. Mengarahkan ke halaman buat kata sandi baru...'
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
   RESEND RESET OTP
================================ */

if (resendResetOtpBtn) {

    resendResetOtpBtn.addEventListener('click', async function () {

        const email = localStorage.getItem('reset_email');

        if (!email) {

            showAlert(
                'danger',
                'Data email tidak ditemukan. Silakan ulangi proses lupa kata sandi.'
            );

            return;

        }

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
                    getErrorMessage(result, 'Gagal mengirim ulang OTP.')
                );

                return;

            }

            localStorage.setItem('reset_otp_testing', result.data.otp_code);

            localStorage.setItem('reset_otp_expired_at', result.data.expired_at);

            startOtpCountdown(result.data.expired_at);

            localStorage.removeItem('reset_otp_verified');

            localStorage.removeItem('reset_otp_code');

            const resetOtpTestingInfo = document.getElementById('resetOtpTestingInfo');

            if (resetOtpTestingInfo) {

                resetOtpTestingInfo.innerHTML = `Kode OTP testing: <strong>${result.data.otp_code}</strong>`;

            }

            clearOtpInputs();

            showAlert(
                'success',
                'Kode OTP baru berhasil dibuat.'
            );

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

        const otpVerified = localStorage.getItem('reset_otp_verified');

        const otpCode = localStorage.getItem('reset_otp_code');

        const passwordInput = document.getElementById('password');

        const confirmPasswordInput = document.getElementById('confirmPassword');

        const password = passwordInput.value;

        const confirmPassword = confirmPasswordInput.value;

        if (!email || otpVerified !== 'true' || !otpCode) {

            showAlert(
                'danger',
                'Verifikasi OTP belum selesai. Silakan verifikasi OTP terlebih dahulu.'
            );

            setTimeout(() => {

                window.location.href = '/verify-reset-otp';

            }, 1500);

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

            localStorage.removeItem('reset_otp_testing');

            localStorage.removeItem('reset_otp_expired_at');

            localStorage.removeItem('reset_otp_verified');

            localStorage.removeItem('reset_otp_code');

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
   OTP INPUT HANDLER
================================ */

const otpInputs = document.querySelectorAll('.otp-input');

if (otpInputs.length > 0) {

    otpInputs.forEach((input, index) => {

        input.addEventListener('input', function () {

            this.value = this.value.replace(/[^0-9]/g, '');

            if (this.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            updateOtpHiddenInput();

        });

        input.addEventListener('keydown', function (e) {

            if (e.key === 'Backspace' && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }

        });

        input.addEventListener('paste', function (e) {

            e.preventDefault();

            const pastedData = e.clipboardData
                .getData('text')
                .replace(/[^0-9]/g, '')
                .slice(0, 6);

            pastedData.split('').forEach((char, pasteIndex) => {

                if (otpInputs[pasteIndex]) {
                    otpInputs[pasteIndex].value = char;
                }

            });

            updateOtpHiddenInput();

            const nextEmptyInput = Array.from(otpInputs).find(input => !input.value);

            if (nextEmptyInput) {
                nextEmptyInput.focus();
            } else {
                otpInputs[otpInputs.length - 1].focus();
            }

        });

    });

}


function updateOtpHiddenInput() {

    const otpCode = Array.from(otpInputs)
        .map(input => input.value)
        .join('');

    const resetVerifyOtpCode = document.getElementById('resetVerifyOtpCode');

    const otpCodeInput = document.getElementById('otpCode');

    if (resetVerifyOtpCode) {
        resetVerifyOtpCode.value = otpCode;
    }

    if (otpCodeInput) {
        otpCodeInput.value = otpCode;
    }

}


function clearOtpInputs() {

    if (otpInputs.length > 0) {

        otpInputs.forEach(input => {
            input.value = '';
        });

        updateOtpHiddenInput();

        otpInputs[0].focus();

    }

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