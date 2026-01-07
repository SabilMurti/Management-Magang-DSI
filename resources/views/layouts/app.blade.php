<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Magang Management') - InternHub</title>

    <!-- Google Fonts - Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Vite CSS -->
    @vite(["resources/css/app.css", "resources/js/app.js"])

    @livewireStyles
    @stack('styles')
</head>

<body>
    <div class="bg-animation"></div>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text">
                    <h1>InternHub</h1>
                    <span>Management System</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if(auth()->user()->canManage())
                            <li class="nav-item">
                                <a href="{{ route('interns.index') }}"
                                    class="nav-link {{ request()->routeIs('interns.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i>
                                    <span>Anggota Magang</span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('supervisors.index') }}"
                                    class="nav-link {{ request()->routeIs('supervisors.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Anggota Pembimbing</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                    <a href="{{ route('tasks.index') }}"
                        class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <span>Daftar Penugasan</span>
                    </a>
                </li>

                @if(auth()->user()->canManage())
                    <li class="nav-item">
                        <a href="{{ route('task-assignments.index') }}"
                            class="nav-link {{ request()->routeIs('task-assignments.*') ? 'active' : '' }}">
                            <i class="fas fa-layer-group"></i>
                            <span>Daftar Tugas</span>
                        </a>
                    </li>
                @endif

                        <li class="nav-item">
                            <a href="{{ route('attendances.index') }}"
                                class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Presensi</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('calendar') }}"
                                class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Kalender</span>
                            </a>
                        </li>
                    </ul>
                </div>

                @if(auth()->user()->canManage())
                    <div class="nav-section">
                        <div class="nav-section-title">Evaluasi</div>
                        <ul>
                            <li class="nav-item">
                                <a href="{{ route('reports.index') }}"
                                    class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('assessments.index') }}"
                                    class="nav-link {{ request()->routeIs('assessments.*') ? 'active' : '' }}">
                                    <i class="fas fa-star"></i>
                                    <span>Penilaian</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                @if(auth()->user()->role === 'admin')
                    <div class="nav-section">
                        <div class="nav-section-title">Sistem</div>
                        <ul>
                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}"
                                    class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                    <i class="fas fa-cog"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('profile.show') }}"
                                class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="fas fa-user-circle"></i>
                                <span>Profil @if(auth()->user()->isIntern())& Statistik @endif</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="d-flex align-center gap-4">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="header-title">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="header-actions">
                    <!-- Notification Bell -->
                    @php
                        $unreadNotifications = auth()->user()->notifications()->unread()->latest()->take(5)->get();
                        $unreadCount = auth()->user()->notifications()->unread()->count();
                    @endphp
                    <div class="notification-bell dropdown" style="position: relative; margin-right: 16px;">
                        <button class="notification-btn" data-toggle="dropdown"
                            style="background: none; border: none; cursor: pointer; position: relative; padding: 8px;">
                            <i class="fas fa-bell" style="font-size: 20px; color: var(--text-secondary);"></i>
                            @if($unreadCount > 0)
                                <span class="notification-badge"
                                    style="position: absolute; top: 0; right: 0; background: #ef4444; color: white; font-size: 10px; font-weight: 700; min-width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 2px solid var(--bg-secondary);">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"
                            style="width: 320px; padding: 0; margin-top: 8px;">
                            <div
                                style="padding: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-weight: 700; color: var(--text-primary);">Notifikasi</span>
                                @if($unreadCount > 0)
                                    <a href="{{ route('notifications.markAllRead') }}"
                                        style="font-size: 12px; color: var(--accent-primary); text-decoration: none;">Tandai
                                        semua dibaca</a>
                                @endif
                            </div>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ $notification->link ?? route('notifications.index') }}"
                                        style="display: flex; gap: 12px; padding: 12px 16px; text-decoration: none; border-bottom: 1px solid var(--border-color); transition: background 0.2s; {{ !$notification->read_at ? 'background: rgba(167, 139, 250, 0.05);' : '' }}"
                                        onmouseover="this.style.background='var(--bg-hover)'"
                                        onmouseout="this.style.background='{{ !$notification->read_at ? 'rgba(167, 139, 250, 0.05)' : 'transparent' }}'">
                                        <div
                                            style="width: 36px; height: 36px; background: var(--bg-tertiary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <i class="{{ $notification->icon_class }}"
                                                style="color: {{ $notification->color }};"></i>
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <div
                                                style="font-weight: 600; color: var(--text-primary); font-size: 13px; margin-bottom: 2px;">
                                                {{ $notification->title }}</div>
                                            <div
                                                style="color: var(--text-muted); font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ Str::limit($notification->message, 50) }}</div>
                                            <div style="color: var(--text-muted); font-size: 11px; margin-top: 4px;">
                                                {{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <div style="padding: 32px; text-align: center; color: var(--text-muted);">
                                        <i class="fas fa-bell-slash"
                                            style="font-size: 24px; margin-bottom: 8px; display: block; opacity: 0.5;"></i>
                                        Tidak ada notifikasi baru
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('notifications.index') }}"
                                style="display: block; padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: var(--accent-primary); text-decoration: none; border-top: 1px solid var(--border-color);">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                    </div>
                    <div class="user-menu">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}" alt="Avatar"
                                class="user-avatar" style="object-fit: cover;">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ auth()->user()->role }}</div>
                        </div>
                        <i class="fas fa-chevron-down" style="color: var(--text-muted); font-size: 12px;"></i>

                        <div class="dropdown-menu">
                            <a href="{{ route('profile.show') }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                <span>Pengaturan</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <!-- Content -->
            <div class="content fade-in">
                <!-- Alerts handled by SweetAlert2 -->

                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }



        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.querySelector('.menu-toggle');

            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // SweetAlert2 Integration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                background: '#fff',
                color: '#1e293b'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
                background: '#fff',
                color: '#1e293b'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#f59e0b',
                background: '#fff',
                color: '#1e293b'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Ada Kesalahan Input',
                html: '<ul style="text-align: left;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#ef4444',
                background: '#fff',
                color: '#1e293b'
            });
        @endif

        // Simple Dropdown Toggle logic
        document.addEventListener('click', function (e) {
            // Dropdown toggle
            if (e.target.closest('.dropdown-toggle')) {
                const dropdown = e.target.closest('.dropdown');
                dropdown.classList.toggle('show');

                // Close other dropdowns
                document.querySelectorAll('.dropdown.show').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });

                e.preventDefault();
            } else if (!e.target.closest('.dropdown')) {
                // Click outside to close
                document.querySelectorAll('.dropdown.show').forEach(d => {
                    d.classList.remove('show');
                });
            }
        });
    </script>
    @livewireScripts
    @stack('scripts')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;" wire:ignore>
        @csrf
    </form>
</body>

</html>
