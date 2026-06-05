<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Recruiter - Bursa Tenaga Kerja')</title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar-active {
            font-weight: 700;
            color: #1B3A5C;
            border-left: 4px solid #1B3A5C;
            background: transparent;
        }

        .sidebar-inactive {
            font-weight: 500;
            color: #6B7280;
        }

        .sidebar-inactive:hover {
            color: #1B3A5C;
            background: rgba(27, 58, 92, 0.05);
        }

        .progress-bar {
            height: 6px;
            border-radius: 999px;
            background: #E5EAE7;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 999px;
            background: #1B3A5C;
        }
    </style>
    <script>
        const token = localStorage.getItem('token') || sessionStorage.getItem('token');
        const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user'));
        
        if (!token || !user || Number(user.role_id) !== 2) {
            window.location.href = '/login';
        }
    </script>
    @yield('styles')
</head>

<body class="bg-cream-100 text-slate-800 antialiased min-h-screen">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        <aside class="w-sidebar bg-cream-100 flex flex-col justify-between fixed h-screen z-40 border-r border-cream-300">
            <div>
                <!-- Logo -->
                <div class="px-6 py-8 flex items-center">
                    <a href="{{ url('/') }}" class="block">
                        <img src="{{ asset('assets/logo.png') }}" alt="Bursa Tenaga Kerja Logo" class="w-40 h-auto object-contain">
                    </a>
                </div>

                <!-- Nav -->
                <nav class="w-[215px] ml-[20px] space-y-1">
                    <!-- Dasbor -->
                    <a href="{{ route('company.dashboard') }}" class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('company.dashboard') ? 'text-navy-500 bg-white/70 shadow-sm border-l-4 border-navy-500' : 'text-slate-500 hover:text-navy-500 hover:bg-navy-500/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('company.dashboard') ? 'text-navy-500' : 'text-slate-400 group-hover:text-navy-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            <span>Dasbor</span>
                        </div>
                    </a>

                    <!-- Profil Perusahaan -->
                    <a href="{{ route('company.profile') }}" class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('company.profile*') ? 'text-navy-500 bg-white/70 shadow-sm border-l-4 border-navy-500' : 'text-slate-500 hover:text-navy-500 hover:bg-navy-500/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('company.profile*') ? 'text-navy-500' : 'text-slate-400 group-hover:text-navy-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="2" width="16" height="20" rx="2" ry="2" />
                                <line x1="9" y1="22" x2="9" y2="16" />
                                <line x1="15" y1="22" x2="15" y2="16" />
                                <line x1="9" y1="16" x2="15" y2="16" />
                                <path d="M8 6h8M8 10h8" />
                            </svg>
                            <span>Profil Perusahaan</span>
                        </div>
                    </a>

                    <!-- Kelola Lowongan -->
                    <a href="{{ route('company.jobs') }}" class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('company.jobs*') ? 'text-navy-500 bg-white/70 shadow-sm border-l-4 border-navy-500' : 'text-slate-500 hover:text-navy-500 hover:bg-navy-500/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('company.jobs*') ? 'text-navy-500' : 'text-slate-400 group-hover:text-navy-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                                <polyline points="10 9 9 9 8 9" />
                            </svg>
                            <span>Kelola Lowongan</span>
                        </div>
                    </a>

                    <!-- Pelamar Masuk -->
                    <a href="{{ route('company.applicants') }}" class="group flex items-center justify-between px-4 py-3.5 rounded-xl text-sm font-bold transition-all duration-200 {{ request()->routeIs('company.applicants*') ? 'text-navy-500 bg-white/70 shadow-sm border-l-4 border-navy-500' : 'text-slate-500 hover:text-navy-500 hover:bg-navy-500/5' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 {{ request()->routeIs('company.applicants*') ? 'text-navy-500' : 'text-slate-400 group-hover:text-navy-500' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            <span>Pelamar Masuk</span>
                        </div>
                    </a>

                    <!-- Laporan -->
                    <a href="#" class="group flex items-center px-4 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:text-navy-500 hover:bg-navy-500/5 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-navy-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10" />
                                <line x1="12" y1="20" x2="12" y2="4" />
                                <line x1="6" y1="20" x2="6" y2="14" />
                            </svg>
                            <span>Laporan</span>
                        </div>
                    </a>

                    <!-- Pengaturan -->
                    <a href="#" class="group flex items-center px-4 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:text-navy-500 hover:bg-navy-500/5 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400 group-hover:text-navy-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3" />
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
                            </svg>
                            <span>Pengaturan</span>
                        </div>
                    </a>
                </nav>
            </div>

            <!-- Keluar -->
            <div class="p-4">
                <a href="#" onclick="logoutCompany()" class="group flex items-center px-4 py-3.5 rounded-xl text-sm font-bold text-red-500 hover:text-red-700 hover:bg-red-50/50 transition-all duration-200">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <span>Keluar</span>
                    </div>
                </a>
            </div>
        </aside>

        <!-- MAIN WRAPPER -->
        <div class="ml-sidebar flex-1 flex flex-col min-h-screen">

            <!-- HEADER -->
            <header class="bg-cream-100 px-8 py-4 flex items-center justify-between sticky top-0 z-30 border-b border-cream-300">
                <!-- Search bar -->
                <div class="relative w-80">
                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari pelamar atau lowongan..." class="w-full pl-11 pr-4 py-2.5 bg-white border border-cream-300 rounded-xl text-sm focus:ring-2 focus:ring-navy-500 focus:border-transparent outline-none transition shadow-sm placeholder-gray-400 text-slate-800">
                </div>

                <!-- Notifications, Messages, & User Profile -->
                <div class="flex items-center gap-4">
                    <!-- Notifications icon with dot -->
                    <button class="relative text-gray-500 hover:text-navy-500 transition p-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border-2 border-cream-100"></span>
                    </button>

                    <!-- Messages/Envelope icon -->
                    <button class="text-gray-500 hover:text-navy-500 transition p-2">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                    </button>

                    <!-- Vertical Divider & Profile Info -->
                    <div class="flex items-center gap-3 pl-3 border-l border-cream-300">
                        <div class="text-right">
                            <p id="headerUserName" class="text-sm font-bold text-navy-500 leading-tight">Administrator</p>
                            <p id="headerUserRole" class="text-[10px] font-semibold text-gray-400 tracking-widest uppercase">Recruitment Lead</p>
                        </div>
                        <!-- User Avatar -->
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-sm bg-navy-500 flex items-center justify-center text-white font-bold text-sm">
                            <span id="headerUserInitials">AD</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- MAIN CONTENT AREA -->
            <main class="flex-1 p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Dynamic User Profile & Logout Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token') || sessionStorage.getItem('token');
            const user = JSON.parse(localStorage.getItem('user') || sessionStorage.getItem('user'));

            function updateUserUI(u) {
                if (!u) return;
                const headerUserName = document.getElementById('headerUserName');
                const headerUserRole = document.getElementById('headerUserRole');
                const headerUserInitials = document.getElementById('headerUserInitials');

                if (headerUserName) {
                    headerUserName.textContent = u.name || 'Perekrut';
                }
                if (headerUserRole) {
                    headerUserRole.textContent = u.company_name || 'Perekrut';
                }
                if (headerUserInitials && u.name) {
                    const initials = u.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                    headerUserInitials.textContent = initials || 'AD';
                }

                // Call page-specific sync if defined
                if (typeof window.syncCompanyName === 'function' && u.company_name) {
                    window.syncCompanyName(u.company_name);
                }
            }

            // Initialize UI with stored user
            if (user) {
                updateUserUI(user);
            }

            // Fetch fresh user data from database via API
            if (token) {
                fetch('/api/auth/me', {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success && result.data) {
                            const storage = localStorage.getItem('token') ? localStorage : sessionStorage;
                            storage.setItem('user', JSON.stringify(result.data));
                            updateUserUI(result.data);
                        }
                    })
                    .catch(err => console.error('Error fetching user profile:', err));
            }
        });

        function logoutCompany() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                const token = localStorage.getItem('token') || sessionStorage.getItem('token');
                if (token) {
                    fetch('/api/auth/logout', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    }).catch(err => console.log('Logout API failed:', err));
                }

                localStorage.removeItem('token');
                localStorage.removeItem('user');
                sessionStorage.removeItem('token');
                sessionStorage.removeItem('user');

                window.location.href = '/login';
            }
        }
    </script>
    @yield('scripts')
</body>

</html>