<aside class="sidebar">

    <div class="logo-area">
        <img src="{{ asset('assets/logo.png') }}"
             alt="Logo"
             class="logo-img">
    </div>

    <ul class="menu-list">

        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class='bx bx-grid-alt'></i>
                Dashboard
            </a>
        </li>

        <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <a href="{{ route('profile') }}">
                <i class='bx bx-user'></i>
                Profil Saya
            </a>
        </li>

        <li class="{{ request()->routeIs('jobs.index') ? 'active' : '' }}">
            <a href="{{ route('jobs.index') }}">
                <i class='bx bx-search'></i>
                Cari Lowongan
            </a>
        </li>

        <li class="{{ request()->routeIs('applications.lamaran-saya') ? 'active' : '' }}">
             <a href="{{ route('applications.lamaran-saya') }}">
                <i class='bx bx-file'></i>
                Lamaran Saya
            </a>
        </li>

        <li>
            <i class='bx bx-bookmark'></i>
            Simpan Lowongan
        </li>

        <li>
            <i class='bx bx-cog'></i>
            Pengaturan
        </li>

    </ul>

</aside>