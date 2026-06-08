document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("filterModal");
    const openBtn = document.getElementById("openFilterBtn");
    const closeBtn = document.getElementById("closeFilterBtn");
    const cancelBtn = document.getElementById("cancelFilterBtn");

    if (openBtn && modal) {
        openBtn.addEventListener("click", (e) => {
            e.preventDefault();
            modal.classList.remove("hidden");
        });
    }

    const hideModal = () => {
        if (modal) modal.classList.add("hidden");
    };

    if (closeBtn) closeBtn.addEventListener("click", hideModal);
    if (cancelBtn) cancelBtn.addEventListener("click", hideModal);

    if (modal) {
        modal.addEventListener("click", (e) => {
            if (
                e.target === modal ||
                e.target.classList.contains("bg-black\\/40")
            ) {
                hideModal();
            }
        });
    }
});
