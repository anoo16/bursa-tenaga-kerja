/* ===============================
   ADMIN DASHBOARD USER MANAGEMENT
================================ */

const adminToken =
    localStorage.getItem('token') ||
    sessionStorage.getItem('token');

const adminUserTableBody = document.getElementById('adminUserTableBody');
const shownUserCount = document.getElementById('shownUserCount');
const pendingUserCount = document.getElementById('pendingUserCount');

const recruiterDetailLoading = document.getElementById('recruiterDetailLoading');
const recruiterDetailContent = document.getElementById('recruiterDetailContent');
const adminDetailAlert = document.getElementById('adminDetailAlert');


/* ===============================
   CHECK ADMIN TOKEN
================================ */

if (!adminToken) {
    window.location.href = '/login';
}


/* ===============================
   GENERAL HELPERS
================================ */

function getAdminHeaders(includeContentType = true) {

    const headers = {
        'Accept': 'application/json',
        'Authorization': `Bearer ${adminToken}`
    };

    if (includeContentType) {
        headers['Content-Type'] = 'application/json';
    }

    return headers;

}


function clearAdminSession() {

    localStorage.removeItem('token');
    localStorage.removeItem('user');

    sessionStorage.removeItem('token');
    sessionStorage.removeItem('user');

}


function handleUnauthorizedResponse(response) {

    if (response.status === 401 || response.status === 403) {

        alert('Sesi admin tidak valid. Silakan login kembali.');

        clearAdminSession();

        window.location.href = '/login';

        return true;

    }

    return false;

}


function escapeHtml(value) {

    if (value === null || value === undefined) {
        return '-';
    }

    return String(value)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

}


function formatDate(dateString) {

    if (!dateString) {
        return '-';
    }

    const date = new Date(dateString);

    if (Number.isNaN(date.getTime())) {
        return '-';
    }

    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

}


function getUserCode(user) {

    const prefix = Number(user.role_id) === 2 ? 'CPY' : 'USR';

    return `#${prefix}-${String(user.id).padStart(4, '0')}`;

}


function getRecruiterIdFromUrl() {

    const match = window.location.pathname.match(
        /\/dashboard\/admin\/recruiters\/(\d+)\/?$/
    );

    return match ? match[1] : null;

}


function setTextById(elementId, value) {

    const element = document.getElementById(elementId);

    if (element) {
        element.textContent = value ?? '-';
    }

}


function showDetailAlert(type, message) {

    if (!adminDetailAlert) {
        return;
    }

    adminDetailAlert.classList.remove('d-none', 'success', 'danger');
    adminDetailAlert.classList.add(type);
    adminDetailAlert.textContent = message;

}


function hideDetailLoading() {

    if (recruiterDetailLoading) {
        recruiterDetailLoading.classList.add('d-none');
    }

}


function showDetailContent() {

    if (recruiterDetailContent) {
        recruiterDetailContent.classList.remove('d-none');
    }

}


/* ===============================
   LOAD PENDING RECRUITERS TABLE
================================ */

async function loadPendingRecruiters() {

    if (!adminUserTableBody) {
        return;
    }

    adminUserTableBody.innerHTML = `
        <div class="user-table-row">

            <div class="user-id">
                -
            </div>

            <div class="user-profile">

                <div class="company-avatar">
                    <i class='bx bx-loader-circle bx-spin'></i>
                </div>

                <div>
                    <h4>Memuat data...</h4>
                    <p>Mengambil data recruiter pending</p>
                </div>

            </div>

            <div>
                <span class="role-badge company">
                    Company
                </span>
            </div>

            <div>
                <span class="status-text pending">
                    Loading
                </span>
            </div>

            <div class="join-date">
                -
            </div>

            <div class="action-buttons">
                -
            </div>

        </div>
    `;

    try {

        const response = await fetch('/api/admin/recruiters/pending', {
            method: 'GET',
            headers: getAdminHeaders(false)
        });

        if (handleUnauthorizedResponse(response)) {
            return;
        }

        const result = await response.json();

        if (!response.ok) {

            adminUserTableBody.innerHTML = `
                <div class="user-table-row">

                    <div class="user-id">
                        -
                    </div>

                    <div class="user-profile">

                        <div class="company-avatar">
                            <i class='bx bx-error-circle'></i>
                        </div>

                        <div>
                            <h4>Gagal memuat data</h4>
                            <p>${escapeHtml(result.message || 'Terjadi kesalahan saat mengambil data.')}</p>
                        </div>

                    </div>

                    <div>-</div>
                    <div>-</div>
                    <div>-</div>
                    <div>-</div>

                </div>
            `;

            return;

        }

        renderPendingRecruiters(result.data || []);

    } catch (error) {

        console.log(error);

        adminUserTableBody.innerHTML = `
            <div class="user-table-row">

                <div class="user-id">
                    -
                </div>

                <div class="user-profile">

                    <div class="company-avatar">
                        <i class='bx bx-wifi-off'></i>
                    </div>

                    <div>
                        <h4>Server tidak merespons</h4>
                        <p>Pastikan Laravel sedang berjalan.</p>
                    </div>

                </div>

                <div>-</div>
                <div>-</div>
                <div>-</div>
                <div>-</div>

            </div>
        `;

    }

}


/* ===============================
   RENDER PENDING TABLE
================================ */

function renderPendingRecruiters(recruiters) {

    if (!adminUserTableBody) {
        return;
    }

    if (shownUserCount) {
        shownUserCount.textContent = recruiters.length;
    }

    if (pendingUserCount) {
        pendingUserCount.textContent = recruiters.length;
    }

    const pendingBadge = document.querySelector('.tab-with-badge span');

    if (pendingBadge) {
        pendingBadge.textContent = recruiters.length;
    }

    if (recruiters.length === 0) {

        adminUserTableBody.innerHTML = `
            <div class="user-table-row">

                <div class="user-id">
                    -
                </div>

                <div class="user-profile">

                    <div class="company-avatar">
                        <i class='bx bx-check-circle'></i>
                    </div>

                    <div>
                        <h4>Tidak ada recruiter pending</h4>
                        <p>Semua pendaftar recruiter sudah ditinjau.</p>
                    </div>

                </div>

                <div>
                    <span class="role-badge company">
                        Company
                    </span>
                </div>

                <div>
                    <span class="status-text active">
                        Kosong
                    </span>
                </div>

                <div class="join-date">
                    -
                </div>

                <div class="action-buttons">
                    -
                </div>

            </div>
        `;

        return;

    }

    adminUserTableBody.innerHTML = recruiters.map(function (user) {

        const userId = Number(user.id);
        const companyName = escapeHtml(
            user.company_name ||
            user.name ||
            'Nama Perusahaan'
        );

        const email = escapeHtml(user.email || '-');
        const createdAt = escapeHtml(formatDate(user.created_at));
        const userCode = escapeHtml(getUserCode(user));

        return `
            <div class="user-table-row">

                <div class="user-id">
                    ${userCode}
                </div>

                <div class="user-profile">

                    <div class="company-avatar">
                        <i class='bx bx-buildings'></i>
                    </div>

                    <div>
                        <h4>
                            ${companyName}
                            <i class='bx bx-link-external'></i>
                        </h4>

                        <p>${email}</p>
                    </div>

                </div>

                <div>
                    <span class="role-badge company">
                        Company
                    </span>
                </div>

                <div>
                    <span class="status-text pending">
                        Pending
                    </span>
                </div>

                <div class="join-date">
                    ${createdAt}
                </div>

                <div class="action-buttons">

                    <a
                        href="/dashboard/admin/recruiters/${userId}"
                        class="btn-detail"
                    >
                        Detail
                    </a>

                    <button
                        type="button"
                        class="btn-approve"
                        onclick="approveRecruiter(${userId})"
                    >
                        Setujui
                    </button>

                    <button
                        type="button"
                        class="btn-reject"
                        onclick="rejectRecruiter(${userId})"
                    >
                        Tolak
                    </button>

                </div>

            </div>
        `;

    }).join('');

}


/* ===============================
   APPROVE RECRUITER
================================ */

async function approveRecruiter(id, redirectAfterSuccess = false) {

    const confirmApprove = confirm('Setujui recruiter ini?');

    if (!confirmApprove) {
        return;
    }

    try {

        const response = await fetch(`/api/admin/recruiters/${id}/approve`, {
            method: 'POST',
            headers: getAdminHeaders()
        });

        if (handleUnauthorizedResponse(response)) {
            return;
        }

        const result = await response.json();

        if (!response.ok) {

            if (adminDetailAlert) {

                showDetailAlert(
                    'danger',
                    result.message || 'Gagal menyetujui recruiter.'
                );

            } else {

                alert(result.message || 'Gagal menyetujui recruiter.');

            }

            return;

        }

        if (redirectAfterSuccess) {

            showDetailAlert(
                'success',
                result.message || 'Recruiter berhasil disetujui.'
            );

            disableDetailActionButtons();

            setTimeout(function () {
                window.location.href = '/dashboard/admin';
            }, 1300);

        } else {

            alert(result.message || 'Recruiter berhasil disetujui.');

            loadPendingRecruiters();

        }

    } catch (error) {

        console.log(error);

        if (adminDetailAlert) {

            showDetailAlert(
                'danger',
                'Terjadi kesalahan saat menyetujui recruiter.'
            );

        } else {

            alert('Terjadi kesalahan saat menyetujui recruiter.');

        }

    }

}


/* ===============================
   REJECT RECRUITER
================================ */

async function rejectRecruiter(id, redirectAfterSuccess = false) {

    const reason = prompt('Masukkan alasan penolakan recruiter:');

    if (reason === null) {
        return;
    }

    try {

        const response = await fetch(`/api/admin/recruiters/${id}/reject`, {
            method: 'POST',
            headers: getAdminHeaders(),
            body: JSON.stringify({
                rejected_reason:
                    reason.trim() ||
                    'Pendaftaran recruiter ditolak oleh admin.'
            })
        });

        if (handleUnauthorizedResponse(response)) {
            return;
        }

        const result = await response.json();

        if (!response.ok) {

            if (adminDetailAlert) {

                showDetailAlert(
                    'danger',
                    result.message || 'Gagal menolak recruiter.'
                );

            } else {

                alert(result.message || 'Gagal menolak recruiter.');

            }

            return;

        }

        if (redirectAfterSuccess) {

            showDetailAlert(
                'success',
                result.message || 'Recruiter berhasil ditolak.'
            );

            disableDetailActionButtons();

            setTimeout(function () {
                window.location.href = '/dashboard/admin';
            }, 1300);

        } else {

            alert(result.message || 'Recruiter berhasil ditolak.');

            loadPendingRecruiters();

        }

    } catch (error) {

        console.log(error);

        if (adminDetailAlert) {

            showDetailAlert(
                'danger',
                'Terjadi kesalahan saat menolak recruiter.'
            );

        } else {

            alert('Terjadi kesalahan saat menolak recruiter.');

        }

    }

}


function disableDetailActionButtons() {

    const approveButton = document.getElementById('detailApproveBtn');
    const rejectButton = document.getElementById('detailRejectBtn');

    if (approveButton) {
        approveButton.disabled = true;
    }

    if (rejectButton) {
        rejectButton.disabled = true;
    }

}


/* ===============================
   DETAIL RECRUITER PAGE
================================ */

async function loadRecruiterDetail() {

    if (!recruiterDetailContent || !recruiterDetailLoading) {
        return;
    }

    const recruiterId = getRecruiterIdFromUrl();

    if (!recruiterId) {

        hideDetailLoading();

        showDetailAlert(
            'danger',
            'ID recruiter tidak valid.'
        );

        return;

    }

    try {

        const response = await fetch(`/api/admin/recruiters/${recruiterId}`, {
            method: 'GET',
            headers: getAdminHeaders(false)
        });

        if (handleUnauthorizedResponse(response)) {
            return;
        }

        const result = await response.json();

        if (!response.ok) {

            hideDetailLoading();

            showDetailAlert(
                'danger',
                result.message || 'Detail recruiter gagal dimuat.'
            );

            return;

        }

        renderRecruiterDetail(result.data);

    } catch (error) {

        console.log(error);

        hideDetailLoading();

        showDetailAlert(
            'danger',
            'Terjadi kesalahan saat mengambil detail recruiter.'
        );

    }

}


function renderRecruiterDetail(user) {

    try {

        const companyName =
            user.company_name ||
            user.name ||
            '-';

        const status =
            user.approval_status ||
            'pending';

        setTextById('detailBreadcrumbName', companyName);
        setTextById('detailCompanyName', companyName);
        setTextById('detailEmail', user.email || '-');
        setTextById('detailRoleText', 'Company / Recruiter');

        setTextById(
            'detailUserCode',
            user.user_code || getUserCode(user)
        );

        setTextById(
            'detailPicName',
            user.name || '-'
        );

        setTextById(
            'detailCompanyField',
            companyName
        );

        setTextById(
            'detailBusinessEmail',
            user.email || '-'
        );

        setTextById(
            'detailNpwp',
            user.npwp || '-'
        );

        setTextById(
            'detailCreatedAt',
            formatDate(user.created_at)
        );

        setTextById(
            'detailVerificationStatus',
            user.is_verified
                ? 'Terverifikasi'
                : 'Belum Terverifikasi'
        );

        setTextById(
            'detailAccountStatus',
            status === 'approved'
                ? 'Aktif'
                : status === 'rejected'
                    ? 'Ditolak'
                    : 'Menunggu Persetujuan'
        );

        renderApprovalStatus(status);
        setupDetailApprovalButtons(user, status);
        setupDetailDocumentButtons(user);
        setupDocumentPanelToggle();

        hideDetailLoading();
        showDetailContent();

    } catch (error) {

        console.log(error);

        hideDetailLoading();

        showDetailAlert(
            'danger',
            'Data recruiter diterima, tetapi tampilan detail gagal dirender. Periksa kecocokan ID pada file Blade.'
        );

    }

}


function renderApprovalStatus(status) {

    const statusElement = document.getElementById('detailApprovalStatus');

    if (!statusElement) {
        return;
    }

    statusElement.classList.remove(
        'pending',
        'approved',
        'rejected'
    );

    if (status === 'approved') {

        statusElement.textContent = 'Disetujui';
        statusElement.classList.add('approved');

    } else if (status === 'rejected') {

        statusElement.textContent = 'Ditolak';
        statusElement.classList.add('rejected');

    } else {

        statusElement.textContent = 'Pending';
        statusElement.classList.add('pending');

    }

}


function setupDetailApprovalButtons(user, status) {

    const approveButton = document.getElementById('detailApproveBtn');
    const rejectButton = document.getElementById('detailRejectBtn');

    if (approveButton) {

        approveButton.onclick = function () {
            approveRecruiter(user.id, true);
        };

        approveButton.disabled = status !== 'pending';

    }

    if (rejectButton) {

        rejectButton.onclick = function () {
            rejectRecruiter(user.id, true);
        };

        rejectButton.disabled = status !== 'pending';

    }

}


function setupDetailDocumentButtons(user) {

    const documents = user.documents || {};

    setupDocumentButton(
        'viewNpwpDocumentBtn',
        user.id,
        'npwp',
        Boolean(documents.npwp),
        'Dokumen NPWP'
    );

    setupDocumentButton(
        'viewBusinessLicenseBtn',
        user.id,
        'business-license',
        Boolean(documents.business_license),
        'Izin Usaha'
    );

    setupDocumentButton(
        'viewPicAuthorizationBtn',
        user.id,
        'pic-authorization',
        Boolean(documents.pic_authorization),
        'Surat Kuasa PIC'
    );

}


function setupDocumentPanelToggle() {

    const documentToggleButton =
        document.getElementById('detailDocumentToggleBtn');

    const documentPanel =
        document.getElementById('detailDocumentPanel');

    if (!documentToggleButton || !documentPanel) {
        return;
    }

    documentToggleButton.onclick = function () {

        documentPanel.classList.toggle('d-none');

    };

}


function setupDocumentButton(
    buttonId,
    recruiterId,
    documentType,
    isAvailable,
    label
) {

    const button = document.getElementById(buttonId);

    if (!button) {
        return;
    }

    if (!isAvailable) {

        button.disabled = true;

        button.innerHTML = `
            <i class='bx bx-file'></i>
            Tidak Tersedia
        `;

        return;

    }

    button.disabled = false;

    button.innerHTML = `
        <i class='bx bx-file'></i>
        ${label}
    `;

    button.onclick = function () {
        openRecruiterDocument(recruiterId, documentType);
    };

}


/* ===============================
   OPEN PROTECTED DOCUMENT
================================ */

async function openRecruiterDocument(recruiterId, documentType) {

    const documentWindow = window.open('', '_blank');

    try {

        const response = await fetch(
            `/api/admin/recruiters/${recruiterId}/documents/${documentType}`,
            {
                method: 'GET',
                headers: getAdminHeaders(false)
            }
        );

        if (handleUnauthorizedResponse(response)) {

            if (documentWindow) {
                documentWindow.close();
            }

            return;

        }

        if (!response.ok) {

            if (documentWindow) {
                documentWindow.close();
            }

            let message = 'Dokumen gagal dibuka.';

            try {

                const result = await response.json();

                message =
                    result.message ||
                    message;

            } catch (error) {

                console.log(error);

            }

            showDetailAlert('danger', message);

            return;

        }

        const fileBlob = await response.blob();
        const documentUrl = URL.createObjectURL(fileBlob);

        if (documentWindow) {

            documentWindow.location.href = documentUrl;

        } else {

            const temporaryLink = document.createElement('a');

            temporaryLink.href = documentUrl;
            temporaryLink.target = '_blank';
            temporaryLink.rel = 'noopener';
            temporaryLink.click();

        }

        setTimeout(function () {
            URL.revokeObjectURL(documentUrl);
        }, 60000);

    } catch (error) {

        console.log(error);

        if (documentWindow) {
            documentWindow.close();
        }

        showDetailAlert(
            'danger',
            'Terjadi kesalahan saat membuka dokumen.'
        );

    }

}


/* ===============================
   EXPOSE FUNCTIONS FOR TABLE BUTTONS
================================ */

window.approveRecruiter = approveRecruiter;
window.rejectRecruiter = rejectRecruiter;


/* ===============================
   INIT
================================ */

if (adminUserTableBody) {
    loadPendingRecruiters();
}

if (recruiterDetailContent && recruiterDetailLoading) {
    loadRecruiterDetail();
}