<div>
    <div class="card">
        <!-- Calendar Header -->
        <div class="card-header"
            style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button wire:click="previousMonth" class="btn btn-icon" style="width: 36px; height: 36px; padding: 0;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h3 style="margin: 0; font-size: 18px; font-weight: 700; min-width: 180px; text-align: center;">
                    {{ $this->monthName }}
                </h3>
                <button wire:click="nextMonth" class="btn btn-icon" style="width: 36px; height: 36px; padding: 0;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- View Mode Toggle -->
            <div style="display: flex; gap: 8px;">
                <button wire:click="switchMode('attendance')"
                    class="btn {{ $viewMode === 'attendance' ? 'btn-primary' : 'btn-secondary' }}"
                    style="padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-calendar-check"></i> Kehadiran
                </button>
                <button wire:click="switchMode('tasks')"
                    class="btn {{ $viewMode === 'tasks' ? 'btn-primary' : 'btn-secondary' }}"
                    style="padding: 8px 16px; font-size: 13px;">
                    <i class="fas fa-tasks"></i> Tugas
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div style="padding: 20px;">
            <!-- Day Headers -->
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; margin-bottom: 8px;">
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $dayName)
                    <div
                        style="text-align: center; font-size: 12px; font-weight: 700; color: var(--text-muted); padding: 8px;">
                        {{ $dayName }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px;">
                @foreach($days as $day)
                    @if($day === null)
                        <div style="min-height: 80px;"></div>
                    @else
                        @php
                            $isToday = $day == now()->day && $currentMonth == now()->month && $currentYear == now()->year;
                            $hasEvents = isset($events[$day]) && count($events[$day]) > 0;
                            $dayEvents = $events[$day] ?? [];
                        @endphp
                        <div style="min-height: 80px; border: 1px solid var(--border-color); border-radius: 8px; padding: 8px; background: {{ $isToday ? 'rgba(167, 139, 250, 0.1)' : 'var(--bg-card)' }}; position: relative; transition: all 0.2s; {{ $isToday ? 'border-color: var(--accent-primary);' : '' }}"
                            onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'"
                            onmouseout="this.style.boxShadow='none'">
                            <!-- Day Number -->
                            <div
                                style="font-size: 14px; font-weight: {{ $isToday ? '700' : '600' }}; color: {{ $isToday ? 'var(--accent-primary)' : 'var(--text-primary)' }}; margin-bottom: 4px;">
                                {{ $day }}
                            </div>

                            <!-- Events -->
                            @if($hasEvents)
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    @foreach(array_slice($dayEvents, 0, 3) as $event)
                                        @if($event['type'] === 'attendance')
                                            @php
                                                $statusColors = [
                                                    'present' => ['bg' => '#dcfce7', 'text' => '#166534', 'icon' => 'fa-check'],
                                                    'late' => ['bg' => '#fef3c7', 'text' => '#92400e', 'icon' => 'fa-clock'],
                                                    'absent' => ['bg' => '#fee2e2', 'text' => '#991b1b', 'icon' => 'fa-times'],
                                                    'permission' => ['bg' => '#dbeafe', 'text' => '#1e40af', 'icon' => 'fa-file'],
                                                    'sick' => ['bg' => '#fae8ff', 'text' => '#86198f', 'icon' => 'fa-notes-medical'],
                                                ];
                                                $colors = $statusColors[$event['status']] ?? $statusColors['absent'];
                                            @endphp
                                            <div
                                                style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                                <i class="fas {{ $colors['icon'] }}" style="font-size: 8px;"></i>
                                                {{ $event['check_in'] ? substr($event['check_in'], 0, 5) : ucfirst($event['status']) }}
                                            </div>
                                        @elseif($event['type'] === 'attendance_summary')
                                            @php
                                                $statusColors = [
                                                    'present' => '#22c55e',
                                                    'late' => '#f59e0b',
                                                    'absent' => '#ef4444',
                                                    'permission' => '#3b82f6',
                                                    'sick' => '#a855f7',
                                                ];
                                            @endphp
                                            <div style="display: flex; align-items: center; gap: 4px;">
                                                <div
                                                    style="width: 8px; height: 8px; border-radius: 50%; background: {{ $statusColors[$event['status']] ?? '#6b7280' }};">
                                                </div>
                                                <span style="font-size: 10px; color: var(--text-muted);">{{ $event['count'] }}</span>
                                            </div>
                                        @elseif($event['type'] === 'task')
                                            @php
                                                $priorityColors = [
                                                    'high' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
                                                    'medium' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                                                    'low' => ['bg' => '#dcfce7', 'text' => '#166534'],
                                                ];
                                                $colors = $priorityColors[$event['priority']] ?? $priorityColors['low'];
                                            @endphp
                                            <a href="{{ route('tasks.show', $event['id']) }}"
                                                style="background: {{ $colors['bg'] }}; color: {{ $colors['text'] }}; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 600; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                title="{{ $event['title'] }}">
                                                {{ Str::limit($event['title'], 12) }}
                                            </a>
                                        @endif
                                    @endforeach

                                    @if(count($dayEvents) > 3)
                                        <div style="font-size: 10px; color: var(--text-muted); text-align: center;">
                                            +{{ count($dayEvents) - 3 }} lagi
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Legend -->
        <div
            style="padding: 16px 20px; border-top: 1px solid var(--border-color); display: flex; gap: 20px; flex-wrap: wrap;">
            @if($viewMode === 'attendance')
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #dcfce7;"></div> Hadir
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #fef3c7;"></div> Terlambat
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #fee2e2;"></div> Absen
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #dbeafe;"></div> Izin
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #fae8ff;"></div> Sakit
                </div>
            @else
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #fee2e2;"></div> High Priority
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #fef3c7;"></div> Medium Priority
                </div>
                <div style="display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-muted);">
                    <div style="width: 12px; height: 12px; border-radius: 3px; background: #dcfce7;"></div> Low Priority
                </div>
            @endif
        </div>
    </div>
</div>
