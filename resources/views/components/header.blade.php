<header class="header">
    <div class="d-flex align-center gap-4">
        <button class="menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <h2 class="header-title">{{ $title ?? 'Dashboard' }}</h2>
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

        <!-- User Menu -->
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
            </div>
        </div>
    </div>
</header>
