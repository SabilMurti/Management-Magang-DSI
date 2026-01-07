<div>
    <div class="card">
        <!-- Calendar Header -->
        <div class="card-header"
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button wire:click="previousMonth" class="btn btn-icon" style="width: 40px; height: 40px; padding: 0;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h3 style="margin: 0; font-size: 20px; font-weight: 700; min-width: 200px; text-align: center;">
                    {{ $this->monthName }}
                </h3>
                <button wire:click="nextMonth" class="btn btn-icon" style="width: 40px; height: 40px; padding: 0;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- View Mode Toggle -->
            <div style="display: flex; gap: 8px;">
                <button wire:click="switchMode('attendance')"
                    class="btn {{ $viewMode === 'attendance' ? 'btn-primary' : 'btn-secondary' }}"
                    style="padding: 10px 20px; font-size: 14px;">
                    <i class="fas fa-calendar-check"></i> Kehadiran
                </button>
                <button wire:click="switchMode('tasks')"
                    class="btn {{ $viewMode === 'tasks' ? 'btn-primary' : 'btn-secondary' }}"
                    style="padding: 10px 20px; font-size: 14px;">
                    <i class="fas fa-tasks"></i> Tugas
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div style="padding: 24px;">
            <!-- Day Headers -->
            <div class="calendar-grid">
                @foreach(['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $dayName)
                    <div class="calendar-header-cell">
                        {{ $dayName }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div class="calendar-grid">
                @foreach($days as $day)
                    @if($day === null)
                        <div class="calendar-cell empty"></div>
                    @else
                        @php
                            $isToday = $day == now()->day && $currentMonth == now()->month && $currentYear == now()->year;
                            $hasEvents = isset($events[$day]) && count($events[$day]) > 0;
                            $dayEvents = $events[$day] ?? [];
                        @endphp
                        <div @if($viewMode === 'attendance' && auth()->user()->canManage())
                        wire:click="openAttendanceModal({{ $day }})" @endif
                            class="calendar-cell {{ $isToday ? 'today' : '' }} {{ $hasEvents ? 'has-events' : '' }} {{ ($viewMode === 'attendance' && auth()->user()->canManage()) ? 'clickable' : '' }}">

                            <!-- Day Number -->
                            <div class="day-number {{ $isToday ? 'today' : '' }}">
                                {{ $day }}
                            </div>

                            <!-- Events Container -->
                            <div class="events-container">
                                @if($hasEvents)
                                    @if($viewMode === 'attendance')
                                        {{-- Attendance Mode --}}
                                        @php
                                            // Check if it's intern's personal view or admin summary
                                            $isPersonal = isset($dayEvents[0]['type']) && $dayEvents[0]['type'] === 'attendance';
                                        @endphp

                                        @if($isPersonal)
                                            {{-- Intern's Personal View --}}
                                            @foreach($dayEvents as $event)
                                                @php
                                                    $statusConfig = [
                                                        'present' => ['bg' => '#10b981', 'icon' => 'fa-check-circle', 'label' => 'Hadir'],
                                                        'late' => ['bg' => '#f59e0b', 'icon' => 'fa-clock', 'label' => 'Terlambat'],
                                                        'absent' => ['bg' => '#ef4444', 'icon' => 'fa-times-circle', 'label' => 'Absen'],
                                                        'permission' => ['bg' => '#3b82f6', 'icon' => 'fa-file-alt', 'label' => 'Izin'],
                                                        'sick' => ['bg' => '#a855f7', 'icon' => 'fa-notes-medical', 'label' => 'Sakit'],
                                                    ];
                                                    $config = $statusConfig[$event['status']] ?? $statusConfig['absent'];
                                                @endphp
                                                <div class="attendance-badge" style="background: {{ $config['bg'] }};">
                                                    <i class="fas {{ $config['icon'] }}"></i>
                                                    <span>{{ $event['check_in'] ? substr($event['check_in'], 0, 5) : $config['label'] }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            {{-- Admin Summary View --}}
                                            <div class="attendance-summary">
                                                @foreach($dayEvents as $event)
                                                    @php
                                                        $statusColors = [
                                                            'present' => '#10b981',
                                                            'late' => '#f59e0b',
                                                            'absent' => '#ef4444',
                                                            'permission' => '#3b82f6',
                                                            'sick' => '#a855f7',
                                                        ];
                                                        $color = $statusColors[$event['status']] ?? '#6b7280';
                                                    @endphp
                                                    <div class="summary-dot" style="background: {{ $color }};">
                                                        <span class="dot-count">{{ $event['count'] }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        {{-- Tasks Mode --}}
                                        @foreach(array_slice($dayEvents, 0, 2) as $event)
                                            @php
                                                $priorityColors = [
                                                    'high' => ['bg' => '#fee2e2', 'text' => '#dc2626', 'border' => '#fca5a5'],
                                                    'medium' => ['bg' => '#fef3c7', 'text' => '#d97706', 'border' => '#fcd34d'],
                                                    'low' => ['bg' => '#dcfce7', 'text' => '#16a34a', 'border' => '#86efac'],
                                                ];
                                                $colors = $priorityColors[$event['priority']] ?? $priorityColors['low'];
                                            @endphp

                                            @if($event['type'] === 'task')
                                                <a href="{{ route('tasks.show', $event['id']) }}" class="task-badge"
                                                    style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }};">
                                                    {{ Str::limit($event['title'], 15) }}
                                                </a>
                                            @elseif($event['type'] === 'task_assignment')
                                                @php
                                                    $progress = $event['total'] > 0 ? round(($event['completed'] / $event['total']) * 100) : 0;
                                                @endphp
                                                <a href="{{ route('task-assignments.show', $event['id']) }}" class="task-badge"
                                                    style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; border: 1px solid {{ $colors['border'] }};"
                                                    title="{{ $event['title'] }} ({{ $progress }}%)">
                                                    {{ Str::limit($event['title'], 12) }}
                                                    <span class="progress-badge">{{ $progress }}%</span>
                                                </a>
                                            @endif
                                        @endforeach

                                        @if(count($dayEvents) > 2)
                                            <div class="more-events">+{{ count($dayEvents) - 2 }} lagi</div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div class="calendar-legend">
            @if($viewMode === 'attendance')
                <div class="legend-items">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #10b981;"></span>
                        <span>Hadir</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #f59e0b;"></span>
                        <span>Terlambat</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #ef4444;"></span>
                        <span>Absen</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #3b82f6;"></span>
                        <span>Izin</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #a855f7;"></span>
                        <span>Sakit</span>
                    </div>
                </div>
                @if(auth()->user()->canManage())
                    <div class="legend-hint">
                        <i class="fas fa-mouse-pointer"></i> Klik tanggal untuk detail
                    </div>
                @endif
            @else
                <div class="legend-items">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #fee2e2; border: 2px solid #fca5a5;"></span>
                        <span>Prioritas Tinggi</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #fef3c7; border: 2px solid #fcd34d;"></span>
                        <span>Prioritas Sedang</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #dcfce7; border: 2px solid #86efac;"></span>
                        <span>Prioritas Rendah</span>
                    </div>
                </div>
                @if(auth()->user()->canManage())
                    <div class="legend-hint">
                        <i class="fas fa-hand-pointer"></i> Klik tugas untuk statistik
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Attendance Stats Modal -->
    @if($showModal && $viewMode === 'attendance')
        <div class="modal-overlay" wire:click.self="closeModal">
            <div class="modal-content attendance-modal">
                <!-- Modal Header -->
                <div class="modal-header">
                    <div>
                        <h3>
                            <i class="fas fa-calendar-day" style="color: var(--accent-primary);"></i>
                            Statistik Kehadiran
                        </h3>
                        <p class="modal-subtitle">{{ $modalData['date'] ?? '' }}</p>
                    </div>
                    <button wire:click="closeModal" class="modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Stats Grid -->
                <div class="modal-body">
                    <div class="stats-grid-modal">
                        <div class="stat-box stat-present">
                            <div class="stat-number">{{ $modalData['present'] ?? 0 }}</div>
                            <div class="stat-label">Hadir</div>
                        </div>
                        <div class="stat-box stat-late">
                            <div class="stat-number">{{ $modalData['late'] ?? 0 }}</div>
                            <div class="stat-label">Terlambat</div>
                        </div>
                        <div class="stat-box stat-absent">
                            <div class="stat-number">{{ $modalData['absent'] ?? 0 }}</div>
                            <div class="stat-label">Belum Absen</div>
                        </div>
                    </div>

                    <div class="stats-grid-modal secondary">
                        <div class="stat-box stat-permission">
                            <div class="stat-number">{{ $modalData['permission'] ?? 0 }}</div>
                            <div class="stat-label">Izin</div>
                        </div>
                        <div class="stat-box stat-sick">
                            <div class="stat-number">{{ $modalData['sick'] ?? 0 }}</div>
                            <div class="stat-label">Sakit</div>
                        </div>
                        <div class="stat-box stat-total">
                            <div class="stat-number">{{ $modalData['total'] ?? 0 }}</div>
                            <div class="stat-label">Total Siswa</div>
                        </div>
                    </div>

                    <!-- Attendance List -->
                    @if(!empty($modalData['attendances']))
                        <div class="attendance-list-section">
                            <h4><i class="fas fa-users"></i> Detail Kehadiran</h4>
                            <div class="attendance-table-wrapper">
                                <table class="attendance-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <th>Status</th>
                                            <th>Masuk</th>
                                            <th>Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($modalData['attendances'] as $att)
                                            @php
                                                $statusLabels = [
                                                    'present' => ['label' => 'Hadir', 'class' => 'status-present'],
                                                    'late' => ['label' => 'Terlambat', 'class' => 'status-late'],
                                                    'permission' => ['label' => 'Izin', 'class' => 'status-permission'],
                                                    'sick' => ['label' => 'Sakit', 'class' => 'status-sick'],
                                                    'absent' => ['label' => 'Absen', 'class' => 'status-absent'],
                                                ];
                                                $statusInfo = $statusLabels[$att['status']] ?? $statusLabels['absent'];
                                            @endphp
                                            <tr>
                                                <td class="name-cell">{{ $att['name'] }}</td>
                                                <td>
                                                    <span
                                                        class="status-badge {{ $statusInfo['class'] }}">{{ $statusInfo['label'] }}</span>
                                                </td>
                                                <td class="time-cell">{{ $att['check_in'] ? substr($att['check_in'], 0, 5) : '-' }}
                                                </td>
                                                <td class="time-cell">
                                                    {{ $att['check_out'] ? substr($att['check_out'], 0, 5) : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Tidak ada data kehadiran untuk tanggal ini</p>
                        </div>
                    @endif
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button wire:click="closeModal" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Calendar Grid */
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
        }

        .calendar-header-cell {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            padding: 12px 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .calendar-cell {
            min-height: 100px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 10px;
            background: var(--bg-card);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .calendar-cell.empty {
            background: transparent;
            border: none;
        }

        .calendar-cell.today {
            background: rgba(99, 102, 241, 0.08);
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
        }

        .calendar-cell.clickable {
            cursor: pointer;
        }

        .calendar-cell.clickable:hover {
            border-color: var(--accent-primary);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.15);
            transform: translateY(-2px);
        }

        .day-number {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .day-number.today {
            color: var(--accent-primary);
            font-weight: 800;
        }

        .events-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        /* Attendance Badges */
        .attendance-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 4px 8px;
            border-radius: 6px;
            color: white;
            font-size: 11px;
            font-weight: 600;
        }

        .attendance-badge i {
            font-size: 10px;
        }

        /* Attendance Summary (Admin View) */
        .attendance-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .summary-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .dot-count {
            color: white;
            font-size: 11px;
            font-weight: 700;
        }

        /* Task Badges */
        .task-badge {
            display: block;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: all 0.2s;
        }

        .task-badge:hover {
            opacity: 0.8;
            transform: scale(1.02);
        }

        .progress-badge {
            font-size: 9px;
            opacity: 0.8;
            margin-left: 4px;
        }

        .more-events {
            font-size: 11px;
            color: var(--text-muted);
            text-align: center;
            padding: 2px;
        }

        /* Legend */
        .calendar-legend {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .legend-items {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .legend-dot {
            width: 14px;
            height: 14px;
            border-radius: 4px;
        }

        .legend-hint {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content.attendance-modal {
            background: var(--bg-card);
            border-radius: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 85vh;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-subtitle {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .modal-close {
            background: var(--bg-tertiary);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            font-size: 16px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: var(--accent-primary);
            color: white;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
            flex: 1;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border-color);
            text-align: right;
        }

        /* Stats Grid in Modal */
        .stats-grid-modal {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .stats-grid-modal.secondary {
            margin-bottom: 24px;
        }

        .stat-box {
            padding: 20px;
            border-radius: 14px;
            text-align: center;
        }

        .stat-box .stat-number {
            font-size: 32px;
            font-weight: 800;
            line-height: 1;
        }

        .stat-box .stat-label {
            font-size: 12px;
            font-weight: 600;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-present {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        }

        .stat-present .stat-number,
        .stat-present .stat-label {
            color: #166534;
        }

        .stat-late {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
        }

        .stat-late .stat-number,
        .stat-late .stat-label {
            color: #92400e;
        }

        .stat-absent {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
        }

        .stat-absent .stat-number,
        .stat-absent .stat-label {
            color: #991b1b;
        }

        .stat-permission {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .stat-permission .stat-number,
        .stat-permission .stat-label {
            color: #1e40af;
        }

        .stat-sick {
            background: linear-gradient(135deg, #fae8ff, #f5d0fe);
        }

        .stat-sick .stat-number,
        .stat-sick .stat-label {
            color: #86198f;
        }

        .stat-total {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        }

        .stat-total .stat-number,
        .stat-total .stat-label {
            color: #374151;
        }

        .stats-grid-modal.secondary .stat-box {
            padding: 14px;
        }

        .stats-grid-modal.secondary .stat-number {
            font-size: 24px;
        }

        /* Attendance Table */
        .attendance-list-section h4 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .attendance-table-wrapper {
            max-height: 220px;
            overflow-y: auto;
            border: 1px solid var(--border-color);
            border-radius: 12px;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            background: var(--bg-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        .attendance-table td {
            padding: 12px;
            border-top: 1px solid var(--border-color);
            font-size: 13px;
        }

        .attendance-table .name-cell {
            font-weight: 600;
        }

        .attendance-table .time-cell {
            color: var(--text-muted);
            text-align: center;
            font-family: monospace;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-present {
            background: #dcfce7;
            color: #166534;
        }

        .status-late {
            background: #fef3c7;
            color: #92400e;
        }

        .status-permission {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-sick {
            background: #fae8ff;
            color: #86198f;
        }

        .status-absent {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .calendar-header-cell {
                font-size: 10px;
                padding: 8px 4px;
            }

            .calendar-cell {
                min-height: 70px;
                padding: 6px;
            }

            .day-number {
                font-size: 13px;
            }

            .stats-grid-modal {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-box .stat-number {
                font-size: 24px;
            }
        }
    </style>
</div>
