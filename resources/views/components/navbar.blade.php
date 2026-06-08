<div class="topbar">

    <h1>
        Selamat datang,
        <span id="navbar-user-name">
            Guest
        </span>

        <script>
        document.addEventListener('DOMContentLoaded', () => {

            const user = JSON.parse(
                localStorage.getItem('user')
            );

            if(user){
                document.getElementById(
                    'navbar-user-name'
                ).textContent = user.name;
            }

        });
        </script>
    </h1>

    <div class="profile-wrapper">

        <div class="vertical-line"></div>

        <div class="profile-box" id="profileDropdown">

            <img
                src="{{ asset('assets/profile.png') }}"
                id="navbar-profile-photo"
                alt="Profile"
                class="profile-img"
            >

            <script>
            document.addEventListener('DOMContentLoaded', () => {

                const user = JSON.parse(
                    localStorage.getItem('user')
                );

                if(user && user.photo){

                    document.getElementById(
                        'navbar-profile-photo'
                    ).src = '/storage/' + user.photo;

                }

            });
            </script>

            <i class='bx bx-chevron-down'></i>
            
            <div class="logout-dropdown" id="logoutDropdown">

                <button id="logoutBtn">
                    <i class='bx bx-log-out'></i>
                    Logout
                </button>

            </div>

        </div>

    </div>

</div>