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
