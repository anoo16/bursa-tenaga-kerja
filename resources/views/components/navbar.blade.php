<div class="topbar">

    <h1>
        Selamat datang,
        {{ $user?->name ?? 'Guest' }}
    </h1>

    <div class="topbar-right">

        <i class='bx bx-bell'></i>

        <i class='bx bx-envelope'></i>

    </div>

    <div class="profile-wrapper">

        <div class="vertical-line"></div>

        <div class="profile-box">

            <img
                src="{{
                    $user && $user->photo
                    ? asset('storage/'.$user->photo)
                    : asset('assets/profile.png')
                }}"
                alt="Profile"
                class="profile-img"
            >

            <i class='bx bx-chevron-down'></i>

        </div>

    </div>

</div>