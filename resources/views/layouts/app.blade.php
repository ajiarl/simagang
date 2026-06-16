<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SiMagang') — Sistem Informasi Magang</title>
    <meta name="description" content="SiMagang — Sistem Informasi Magang Mahasiswa. Kelola pengajuan, logbook, presensi, dan penilaian magang secara digital.">

    {{-- Google Fonts: Inter + Material Symbols --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: #f9f9ff;
            border-right: 1px solid #c2c6d3;
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 20;
            transition: transform 300ms ease;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            min-height: 100vh;
            z-index: 15;
        }
        @media (max-width: 1023px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.open { display: block; }
        }

        /* ── Sidebar Nav Item ── */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-left: 4px solid transparent;
            border-radius: 0 8px 8px 0;
            color: #424751;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            text-decoration: none;
            transition: background 150ms ease, color 150ms ease;
            margin: 0 8px 2px 0;
        }
        .nav-item:hover {
            background: #e7e8ef;
        }
        .nav-item.active {
            border-left-color: #0058be;
            background: rgba(0, 62, 126, 0.05);
            color: #0058be;
            font-weight: 600;
        }
        .nav-item .material-symbols-outlined {
            font-size: 20px;
        }

        /* ── Top Bar ── */
        .topbar {
            height: 64px;
            background: #f9f9ff;
            border-bottom: 1px solid #c2c6d3;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* ── Main Content ── */
        .main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            background: #f9f9ff;
        }
        @media (max-width: 1023px) {
            .main-wrapper { margin-left: 0; }
        }
        .main-content {
            padding: 24px;
            max-width: 1280px;
        }

        /* ── Avatar ── */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: #003e7e;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            line-height: 18px;
            border: 1px solid #c2c6d3;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── Notification Bell ── */
        .notification-bell {
            position: relative;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: background 150ms ease;
        }
        .notification-bell:hover {
            background: #e7e8ef;
        }
        .notification-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #ba1a1a;
            position: absolute;
            top: 8px;
            right: 8px;
        }

        /* ── User Dropdown ── */
        .user-dropdown {
            position: relative;
        }
        .user-dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: #ffffff;
            border: 0.5px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0px 10px 15px -3px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 30;
            padding: 8px;
        }
        .user-dropdown-menu.open {
            display: block;
        }
        .user-dropdown-menu a,
        .user-dropdown-menu button {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #424751;
            text-decoration: none;
            border: none;
            background: none;
            cursor: pointer;
            transition: background 150ms ease;
        }
        .user-dropdown-menu a:hover,
        .user-dropdown-menu button:hover {
            background: #f3f3fa;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-sans antialiased">

    {{-- Sidebar Overlay (mobile) --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        {{-- Logo --}}
        <div style="padding: 24px 16px 20px; display: flex; align-items: center; justify-content: space-between;">
            <a href="/" style="display: flex; align-items: center; gap: 12px; text-decoration: none; flex-wrap: wrap;">
                <div style="width: 40px; height: 40px; border-radius: 9999px; background: #1a56a0; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: #ffffff; font-size: 22px;">school</span>
                </div>
                <span class="text-headline-md" style="color: #003e7e; font-weight: 700;">SiMagang</span>
            </a>
            <button onclick="toggleSidebar()" style="display: none; background: none; border: none; cursor: pointer; padding: 4px;" class="sidebar-close-btn">
                <span class="material-symbols-outlined" style="font-size: 24px; color: #424751;">close</span>
            </button>
        </div>

        <div style="padding: 0 0 0 0; border-top: 1px solid #c2c6d3; margin: 0 16px; padding-top: 16px;"></div>

        {{-- Navigation --}}
        <nav style="flex: 1; padding: 8px 0;">
            @role('mahasiswa')
                <a href="{{ route('mahasiswa.dashboard') }}" class="nav-item @if(request()->routeIs('mahasiswa.dashboard')) active @endif">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>
                <a href="{{ route('mahasiswa.applications.index') }}" class="nav-item @if(request()->routeIs('mahasiswa.applications.*')) active @endif">
                    <span class="material-symbols-outlined">description</span> Pengajuan Magang
                </a>
                <a href="{{ route('mahasiswa.logbooks.index') }}" class="nav-item @if(request()->routeIs('mahasiswa.logbooks.*')) active @endif">
                    <span class="material-symbols-outlined">menu_book</span> Logbook Harian
                </a>
                <a href="{{ route('mahasiswa.attendances.index') }}" class="nav-item @if(request()->routeIs('mahasiswa.attendances.*')) active @endif">
                    <span class="material-symbols-outlined">qr_code</span> Presensi
                </a>
                <a href="{{ route('mahasiswa.documents.index') }}" class="nav-item @if(request()->routeIs('mahasiswa.documents.*')) active @endif">
                    <span class="material-symbols-outlined">folder</span> Dokumen
                </a>
                <a href="{{ route('mahasiswa.assessments.index') }}" class="nav-item @if(request()->routeIs('mahasiswa.assessments.*')) active @endif">
                    <span class="material-symbols-outlined">grade</span> Penilaian
                </a>
            @endrole

            @role('dosen')
                <a href="{{ route('dosen.dashboard') }}" class="nav-item @if(request()->routeIs('dosen.dashboard')) active @endif">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>
                <a href="{{ route('dosen.students.index') }}" class="nav-item @if(request()->routeIs('dosen.students.*')) active @endif">
                    <span class="material-symbols-outlined">groups</span> Mahasiswa Bimbingan
                </a>
                <a href="{{ route('dosen.logbooks.index') }}" class="nav-item @if(request()->routeIs('dosen.logbooks.*')) active @endif">
                    <span class="material-symbols-outlined">fact_check</span> Review Logbook
                </a>
                <a href="{{ route('dosen.assessments.index') }}" class="nav-item @if(request()->routeIs('dosen.assessments.*')) active @endif">
                    <span class="material-symbols-outlined">grade</span> Penilaian
                </a>
            @endrole

            @role('admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item @if(request()->routeIs('admin.dashboard')) active @endif">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>
                <a href="{{ route('admin.students.index') }}" class="nav-item @if(request()->routeIs('admin.students.*')) active @endif">
                    <span class="material-symbols-outlined">school</span> Mahasiswa
                </a>
                <a href="{{ route('admin.companies.index') }}" class="nav-item @if(request()->routeIs('admin.companies.*')) active @endif">
                    <span class="material-symbols-outlined">business</span> Perusahaan
                </a>
                <a href="{{ route('admin.periods.index') }}" class="nav-item @if(request()->routeIs('admin.periods.*')) active @endif">
                    <span class="material-symbols-outlined">date_range</span> Periode Magang
                </a>
                <a href="{{ route('admin.applications.index') }}" class="nav-item @if(request()->routeIs('admin.applications.*')) active @endif">
                    <span class="material-symbols-outlined">description</span> Pengajuan Magang
                </a>
                <a href="{{ route('admin.attendances.index') }}" class="nav-item @if(request()->routeIs('admin.attendances.*')) active @endif">
                    <span class="material-symbols-outlined">event_available</span> Rekap Kehadiran
                </a>
                <a href="{{ route('admin.reports.index') }}" class="nav-item @if(request()->routeIs('admin.reports.*')) active @endif">
                    <span class="material-symbols-outlined">assessment</span> Laporan
                </a>
            @endrole

            @role('perusahaan')
                <a href="{{ route('perusahaan.dashboard') }}" class="nav-item @if(request()->routeIs('perusahaan.dashboard')) active @endif">
                    <span class="material-symbols-outlined">dashboard</span> Dashboard
                </a>
                <a href="{{ route('perusahaan.attendances.index') }}" class="nav-item @if(request()->routeIs('perusahaan.attendances.*')) active @endif">
                    <span class="material-symbols-outlined">qr_code_scanner</span> Verifikasi Presensi
                </a>
                <a href="{{ route('perusahaan.assessments.index') }}" class="nav-item @if(request()->routeIs('perusahaan.assessments.*')) active @endif">
                    <span class="material-symbols-outlined">grade</span> Penilaian Mahasiswa
                </a>
            @endrole
        </nav>

        {{-- Logout Button --}}
        <div style="padding: 16px; border-top: 1px solid #c2c6d3; margin: 0 8px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary" style="width: 100%; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-wrapper">
        {{-- Top Bar --}}
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                {{-- Hamburger (mobile) --}}
                <button onclick="toggleSidebar()" style="display: none; background: none; border: none; cursor: pointer; padding: 4px;" class="hamburger-btn">
                    <span class="material-symbols-outlined" style="font-size: 24px; color: #424751;">menu</span>
                </button>
                <h1 class="text-headline-sm" style="color: #191c20;">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;">
                {{-- Notification Bell --}}
                <div class="notification-bell user-dropdown" id="notifDropdown">
                    <button onclick="toggleNotifDropdown()" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%;">
                        <span class="material-symbols-outlined" style="font-size: 22px; color: #424751;">notifications</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <div class="notification-dot"></div>
                        @endif
                    </button>
                    
                    <div class="user-dropdown-menu" id="notifMenu" style="width: 100%; max-width: 320px; right: -10px; max-height: 400px; overflow-y: auto;">
                        <div style="padding: 12px; border-bottom: 1px solid #e2e2e9; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 600; color: #191c20;">Notifikasi</span>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: #0058be; font-size: 12px; cursor: pointer;">Tandai Dibaca</button>
                                </form>
                            @endif
                        </div>
                        
                        <div style="display: flex; flex-direction: column;">
                            @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                                <a href="{{ $notification->data['url'] ?? '#' }}" class="nav-item" style="padding: 12px; margin: 0; border-radius: 0; border-bottom: 1px solid #f0f0f4; {{ is_null($notification->read_at) ? 'background: #f8fafc;' : '' }}">
                                    <div style="display: flex; gap: 12px; align-items: flex-start; flex-wrap: wrap;">
                                        <span class="material-symbols-outlined" style="color: {{ $notification->data['color'] ?? '#0058be' }};">{{ $notification->data['icon'] ?? 'notifications' }}</span>
                                        <div style="flex: 1;">
                                            <div style="font-size: 13px; font-weight: 600; color: #191c20; margin-bottom: 4px;">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</div>
                                            <div style="font-size: 12px; color: #424751; line-height: 1.4;">{{ $notification->data['message'] ?? '' }}</div>
                                            <div style="font-size: 11px; color: #737782; margin-top: 6px;">{{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div style="padding: 24px; text-align: center; color: #737782; font-size: 13px;">
                                    Belum ada notifikasi.
                                </div>
                            @endforelse
                        </div>
                        
                        <div style="padding: 8px; border-top: 1px solid #e2e2e9; text-align: center;">
                            <a href="{{ route('notifications.index') }}" style="color: #0058be; font-size: 13px; font-weight: 500; text-decoration: none;">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>

                {{-- User Dropdown --}}
                <div class="user-dropdown" id="userDropdown">
                    <button onclick="toggleDropdown()" style="display: flex; align-items: center; gap: 8px; background: none; border: none; cursor: pointer; padding: 4px; flex-wrap: wrap;">
                        <div class="avatar">{{ auth()->user()->initials }}</div>
                        <span class="text-body-sm" style="color: #191c20;">{{ auth()->user()->name }}</span>
                        <span class="material-symbols-outlined" style="font-size: 18px; color: #737782;">expand_more</span>
                    </button>
                    <div class="user-dropdown-menu" id="dropdownMenu">
                        <a href="{{ route('profile.edit') }}">
                            <span class="material-symbols-outlined" style="font-size: 18px;">person</span>
                            Profil Saya
                        </a>
                        <div style="border-top: 1px solid #e2e2e9; margin: 4px 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="color: #ba1a1a;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">logout</span>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <style>
        /* CSS Spinner for loading buttons */
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .spin { animation: spin 1s linear infinite; }
        .btn-loading { opacity: 0.8; cursor: not-allowed; pointer-events: none; }
    </style>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('open');
        }

        function toggleDropdown() {
            const menu = document.getElementById('dropdownMenu');
            menu.classList.toggle('open');
            document.getElementById('notifMenu').classList.remove('open');
        }

        function toggleNotifDropdown() {
            const menu = document.getElementById('notifMenu');
            menu.classList.toggle('open');
            document.getElementById('dropdownMenu').classList.remove('open');
        }

        // Close dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            if (!document.getElementById('userDropdown').contains(e.target)) {
                document.getElementById('dropdownMenu').classList.remove('open');
            }
            if (!document.getElementById('notifDropdown').contains(e.target)) {
                document.getElementById('notifMenu').classList.remove('open');
            }
        });

        // Global double submission protection
        document.addEventListener('submit', function(e) {
            if (e.target.tagName === 'FORM') {
                const btn = e.target.querySelector('button[type="submit"]');
                if (btn) {
                    setTimeout(() => {
                        btn.disabled = true;
                        btn.classList.add('btn-loading');
                        const originalContent = btn.innerHTML;
                        btn.dataset.originalContent = originalContent;
                        btn.innerHTML = '<span class="material-symbols-outlined spin" style="font-size: 18px; margin-right: 4px; vertical-align: middle;">sync</span><span style="vertical-align: middle;">Loading...</span>';
                    }, 10);
                }
            }
        });
    </script>

    <style>
        @media (max-width: 1023px) {
            .hamburger-btn { display: block !important; }
            .sidebar-close-btn { display: block !important; }
            .topbar h1 { font-size: 16px !important; }

            /* 1. Sidebar width on mobile: max 280px, not full width */
            .sidebar {
                width: 280px !important;
                max-width: 85vw !important;
            }

            /* 2. Nav items on mobile: reduce font size and padding */
            .nav-item, .sidebar a {
                font-size: 14px !important;
                padding: 10px 16px !important;
            }
            .sidebar .nav-icon,
            .sidebar .material-symbols-outlined {
                font-size: 20px !important;
            }

            /* 3. Sidebar logo area on mobile: reduce padding */
            .sidebar > div:first-child {
                padding: 16px 12px !important;
            }

            /* 4. Keluar button on mobile: reduce size */
            .sidebar .btn-logout, 
            .sidebar form button,
            .sidebar > div:last-child {
                padding: 10px 16px !important;
                font-size: 13px !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', 
            text: '{{ session('success') }}', timer: 2500, 
            showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', 
            text: '{{ session('error') }}' });
    @endif
    @if(session('warning'))
        Swal.fire({ icon: 'warning', title: 'Perhatian!', 
            text: '{{ session('warning') }}' });
    @endif

    function confirmDelete(url) {
        Swal.fire({ title: 'Hapus data ini?', 
            text: 'Data yang dihapus tidak bisa dikembalikan.',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#DC2626', cancelButtonColor: '#737782',
            confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.method = 'POST'; form.action = url;
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form); form.submit();
            }
        });
    }
    </script>
</body>
</html>
