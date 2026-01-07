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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js & SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(["resources/css/app.css", "resources/js/app.js"])

    @livewireStyles
    @stack('styles')
</head>

<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="sidebar-brand-text">
                    <h1>InternHub</h1>
                    <span>Management</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Menu</div>
                    <ul class="space-y-0.5">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        @if(auth()->user()->canManage())
                            <li class="nav-item">
                                <a href="{{ route('interns.index') }}" class="nav-link {{ request()->routeIs('interns.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i>
                                    <span>Anggota Magang</span>
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('supervisors.index') }}" class="nav-link {{ request()->routeIs('supervisors.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie"></i>
                                    <span>Pembimbing</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
                                <i class="fas fa-tasks"></i>
                                <span>Daftar Penugasan</span>
                            </a>
                        </li>

                        @if(auth()->user()->canManage())
                            <li class="nav-item">
                                <a href="{{ route('task-assignments.index') }}" class="nav-link {{ request()->routeIs('task-assignments.*') ? 'active' : '' }}">
                                    <i class="fas fa-layer-group"></i>
                                    <span>Daftar Tugas</span>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ route('attendances.index') }}" class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-check"></i>
                                <span>Presensi</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Kalender</span>
                            </a>
                        </li>
                    </ul>
                </div>

                @if(auth()->user()->canManage())
                    <div class="nav-section">
                        <div class="nav-section-title">Evaluasi</div>
                        <ul class="space-y-0.5">
                            <li class="nav-item">
                                <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                    <i class="fas fa-file-alt"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('assessments.index') }}" class="nav-link {{ request()->routeIs('assessments.*') ? 'active' : '' }}">
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
                        <ul class="space-y-0.5">
                            <li class="nav-item">
                                <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                                    <i class="fas fa-cog"></i>
                                    <span>Pengaturan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <ul class="space-y-0.5">
                        <li class="nav-item">
                            <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                                <i class="fas fa-user-circle"></i>
                                <span>Profil</span>
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
                <div class="flex items-center gap-3">
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
                    <div class="dropdown">
                        <button class="btn btn-icon btn-secondary relative" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 min-w-[16px] h-4 rounded-full bg-rose-500 text-white text-[9px] font-bold flex items-center justify-center px-1">
                                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                </span>
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" style="width: 300px;">
                            <div class="px-4 py-3 flex justify-between items-center" style="border-bottom: 1px solid rgba(148,163,184,0.1);">
                                <span class="font-bold text-slate-700 text-sm">Notifikasi</span>
                                @if($unreadCount > 0)
                                    <a href="{{ route('notifications.markAllRead') }}" class="text-[10px] text-violet-500 hover:text-violet-600 no-underline font-medium">Tandai dibaca</a>
                                @endif
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                @forelse($unreadNotifications as $notification)
                                    <a href="{{ $notification->link ?? route('notifications.index') }}" class="flex gap-3 px-4 py-3 no-underline transition-colors hover:bg-slate-50/80 {{ !$notification->read_at ? 'bg-violet-50/30' : '' }}" style="border-bottom: 1px solid rgba(148,163,184,0.06);">
                                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: rgba(248,250,252,0.8);">
                                            <i class="{{ $notification->icon_class }}" style="color: {{ $notification->color }};"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-slate-700 text-xs mb-0.5">{{ $notification->title }}</div>
                                            <div class="text-slate-400 text-[11px] truncate">{{ Str::limit($notification->message, 45) }}</div>
                                            <div class="text-slate-300 text-[10px] mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="py-8 text-center text-slate-400">
                                        <i class="fas fa-bell-slash text-2xl mb-2 opacity-40 block"></i>
                                        <span class="text-xs">Tidak ada notifikasi</span>
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block py-3 text-center text-xs font-semibold text-violet-500 hover:text-violet-600 no-underline hover:bg-slate-50/50" style="border-top: 1px solid rgba(148,163,184,0.1);">
                                Lihat Semua
                            </a>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="user-menu">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/avatars/' . auth()->user()->avatar) }}" alt="Avatar" class="user-avatar">
                        @else
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="user-info">
                            <div class="user-name">{{ auth()->user()->name }}</div>
                            <div class="user-role">{{ auth()->user()->role }}</div>
                        </div>
                        <i class="fas fa-chevron-down text-slate-400 text-[10px] ml-1"></i>

                        <div class="dropdown-menu">
                            <a href="{{ route('profile.show') }}" class="dropdown-item">
                                <i class="fas fa-user text-slate-400"></i>
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-cog text-slate-400"></i>
                                <span>Pengaturan</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item text-rose-500">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="content fade-in">
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

        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.querySelector('.menu-toggle');

            if (window.innerWidth <= 1024) {
                if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // SweetAlert2
        const swalConfig = {
            background: 'rgba(255,255,255,0.95)',
            backdrop: 'rgba(0,0,0,0.2)',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-6 py-2.5 font-semibold',
            }
        };

        @if(session('success'))
            Swal.fire({
                ...swalConfig,
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                ...swalConfig,
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#f43f5e'
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                ...swalConfig,
                icon: 'warning',
                title: 'Peringatan',
                text: "{{ session('warning') }}",
                confirmButtonColor: '#f59e0b'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                ...swalConfig,
                icon: 'error',
                title: 'Kesalahan Input',
                html: '<ul style="text-align:left;margin:0;padding-left:20px;">@foreach($errors->all() as $error)<li style="margin-bottom:4px;">{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#f43f5e'
            });
        @endif

        // Dropdown
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-toggle="dropdown"]')) {
                const dropdown = e.target.closest('.dropdown');
                dropdown.classList.toggle('show');
                document.querySelectorAll('.dropdown.show').forEach(d => {
                    if (d !== dropdown) d.classList.remove('show');
                });
                e.preventDefault();
            } else if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown.show').forEach(d => d.classList.remove('show'));
            }
        });
    </script>

    @livewireScripts
    @stack('scripts')
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden" wire:ignore>
        @csrf
    </form>
</body>

</html>
