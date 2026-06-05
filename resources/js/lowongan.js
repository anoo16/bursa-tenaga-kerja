let activeJob = null;

/* ---- Buka Pop-up Tambah Lowongan ---- */
window.bukaModal = function () {
    const overlay = document.getElementById("modal-overlay");
    const box = document.getElementById("modal-box");
    if (overlay && box) {
        overlay.classList.remove("opacity-0", "pointer-events-none");
        overlay.classList.add("opacity-100", "pointer-events-auto");
        setTimeout(() => {
            box.classList.remove("scale-95", "opacity-0");
            box.classList.add("scale-100", "opacity-100");
        }, 10);
        document.body.style.overflow = "hidden";
    }
};

/* ---- Tutup Pop-up Tambah Lowongan ---- */
window.tutupModal = function () {
    const overlay = document.getElementById("modal-overlay");
    const box = document.getElementById("modal-box");
    if (overlay && box) {
        box.classList.remove("scale-100", "opacity-100");
        box.classList.add("scale-95", "opacity-0");
        setTimeout(() => {
            overlay.classList.remove("opacity-100", "pointer-events-auto");
            overlay.classList.add("opacity-0", "pointer-events-none");
        }, 250);
        document.body.style.overflow = "";
    }
};

/* ---- Klik luar pop-up ---- */
document.addEventListener("DOMContentLoaded", function () {
    const modalOverlay = document.getElementById("modal-overlay");
    if (modalOverlay) {
        modalOverlay.addEventListener("click", function (e) {
            if (e.target === this) tutupModal();
        });
    }

    /* ---- Format Rupiah ---- */
    document.querySelectorAll(".format-rupiah").forEach((input) => {
        input.addEventListener("input", function () {
            let angka = this.value.replace(/\D/g, "");
            let rupiah = new Intl.NumberFormat("id-ID").format(angka);
            this.value = angka ? "Rp " + rupiah : "";

            if (this.id === "gaji-min" || this.id === "gaji-max") {
                gabungGaji();
            } else if (
                this.id === "edit-gaji-min" ||
                this.id === "edit-gaji-max"
            ) {
                gabungGajiEdit();
            }
        });
    });

    const btnKonfirmasiHapus = document.getElementById("btn-konfirmasi-hapus");
    if (btnKonfirmasiHapus) {
        btnKonfirmasiHapus.addEventListener("click", function () {
            if (formHapus) {
                formHapus.submit();
            }
        });
    }

    const formLowongan = document.getElementById("form-lowongan");
    if (formLowongan) {
        formLowongan.addEventListener("submit", function (e) {
            if (!validasiFormLowongan(this)) {
                e.preventDefault();
            }
        });
    }

    const formEditLowongan = document.getElementById("form-edit-lowongan");
    if (formEditLowongan) {
        formEditLowongan.addEventListener("submit", function (e) {
            if (!validasiFormLowongan(this)) {
                e.preventDefault();
            }
        });
    }

    /* ---- Auto Hide Notifikasi ---- */
    document.querySelectorAll('[id^="notif-"]').forEach((notif) => {
        setTimeout(() => {
            notif.style.opacity = "0";
            setTimeout(() => notif.remove(), 500);
        }, 4000);
    });
});

/* ---- ESC tutup pop-up ---- */
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        tutupModal();
        tutupDetail();
        tutupEdit();
    }
});

/* ---- Tambah item dinamis ---- */
window.tambahItem = function (listId, fieldName, placeholder) {
    const list = document.getElementById(listId);
    if (!list) return;
    const prefix = listId.includes("tanggung")
        ? "item-tanggung-jawab"
        : "item-kualifikasi";
    const div = document.createElement("div");
    div.className = `flex items-start gap-2 ${prefix}`;
    div.innerHTML = `
        <textarea name="${fieldName}" rows="2" placeholder="${placeholder}" required class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none"></textarea>
        <button type="button" onclick="hapusItem(this, '${listId}')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
    `;
    list.appendChild(div);
    perbaruiTombolHapus(listId, prefix);
};

/* ---- Hapus item ---- */
window.hapusItem = function (btn, listId) {
    const prefix = listId.includes("tanggung")
        ? "item-tanggung-jawab"
        : "item-kualifikasi";
    const list = document.getElementById(listId);
    if (!list) return;
    const items = list.querySelectorAll(`.${prefix}`);
    if (items.length <= 1) return;
    btn.closest(`.${prefix}`).remove();
    perbaruiTombolHapus(listId, prefix);
};

/* ---- Update tombol hapus ---- */
window.perbaruiTombolHapus = function (listId, prefix) {
    const list = document.getElementById(listId);
    if (!list) return;
    const items = list.querySelectorAll(`.${prefix}`);
    items.forEach((item) => {
        const btn = item.querySelector("button");
        if (btn) {
            btn.style.display = items.length > 1 ? "flex" : "none";
        }
    });
};

window.gabungGaji = function () {
    const minInput = document.getElementById("gaji-min");
    const maxInput = document.getElementById("gaji-max");
    const finalInput = document.getElementById("gaji-final");
    if (minInput && maxInput && finalInput) {
        finalInput.value = minInput.value + " - " + maxInput.value;
    }
};

window.gabungGajiEdit = function () {
    const minInput = document.getElementById("edit-gaji-min");
    const maxInput = document.getElementById("edit-gaji-max");
    const finalInput = document.getElementById("edit-gaji-final");
    if (minInput && maxInput && finalInput) {
        finalInput.value = minInput.value + " - " + maxInput.value;
    }
};

/* ---- Detail Lowongan ---- */
window.lihatLowongan = function (
    id,
    posisi,
    kategori,
    gaji,
    deadline,
    tanggung,
    kualifikasi,
    jenis_bidang,
) {
    activeJob = { id, posisi, kategori, gaji, deadline, tanggung, kualifikasi, jenis_bidang };

    const detailPosisi = document.getElementById("detail-posisi");
    const detailKategori = document.getElementById("detail-kategori");
    const detailGaji = document.getElementById("detail-gaji");
    const detailDeadline = document.getElementById("detail-deadline");
    const detailJenisBidang = document.getElementById("detail-jenis-bidang");

    if (detailPosisi) detailPosisi.innerText = posisi;
    if (detailKategori) detailKategori.innerText = kategori;
    if (detailGaji) detailGaji.innerText = gaji;
    if (detailDeadline)
        detailDeadline.innerText = deadline || "Tidak ada batas waktu";
    if (detailJenisBidang)
        detailJenisBidang.innerText = jenis_bidang || "Belum ditentukan";

    let tanggungList = document.getElementById("detail-tanggung");
    if (tanggungList) {
        tanggungList.innerHTML = "";
        tanggung.forEach((item) => {
            tanggungList.innerHTML += `<li>${item}</li>`;
        });
    }

    let kualifikasiList = document.getElementById("detail-kualifikasi");
    if (kualifikasiList) {
        kualifikasiList.innerHTML = "";
        kualifikasi.forEach((item) => {
            kualifikasiList.innerHTML += `<li>${item}</li>`;
        });
    }

    const detailModal = document.getElementById("detail-modal");
    if (detailModal) {
        detailModal.classList.replace("hidden", "flex");
    }
};

/* ---- Tutup Detail ---- */
window.tutupDetail = function () {
    const detailModal = document.getElementById("detail-modal");
    if (detailModal) {
        detailModal.classList.replace("flex", "hidden");
    }
};

/* ---- Edit Lowongan Langsung ---- */
window.editLowonganLangsung = function (
    id,
    posisi,
    kategori,
    gaji,
    deadline,
    tanggung,
    kualifikasi,
    jenis_bidang,
) {
    activeJob = { id, posisi, kategori, gaji, deadline, tanggung, kualifikasi, jenis_bidang };
    bukaEdit();
};

/* ---- Buka Edit ---- */
window.bukaEdit = function () {
    if (!activeJob) return;

    // Tutup detail pop-up jika terbuka
    const detailModal = document.getElementById("detail-modal");
    if (detailModal && !detailModal.classList.contains("hidden")) {
        tutupDetail();
    }

    const formEdit = document.getElementById("form-edit-lowongan");
    if (formEdit) {
        formEdit.action = `/company/jobs/${activeJob.id}`;
    }

    const editPosisi = document.getElementById("edit-posisi");
    if (editPosisi) editPosisi.value = activeJob.posisi;

    // Set Kategori select
    const editKategoriSelect = document.getElementById("edit-kategori-select");
    if (editKategoriSelect) {
        editKategoriSelect.value = activeJob.kategori || "";
    }

    // Set Jenis Bidang select
    const editJenisBidang = document.getElementById("edit-jenis-bidang-select");
    if (editJenisBidang) {
        editJenisBidang.value = activeJob.jenis_bidang || "";
    }

    const editDeadline = document.getElementById("edit-deadline");
    if (editDeadline) editDeadline.value = activeJob.deadline || "";

    let gajiMin = "";
    let gajiMax = "";
    if (activeJob.gaji && activeJob.gaji.includes(" - ")) {
        const parts = activeJob.gaji.split(" - ");
        gajiMin = parts[0] ? parts[0].trim() : "";
        gajiMax = parts[1] ? parts[1].trim() : "";
    } else {
        gajiMin = activeJob.gaji || "";
    }

    const minInput = document.getElementById("edit-gaji-min");
    const maxInput = document.getElementById("edit-gaji-max");
    const finalInput = document.getElementById("edit-gaji-final");
    if (minInput) minInput.value = gajiMin;
    if (maxInput) maxInput.value = gajiMax;
    if (finalInput) finalInput.value = activeJob.gaji;

    const tanggungContainer = document.getElementById(
        "edit-list-tanggung-jawab",
    );
    if (tanggungContainer) {
        tanggungContainer.innerHTML = "";
        if (activeJob.tanggung && activeJob.tanggung.length > 0) {
            activeJob.tanggung.forEach((item) => {
                const div = document.createElement("div");
                div.className = `flex items-start gap-2 item-tanggung-jawab`;
                div.innerHTML = `
                    <textarea name="tanggung_jawab[]" rows="2" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none" required>${item}</textarea>
                    <button type="button" onclick="hapusItem(this, 'edit-list-tanggung-jawab')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
                `;
                tanggungContainer.appendChild(div);
            });
        } else {
            tambahItem(
                "edit-list-tanggung-jawab",
                "tanggung_jawab[]",
                "Jelaskan peran ini secara ringkas...",
            );
        }
        perbaruiTombolHapus("edit-list-tanggung-jawab", "item-tanggung-jawab");
    }

    const kualifikasiContainer = document.getElementById(
        "edit-list-kualifikasi",
    );
    if (kualifikasiContainer) {
        kualifikasiContainer.innerHTML = "";
        if (activeJob.kualifikasi && activeJob.kualifikasi.length > 0) {
            activeJob.kualifikasi.forEach((item) => {
                const div = document.createElement("div");
                div.className = `flex items-start gap-2 item-kualifikasi`;
                div.innerHTML = `
                    <textarea name="kualifikasi[]" rows="2" class="flex-1 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-800 focus:outline-none focus:border-[#143E72] focus:bg-white transition-all duration-200 resize-none" required>${item}</textarea>
                    <button type="button" onclick="hapusItem(this, 'edit-list-kualifikasi')" class="w-8 h-8 rounded-full bg-red-50 text-red-500 flex items-center justify-center shrink-0">✕</button>
                `;
                kualifikasiContainer.appendChild(div);
            });
        } else {
            tambahItem(
                "edit-list-kualifikasi",
                "kualifikasi[]",
                "Jelaskan kualifikasi ini...",
            );
        }
        perbaruiTombolHapus("edit-list-kualifikasi", "item-kualifikasi");
    }

    const editModal = document.getElementById("edit-modal");
    if (editModal) {
        editModal.classList.replace("hidden", "flex");
    }
};

/* ---- Tutup Edit ---- */
window.tutupEdit = function () {
    const editModal = document.getElementById("edit-modal");
    if (editModal) {
        editModal.classList.replace("flex", "hidden");
    }
};

/* ---- Pop-up hapus ---- */
let formHapus = null;

window.bukaHapus = function (id) {
    formHapus = document.getElementById(`hapus-form-${id}`);
    const hapusModal = document.getElementById("hapus-modal");
    if (hapusModal) {
        hapusModal.classList.replace("hidden", "flex");
    }
};

window.tutupHapus = function () {
    const hapusModal = document.getElementById("hapus-modal");
    if (hapusModal) {
        hapusModal.classList.replace("flex", "hidden");
    }
};

/* ---- Tampilkan Peringatan Toast ---- */
window.tampilkanPeringatan = function (pesan) {
    const existing = document.getElementById("notif-peringatan");
    if (existing) existing.remove();

    const notif = document.createElement("div");
    notif.id = "notif-peringatan";
    notif.className =
        "fixed top-6 right-6 z-[9999] flex items-center gap-3 bg-white border border-amber-200 shadow-xl rounded-2xl px-5 py-4 animate-slide-in";
    notif.innerHTML = `
        <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <p class="text-sm font-semibold text-slate-700">${pesan}</p>
        <button onclick="this.parentElement.remove()" class="ml-2 text-slate-400 hover:text-slate-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    `;
    document.body.appendChild(notif);
    setTimeout(() => {
        notif.style.opacity = "0";
        setTimeout(() => notif.remove(), 500);
    }, 5000);
};

/* ---- Form Submit Validation (Create & Edit) ---- */
window.validasiFormLowongan = function (form) {
    // 1. Validasi Posisi
    const posisi = form.querySelector('[name="posisi"]');
    if (posisi && !posisi.value.trim()) {
        tampilkanPeringatan("Judul posisi pekerjaan harus diisi.");
        posisi.focus();
        return false;
    }

    // 2. Validasi Kategori
    const kategori = form.querySelector('[name="kategori"]');
    if (!kategori || !kategori.value.trim()) {
        tampilkanPeringatan("Silakan pilih salah satu kategori pekerjaan.");
        if (kategori) kategori.focus();
        return false;
    }

    // 2b. Validasi Jenis Bidang
    const jenisBidang = form.querySelector('[name="jenis_bidang"]');
    if (!jenisBidang || !jenisBidang.value.trim()) {
        tampilkanPeringatan("Silakan pilih jenis bidang.");
        if (jenisBidang) jenisBidang.focus();
        return false;
    }

    // 3. Validasi Gaji
    const gajiMinInput =
        form.id === "form-lowongan"
            ? document.getElementById("gaji-min")
            : document.getElementById("edit-gaji-min");
    const gajiMaxInput =
        form.id === "form-lowongan"
            ? document.getElementById("gaji-max")
            : document.getElementById("edit-gaji-max");
    if (
        (gajiMinInput && !gajiMinInput.value.trim()) ||
        (gajiMaxInput && !gajiMaxInput.value.trim())
    ) {
        tampilkanPeringatan("Silakan isi rentang gaji minimum dan maksimum.");
        if (gajiMinInput && !gajiMinInput.value.trim()) gajiMinInput.focus();
        else if (gajiMaxInput) gajiMaxInput.focus();
        return false;
    }

    // 4. Validasi Tanggung Jawab
    const tanggungJawabFields = form.querySelectorAll(
        '[name="tanggung_jawab[]"]',
    );
    for (let i = 0; i < tanggungJawabFields.length; i++) {
        if (!tanggungJawabFields[i].value.trim()) {
            tampilkanPeringatan(
                "Bagian tanggung jawab tidak boleh ada yang kosong.",
            );
            tanggungJawabFields[i].focus();
            return false;
        }
    }

    // 5. Validasi Kualifikasi/Persyaratan
    const kualifikasiFields = form.querySelectorAll('[name="kualifikasi[]"]');
    for (let i = 0; i < kualifikasiFields.length; i++) {
        if (!kualifikasiFields[i].value.trim()) {
            tampilkanPeringatan(
                "Bagian kualifikasi/persyaratan tidak boleh ada yang kosong.",
            );
            kualifikasiFields[i].focus();
            return false;
        }
    }

    return true;
};
