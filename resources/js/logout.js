document.addEventListener('DOMContentLoaded', () => {

    const profileDropdown =
        document.getElementById('profileDropdown');

    const logoutDropdown =
        document.getElementById('logoutDropdown');

    const logoutBtn =
        document.getElementById('logoutBtn');

    profileDropdown?.addEventListener('click', (e) => {

        e.stopPropagation();

        logoutDropdown.classList.toggle('show');

    });

    document.addEventListener('click', () => {

        logoutDropdown?.classList.remove('show');

    });

    logoutBtn?.addEventListener('click', () => {

        localStorage.removeItem('token');
        localStorage.removeItem('user');

        window.location.href = '/login';

    });

});