/* ===============================
   ADMIN DASHBOARD USER MANAGEMENT
================================ */

const adminToken =
    localStorage.getItem('token') || sessionStorage.getItem('token');

const adminUserTableBody = document.getElementById('adminUserTableBody');

const shownUserCount = document.getElementById('shownUserCount');

const pendingUserCount = document.getElementById('pendingUserCount');


/* ===============================
   CHECK ADMIN TOKEN
================================ */

if (!adminToken) {

    window.location.href = '/login';

}


/* ===============================
   API HELPER
================================ */

function getAdminHeaders() {

    return {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${adminToken}`
    };

}


function formatDate(dateString) {

    if (!dateString) return '-';

    const date = new Date(dateString);

    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

}


function getUserCode(user) {

    const prefix = user.role_id == 2 ? 'CPY' : 'USR';

    return `#${prefix}-${String(user.id).padStart(4, '0')}`;

}


/* ===============================
   LOAD PENDING RECRUITERS
================================ */

async function loadPendingRecruiters() {

    if (!adminUserTableBody) return;

    adminUserTableBody.innerHTML = `
        <div class="user-table-row">
            <div class="user-id">-</div>

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
                <span class="role-badge company">Company</span>
            </div>

            <div>
                <span class="status-text pending">Loading</span>
            </div>

            <div class="join-date">-</div>

            <div class="action-buttons">-</div>
        </div>
    `;

    try {

        const response = await fetch('/api/admin/recruiters/pending', {
            method: 'GET',
            headers: getAdminHeaders()
        });

        const result = await response.json();

        if (response.status === 401 || response.status === 403) {

            alert('Sesi admin tidak valid. Silakan login kembali.');

            localStorage.removeItem('token');
            localStorage.removeItem('user');

            sessionStorage.removeItem('token');
            sessionStorage.removeItem('user');

            window.location.href = '/login';

            return;

        }

        if (!response.ok) {

            adminUserTableBody.innerHTML = `
                <div class="user-table-row">
                    <div class="user-id">-</div>

                    <div class="user-profile">
                        <div class="company-avatar">
                            <i class='bx bx-error-circle'></i>
                        </div>

                        <div>
                            <h4>Gagal memuat data</h4>
                            <p>${result.message || 'Terjadi kesalahan saat mengambil data.'}</p>
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

        const recruiters = result.data || [];

        renderPendingRecruiters(recruiters);

    } catch (error) {

        console.log(error);

        adminUserTableBody.innerHTML = `
            <div class="user-table-row">
                <div class="user-id">-</div>

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
   RENDER TABLE
================================ */

function renderPendingRecruiters(recruiters) {

    if (shownUserCount) {
        shownUserCount.innerText = recruiters.length;
    }

    if (pendingUserCount) {
        pendingUserCount.innerText = recruiters.length;
    }

    const pendingBadge = document.querySelector('.tab-with-badge span');

    if (pendingBadge) {
        pendingBadge.innerText = recruiters.length;
    }

    if (recruiters.length === 0) {

        adminUserTableBody.innerHTML = `
            <div class="user-table-row">
                <div class="user-id">-</div>

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
                    <span class="role-badge company">Company</span>
                </div>

                <div>
                    <span class="status-text active">Kosong</span>
                </div>

                <div class="join-date">-</div>

                <div class="action-buttons">-</div>
            </div>
        `;

        return;

    }

    adminUserTableBody.innerHTML = recruiters.map(user => {

        const companyName = user.company_name || user.name || 'Nama Perusahaan';

        const email = user.email || '-';

        const createdAt = formatDate(user.created_at);

        return `
            <div class="user-table-row">

                <div class="user-id">
                    ${getUserCode(user)}
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

                    <button
                        class="btn-approve"
                        onclick="approveRecruiter(${user.id})"
                    >
                        Setujui
                    </button>

                    <button
                        class="btn-reject"
                        onclick="rejectRecruiter(${user.id})"
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

async function approveRecruiter(id) {

    const confirmApprove = confirm('Setujui recruiter ini?');

    if (!confirmApprove) return;

    try {

        const response = await fetch(`/api/admin/recruiters/${id}/approve`, {
            method: 'POST',
            headers: getAdminHeaders()
        });

        const result = await response.json();

        if (!response.ok) {

            alert(result.message || 'Gagal menyetujui recruiter.');

            return;

        }

        alert(result.message || 'Recruiter berhasil disetujui.');

        loadPendingRecruiters();

    } catch (error) {

        console.log(error);

        alert('Terjadi kesalahan server.');

    }

}


/* ===============================
   REJECT RECRUITER
================================ */

async function rejectRecruiter(id) {

    const reason = prompt('Masukkan alasan penolakan recruiter:');

    if (reason === null) return;

    try {

        const response = await fetch(`/api/admin/recruiters/${id}/reject`, {
            method: 'POST',
            headers: getAdminHeaders(),
            body: JSON.stringify({
                rejected_reason: reason || 'Pendaftaran recruiter ditolak oleh admin.'
            })
        });

        const result = await response.json();

        if (!response.ok) {

            alert(result.message || 'Gagal menolak recruiter.');

            return;

        }

        alert(result.message || 'Recruiter berhasil ditolak.');

        loadPendingRecruiters();

    } catch (error) {

        console.log(error);

        alert('Terjadi kesalahan server.');

    }

}


/* ===============================
   INIT
================================ */

loadPendingRecruiters();