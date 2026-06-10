document.addEventListener("DOMContentLoaded", () => {
    // ── Inject user_id ke URL supaya controller bisa query database ──
    const user = JSON.parse(localStorage.getItem("user"));

    if (user && user.id) {
        const url = new URL(window.location.href);
        const params = url.searchParams;

        // Hanya redirect jika user_id belum ada di URL
        if (!params.get("user_id")) {
            params.set("user_id", user.id);
            window.location.replace(url.toString());
            return; // stop eksekusi sampai halaman reload
        }
    }

    // ── Inject user_id ke semua link di sidebar supaya tidak hilang ──
    const userId = user?.id;

    if (userId) {
        // Link "Lihat Semua" di tabel lamaran
        const lihatSemua = document.querySelector(
            ".application-section .section-header a",
        );
        if (lihatSemua) {
            const href = new URL(lihatSemua.href, window.location.origin);
            href.searchParams.set("user_id", userId);
            lihatSemua.href = href.toString();
        }

        // Form simpan lowongan di rekomendasi (jika ada)
        document
            .querySelectorAll(".recommendation-section form")
            .forEach((form) => {
                const action = new URL(form.action, window.location.origin);
                action.searchParams.set("user_id", userId);
                form.action = action.toString();
            });
    }
});
