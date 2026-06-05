/* ===============================
   ELEMENTS
================================ */

const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const recruiterRegisterForm = document.getElementById("recruiterRegisterForm");

const verifyOtpForm = document.getElementById("verifyOtpForm");
const resendOtpBtn = document.getElementById("resendOtpBtn");

const forgotPasswordForm = document.getElementById("forgotPasswordForm");
const verifyResetOtpForm = document.getElementById("verifyResetOtpForm");
const resendResetOtpBtn = document.getElementById("resendResetOtpBtn");
const resetPasswordForm = document.getElementById("resetPasswordForm");

const alertBox = document.getElementById("alertBox");

const jobseekerBtn = document.getElementById("jobseekerBtn");
const recruiterBtn = document.getElementById("recruiterBtn");
const googleLoginWrapper = document.getElementById("googleLoginWrapper");

const registerLink = document.getElementById("registerLink");
const registerTabLink = document.getElementById("registerTabLink");

const otpInputs = document.querySelectorAll(".otp-input");

let selectedRole = "jobseeker";
let otpCountdownInterval = null;

function updateGoogleLoginVisibility() {
    if (!googleLoginWrapper) return;

    if (selectedRole === "recruiter") {
        googleLoginWrapper.classList.add("d-none");
    } else {
        googleLoginWrapper.classList.remove("d-none");
    }
}

/* ===============================
   ROLE SELECTOR LOGIN
================================ */

if (jobseekerBtn && recruiterBtn) {
    jobseekerBtn.classList.add("active-role");

    if (registerLink) {
        registerLink.href = "/register";
    }

    if (registerTabLink) {
        registerTabLink.href = "/register";
    }

    updateGoogleLoginVisibility();

    jobseekerBtn.addEventListener("click", function () {
        selectedRole = "jobseeker";

        jobseekerBtn.classList.add("active-role");
        recruiterBtn.classList.remove("active-role");

        if (registerLink) {
            registerLink.href = "/register";
        }

        if (registerTabLink) {
            registerTabLink.href = "/register";
        }

        updateGoogleLoginVisibility();
    });

    recruiterBtn.addEventListener("click", function () {
        selectedRole = "recruiter";

        recruiterBtn.classList.add("active-role");
        jobseekerBtn.classList.remove("active-role");

        if (registerLink) {
            registerLink.href = "/register/recruiter";
        }

        if (registerTabLink) {
            registerTabLink.href = "/register/recruiter";
        }

        updateGoogleLoginVisibility();
    });
}

/* ===============================
   ALERT HELPER
================================ */

function showAlert(type, message) {
    if (!alertBox) return;

    alertBox.classList.remove("d-none", "alert-success", "alert-danger");

    alertBox.classList.add(`alert-${type}`);
    alertBox.innerHTML = message;
}

function getErrorMessage(result, defaultMessage) {
    if (result && result.message) {
        return result.message;
    }

    if (result && result.errors) {
        const firstErrorKey = Object.keys(result.errors)[0];

        if (
            firstErrorKey &&
            result.errors[firstErrorKey] &&
            result.errors[firstErrorKey][0]
        ) {
            return result.errors[firstErrorKey][0];
        }
    }

    return defaultMessage;
}

/* ===============================
   ONLY NUMBER INPUT HELPER
================================ */

function onlyNumberInput(inputId) {
    const input = document.getElementById(inputId);

    if (!input) return;

    input.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "");
    });
}

onlyNumberInput("phone");
onlyNumberInput("npwp");

/* ===============================
   OTP COUNTDOWN TIMER
================================ */

function startOtpCountdown(expiredAt) {
    const timerText = document.getElementById("otpTimerText");

    if (!timerText || !expiredAt) return;

    if (otpCountdownInterval) {
        clearInterval(otpCountdownInterval);
    }

    function updateTimer() {
        const expiredTime = new Date(expiredAt).getTime();
        const currentTime = new Date().getTime();
        const distance = expiredTime - currentTime;

        if (Number.isNaN(expiredTime)) {
            timerText.textContent = "--:--";

            console.log("Format waktu kedaluwarsa OTP tidak valid.");

            return;
        }

        if (distance <= 0) {
            clearInterval(otpCountdownInterval);

            timerText.textContent = "00:00";

            showAlert(
                "danger",
                "Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode OTP.",
            );

            return;
        }

        const minutes = Math.floor(distance / 1000 / 60);
        const seconds = Math.floor((distance / 1000) % 60);

        timerText.textContent = `${String(minutes).padStart(2, "0")}:${String(seconds).padStart(2, "0")}`;
    }

    updateTimer();

    otpCountdownInterval = setInterval(updateTimer, 1000);
}

/* ===============================
   LOGIN
================================ */

if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const rememberMe = document.getElementById("rememberMe")?.checked;

        try {
            const response = await fetch("/api/auth/login", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                    password,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(
                        result,
                        "Login gagal. Periksa email dan kata sandi Anda.",
                    ),
                );

                return;
            }

            const roleId = Number(result.data.user.role_id);

            if (roleId !== 1) {
                if (selectedRole === "jobseeker" && roleId !== 3) {
                    showAlert("danger", "Akun ini bukan akun Pencari Kerja.");

                    return;
                }

                if (selectedRole === "recruiter" && roleId !== 2) {
                    showAlert("danger", "Akun ini bukan akun Perekrut.");

                    return;
                }
            }

            localStorage.removeItem("token");
            localStorage.removeItem("user");

            sessionStorage.removeItem("token");
            sessionStorage.removeItem("user");

            const storage = rememberMe ? localStorage : sessionStorage;

            storage.setItem("token", result.data.token);
            storage.setItem("user", JSON.stringify(result.data.user));

            if (roleId === 1) {
                window.location.href = "/dashboard/admin";
            } else if (roleId === 2) {
                window.location.href = "/dashboard/company";
            } else {
                window.location.href = "/dashboard/jobseeker";
            }
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   REGISTER JOBSEEKER
================================ */

if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const name = document.getElementById("name").value.trim();
        const email = document.getElementById("email").value.trim();

        const password = document.getElementById("password").value;
        const confirmPassword =
            document.getElementById("confirmPassword").value;

        const education = document.getElementById("education")?.value.trim();
        const birthDate = document.getElementById("birth_date")?.value;
        const phone = document.getElementById("phone")?.value.trim();
        const terms = document.getElementById("jobseekerTerms")?.checked;

        if (password !== confirmPassword) {
            showAlert("danger", "Konfirmasi kata sandi tidak cocok.");

            return;
        }

        if (!terms) {
            showAlert(
                "danger",
                "Anda wajib menyetujui Syarat & Ketentuan serta Kebijakan Privasi.",
            );

            return;
        }

        try {
            const response = await fetch("/api/auth/register", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    name,
                    email,
                    password,
                    password_confirmation: confirmPassword,
                    role_id: 3,
                    education,
                    birth_date: birthDate,
                    phone,
                    terms: terms ? "1" : "0",
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Pendaftaran gagal."),
                );

                return;
            }

            localStorage.setItem("verify_email", result.data.email);
            localStorage.setItem(
                "verify_otp_expired_at",
                result.data.expired_at,
            );

            localStorage.removeItem("verify_otp");

            showAlert(
                "success",
                "Pendaftaran berhasil. Kode OTP telah dikirim ke email Anda.",
            );

            setTimeout(function () {
                window.location.href = "/verify-otp";
            }, 1500);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   RECRUITER FILE VALIDATION
================================ */

function isAllowedRecruiterFile(file) {
    const allowedExtensions = ["pdf", "jpg", "jpeg", "png"];

    const fileExtension = file.name.split(".").pop().toLowerCase();

    return allowedExtensions.includes(fileExtension);
}

function validateRecruiterFile(file, documentName) {
    const maxFileSize = 2 * 1024 * 1024;

    if (!file) {
        showAlert("danger", `${documentName} wajib diunggah.`);

        return false;
    }

    if (!isAllowedRecruiterFile(file)) {
        showAlert(
            "danger",
            `${documentName} harus berupa PDF, JPG, JPEG, atau PNG.`,
        );

        return false;
    }

    if (file.size > maxFileSize) {
        showAlert("danger", `${documentName} maksimal berukuran 2 MB.`);

        return false;
    }

    return true;
}

/* ===============================
   REGISTER RECRUITER
================================ */

if (recruiterRegisterForm) {
    const recruiterFileFields = [
        {
            inputId: "npwp_file",
            labelId: "npwpFileName",
        },
        {
            inputId: "business_license_file",
            labelId: "businessLicenseFileName",
        },
        {
            inputId: "pic_authorization_file",
            labelId: "picAuthorizationFileName",
        },
    ];

    recruiterFileFields.forEach(function (field) {
        const input = document.getElementById(field.inputId);
        const label = document.getElementById(field.labelId);

        if (input && label) {
            input.addEventListener("change", function () {
                label.textContent =
                    this.files.length > 0
                        ? this.files[0].name
                        : "No file chosen";
            });
        }
    });

    recruiterRegisterForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const picName = document.getElementById("pic_name").value.trim();
        const companyName = document
            .getElementById("company_name")
            .value.trim();
        const email = document.getElementById("email").value.trim();

        const password = document.getElementById("password").value;
        const confirmPassword =
            document.getElementById("confirmPassword").value;

        const npwp = document.getElementById("npwp").value.trim();

        const npwpFile = document.getElementById("npwp_file").files[0];
        const businessLicenseFile = document.getElementById(
            "business_license_file",
        ).files[0];
        const picAuthorizationFile = document.getElementById(
            "pic_authorization_file",
        ).files[0];

        const terms = document.getElementById("terms").checked;

        if (password !== confirmPassword) {
            showAlert("danger", "Konfirmasi kata sandi tidak cocok.");

            return;
        }

        if (!npwp) {
            showAlert("danger", "Nomor NPWP wajib diisi.");

            return;
        }

        if (!validateRecruiterFile(npwpFile, "Dokumen NPWP")) {
            return;
        }

        if (!validateRecruiterFile(businessLicenseFile, "Dokumen izin usaha")) {
            return;
        }

        if (!validateRecruiterFile(picAuthorizationFile, "Surat kuasa PIC")) {
            return;
        }

        if (!terms) {
            showAlert(
                "danger",
                "Anda wajib menyetujui Syarat & Ketentuan serta Kebijakan Privasi.",
            );

            return;
        }

        const formData = new FormData();

        formData.append("name", picName);
        formData.append("company_name", companyName);
        formData.append("email", email);

        formData.append("password", password);
        formData.append("password_confirmation", confirmPassword);

        formData.append("role_id", "2");

        formData.append("npwp", npwp);
        formData.append("npwp_file", npwpFile);
        formData.append("business_license_file", businessLicenseFile);
        formData.append("pic_authorization_file", picAuthorizationFile);

        formData.append("terms", "1");

        try {
            const response = await fetch("/api/auth/register", {
                method: "POST",

                headers: {
                    Accept: "application/json",
                },

                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Pendaftaran recruiter gagal."),
                );

                return;
            }

            localStorage.setItem("verify_email", result.data.email);
            localStorage.setItem(
                "verify_otp_expired_at",
                result.data.expired_at,
            );

            localStorage.removeItem("verify_otp");

            showAlert(
                "success",
                "Pendaftaran recruiter berhasil. Kode OTP telah dikirim ke email Anda.",
            );

            setTimeout(function () {
                window.location.href = "/verify-otp";
            }, 1500);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   VERIFY OTP REGISTER
================================ */

if (verifyOtpForm) {
    const verifyEmailInput = document.getElementById("verifyEmail");

    const registerEmail = localStorage.getItem("verify_email");
    const expiredAt = localStorage.getItem("verify_otp_expired_at");

    if (!registerEmail) {
        showAlert(
            "danger",
            "Data verifikasi tidak ditemukan. Silakan daftar ulang.",
        );
    } else {
        verifyEmailInput.value = registerEmail;

        if (expiredAt) {
            startOtpCountdown(expiredAt);
        }
    }

    verifyOtpForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        updateOtpHiddenInput();

        const email = verifyEmailInput.value;
        const otpCode = document.getElementById("otpCode").value.trim();

        if (otpCode.length !== 6) {
            showAlert("danger", "Kode OTP harus terdiri dari 6 digit.");

            return;
        }

        try {
            const response = await fetch("/api/auth/verify-otp", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                    otp_code: otpCode,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Verifikasi OTP gagal."),
                );

                return;
            }

            localStorage.removeItem("verify_email");
            localStorage.removeItem("verify_otp");
            localStorage.removeItem("verify_otp_expired_at");

            showAlert("success", result.message || "Verifikasi akun berhasil.");

            setTimeout(function () {
                window.location.href = "/login";
            }, 1800);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   RESEND OTP REGISTER
================================ */

if (resendOtpBtn) {
    resendOtpBtn.addEventListener("click", async function () {
        const email = localStorage.getItem("verify_email");

        if (!email) {
            showAlert(
                "danger",
                "Data email tidak ditemukan. Silakan daftar ulang.",
            );

            return;
        }

        try {
            const response = await fetch("/api/auth/resend-otp", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Gagal mengirim ulang OTP."),
                );

                return;
            }

            localStorage.setItem(
                "verify_otp_expired_at",
                result.data.expired_at,
            );

            startOtpCountdown(result.data.expired_at);

            clearOtpInputs();

            showAlert("success", "Kode OTP baru telah dikirim ke email Anda.");
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   LOGOUT
================================ */

function logout() {
    localStorage.removeItem("token");
    localStorage.removeItem("user");

    sessionStorage.removeItem("token");
    sessionStorage.removeItem("user");

    window.location.href = "/login";
}

/* ===============================
   CHECK LOGIN
================================ */

function checkLogin() {
    const token =
        localStorage.getItem("token") || sessionStorage.getItem("token");

    if (!token) {
        window.location.href = "/login";
    }
}

/* ===============================
   FORGOT PASSWORD
================================ */

if (forgotPasswordForm) {
    forgotPasswordForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();

        try {
            const response = await fetch("/api/auth/forgot-password", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Email tidak ditemukan."),
                );

                return;
            }

            localStorage.setItem("reset_email", email);
            localStorage.setItem(
                "reset_otp_expired_at",
                result.data.expired_at,
            );

            localStorage.removeItem("reset_otp_testing");
            localStorage.removeItem("reset_otp_verified");
            localStorage.removeItem("reset_otp_code");

            showAlert("success", "Kode OTP telah dikirim ke email Anda.");

            setTimeout(function () {
                window.location.href = "/verify-reset-otp";
            }, 1500);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   VERIFY RESET OTP
================================ */

if (verifyResetOtpForm) {
    const resetVerifyEmailInput = document.getElementById("resetVerifyEmail");

    const resetEmail = localStorage.getItem("reset_email");
    const expiredAt = localStorage.getItem("reset_otp_expired_at");

    if (!resetEmail) {
        showAlert(
            "danger",
            "Data reset kata sandi tidak ditemukan. Silakan ulangi proses lupa kata sandi.",
        );
    } else {
        resetVerifyEmailInput.value = resetEmail;

        if (expiredAt) {
            startOtpCountdown(expiredAt);
        }
    }

    verifyResetOtpForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        updateOtpHiddenInput();

        const email = resetVerifyEmailInput.value;
        const otpCode = document
            .getElementById("resetVerifyOtpCode")
            .value.trim();

        if (otpCode.length !== 6) {
            showAlert("danger", "Kode OTP harus terdiri dari 6 digit.");

            return;
        }

        try {
            const response = await fetch("/api/auth/verify-reset-otp", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                    otp_code: otpCode,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Verifikasi OTP gagal."),
                );

                return;
            }

            localStorage.setItem("reset_otp_verified", "true");
            localStorage.setItem("reset_otp_code", otpCode);

            showAlert(
                "success",
                "Kode OTP berhasil diverifikasi. Mengarahkan ke halaman buat kata sandi baru...",
            );

            setTimeout(function () {
                window.location.href = "/reset-password";
            }, 1500);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   RESEND RESET OTP
================================ */

if (resendResetOtpBtn) {
    resendResetOtpBtn.addEventListener("click", async function () {
        const email = localStorage.getItem("reset_email");

        if (!email) {
            showAlert(
                "danger",
                "Data email tidak ditemukan. Silakan ulangi proses lupa kata sandi.",
            );

            return;
        }

        try {
            const response = await fetch("/api/auth/forgot-password", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Gagal mengirim ulang OTP."),
                );

                return;
            }

            localStorage.setItem(
                "reset_otp_expired_at",
                result.data.expired_at,
            );

            localStorage.removeItem("reset_otp_testing");
            localStorage.removeItem("reset_otp_verified");
            localStorage.removeItem("reset_otp_code");

            startOtpCountdown(result.data.expired_at);

            clearOtpInputs();

            showAlert("success", "Kode OTP baru telah dikirim ke email Anda.");
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   RESET PASSWORD
================================ */

if (resetPasswordForm) {
    resetPasswordForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = localStorage.getItem("reset_email");
        const otpVerified = localStorage.getItem("reset_otp_verified");
        const otpCode = localStorage.getItem("reset_otp_code");

        const password = document.getElementById("password").value;
        const confirmPassword =
            document.getElementById("confirmPassword").value;

        if (!email || otpVerified !== "true" || !otpCode) {
            showAlert(
                "danger",
                "Verifikasi OTP belum selesai. Silakan verifikasi OTP terlebih dahulu.",
            );

            setTimeout(function () {
                window.location.href = "/verify-reset-otp";
            }, 1500);

            return;
        }

        if (password !== confirmPassword) {
            showAlert("danger", "Konfirmasi kata sandi tidak cocok.");

            return;
        }

        if (password.length < 6) {
            showAlert("danger", "Kata sandi minimal 6 karakter.");

            return;
        }

        try {
            const response = await fetch("/api/auth/reset-password", {
                method: "POST",

                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },

                body: JSON.stringify({
                    email,
                    otp_code: otpCode,
                    password,
                    password_confirmation: confirmPassword,
                }),
            });

            const result = await response.json();

            if (!response.ok) {
                showAlert(
                    "danger",
                    getErrorMessage(result, "Reset kata sandi gagal."),
                );

                return;
            }

            localStorage.removeItem("reset_email");
            localStorage.removeItem("reset_otp_testing");
            localStorage.removeItem("reset_otp_expired_at");
            localStorage.removeItem("reset_otp_verified");
            localStorage.removeItem("reset_otp_code");

            showAlert(
                "success",
                "Kata sandi berhasil diperbarui. Mengarahkan ke halaman login...",
            );

            setTimeout(function () {
                window.location.href = "/login";
            }, 1500);
        } catch (error) {
            showAlert("danger", "Terjadi kesalahan server.");

            console.log(error);
        }
    });
}

/* ===============================
   OTP INPUT HANDLER
================================ */

if (otpInputs.length > 0) {
    otpInputs.forEach(function (input, index) {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 1);

            if (this.value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }

            updateOtpHiddenInput();
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "Backspace" && !this.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener("paste", function (e) {
            e.preventDefault();

            const pastedData = e.clipboardData
                .getData("text")
                .replace(/[^0-9]/g, "")
                .slice(0, otpInputs.length);

            otpInputs.forEach(function (otpInput) {
                otpInput.value = "";
            });

            pastedData.split("").forEach(function (character, pasteIndex) {
                if (otpInputs[pasteIndex]) {
                    otpInputs[pasteIndex].value = character;
                }
            });

            updateOtpHiddenInput();

            const nextEmptyInput = Array.from(otpInputs).find(
                function (otpInput) {
                    return !otpInput.value;
                },
            );

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
        .map(function (input) {
            return input.value;
        })
        .join("");

    const otpCodeInput = document.getElementById("otpCode");
    const resetVerifyOtpCodeInput =
        document.getElementById("resetVerifyOtpCode");

    if (otpCodeInput) {
        otpCodeInput.value = otpCode;
    }

    if (resetVerifyOtpCodeInput) {
        resetVerifyOtpCodeInput.value = otpCode;
    }
}

function clearOtpInputs() {
    if (otpInputs.length === 0) return;

    otpInputs.forEach(function (input) {
        input.value = "";
    });

    updateOtpHiddenInput();

    otpInputs[0].focus();
}

/* ===============================
   TOGGLE PASSWORD VISIBILITY
================================ */

window.togglePassword = function (targetOrButton, maybeButton = null) {
    let input = null;
    let button = null;

    if (targetOrButton instanceof HTMLElement) {
        button = targetOrButton;

        const wrapper = button.closest(".password-input-wrapper");

        if (wrapper) {
            input = wrapper.querySelector("input");
        }
    } else {
        input = document.getElementById(targetOrButton);
        button = maybeButton;
    }

    if (!input || !button) {
        return;
    }

    if (input.type === "password") {
        input.type = "text";
        button.textContent = "👁";
        button.setAttribute("aria-label", "Sembunyikan kata sandi");
    } else {
        input.type = "password";
        button.textContent = "👁";
        button.setAttribute("aria-label", "Tampilkan kata sandi");
    }
};
