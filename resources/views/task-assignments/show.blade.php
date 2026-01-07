@extends('layouts.app')

@section('title', 'Detail Tugas: ' . $taskAssignment->title)

@section('content')
<div class="slide-up">
    <!-- Header -->
    <div class="d-flex align-center gap-4 mb-6">
        <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary btn-icon">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div style="flex: 1;">
            <div class="d-flex gap-2 align-center mb-2">
                <span class="badge badge-{{ $taskAssignment->priority_color }}">
                    {{ strtoupper($taskAssignment->priority) }}
                </span>
                @if($taskAssignment->deadline && $taskAssignment->deadline->isPast())
                    <span class="badge badge-danger">DEADLINE LEWAT</span>
                @endif
            </div>
            <h2 style="margin: 0;">{{ $taskAssignment->title }}</h2>
            <p class="text-muted" style="margin-top: 4px;">
                Dibuat oleh {{ $taskAssignment->assignedBy->name ?? 'Admin' }} • {{ $taskAssignment->created_at->format('d M Y H:i') }}
            </p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid mb-6">
        <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['completed'] }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['submitted'] }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </div>
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="fas fa-spinner"></i></div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['in_progress'] + $stats['pending'] }}</div>
                <div class="stat-label">Belum Selesai</div>
            </div>
        </div>
    </div>

    <!-- Progress & Charts Row -->
    <div class="grid-2 mb-6">
        <!-- Progress Overview -->
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-chart-pie" style="color: #8b5cf6;"></i> Progress Keseluruhan</h3>
            </div>

            <!-- Big Progress Circle -->
            <div class="progress-circle-container">
                <div class="progress-circle" style="--progress: {{ $stats['progress_percentage'] }};">
                    <span class="progress-value">{{ $stats['progress_percentage'] }}%</span>
                    <span class="progress-text">Selesai</span>
                </div>
            </div>

            <!-- Detailed Breakdown -->
            <div class="progress-breakdown">
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #10b981;"></span>
                    <span class="breakdown-label">Tepat Waktu</span>
                    <span class="breakdown-value">{{ $stats['completed_on_time'] }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #ef4444;"></span>
                    <span class="breakdown-label">Terlambat</span>
                    <span class="breakdown-value">{{ $stats['completed_late'] }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #8b5cf6;"></span>
                    <span class="breakdown-label">Review</span>
                    <span class="breakdown-value">{{ $stats['submitted'] }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #3b82f6;"></span>
                    <span class="breakdown-label">Dikerjakan</span>
                    <span class="breakdown-value">{{ $stats['in_progress'] }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #f59e0b;"></span>
                    <span class="breakdown-label">Revisi</span>
                    <span class="breakdown-value">{{ $stats['revision'] }}</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-dot" style="background: #9ca3af;"></span>
                    <span class="breakdown-label">Belum Mulai</span>
                    <span class="breakdown-value">{{ $stats['pending'] }}</span>
                </div>
            </div>
        </div>

        <!-- Task Details & Chart -->
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-info-circle" style="color: #3b82f6;"></i> Detail Tugas</h3>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Deadline</span>
                    <span class="detail-value {{ $taskAssignment->deadline && $taskAssignment->deadline->isPast() ? 'text-danger' : '' }}">
                        @if($taskAssignment->deadline)
                            {{ $taskAssignment->deadline->format('d M Y') }}
                            @if($taskAssignment->deadline_time) {{ $taskAssignment->deadline_time }} @endif
                        @else
                            Tidak ada
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Estimasi Waktu</span>
                    <span class="detail-value">{{ $taskAssignment->estimated_hours ?? '-' }} jam</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Metode Submit</span>
                    <span class="detail-value">
                        @if($taskAssignment->submission_type == 'github') GitHub
                        @elseif($taskAssignment->submission_type == 'file') Upload File
                        @else GitHub / File
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Rata-rata Nilai</span>
                    <span class="detail-value" style="font-size: 24px; font-weight: 800; color: #10b981;">
                        {{ $stats['average_score'] ?: '-' }}
                    </span>
                </div>
            </div>

            @if($taskAssignment->description)
                <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--border-color);">
                    <h4 style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px;">Deskripsi</h4>
                    <p style="color: var(--text-secondary); line-height: 1.6; white-space: pre-line;">{{ $taskAssignment->description }}</p>
                </div>
            @endif

            <!-- Donut Chart -->
            <div style="margin-top: 20px; height: 200px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Students List by Status -->
    <div class="card">
        <div class="card-header border-0">
            <h3 class="card-title"><i class="fas fa-user-graduate" style="color: #6366f1;"></i> Daftar Siswa</h3>
        </div>

        <!-- Tab Navigation -->
        <div class="status-tabs">
            <button class="status-tab active" data-status="all">
                <span>Semua</span>
                <span class="tab-count">{{ $stats['total'] }}</span>
            </button>
            <button class="status-tab" data-status="completed">
                <span>Selesai</span>
                <span class="tab-count tab-green">{{ $stats['completed'] }}</span>
            </button>
            <button class="status-tab" data-status="submitted">
                <span>Review</span>
                <span class="tab-count tab-purple">{{ $stats['submitted'] }}</span>
            </button>
            <button class="status-tab" data-status="in_progress">
                <span>Proses</span>
                <span class="tab-count tab-blue">{{ $stats['in_progress'] }}</span>
            </button>
            <button class="status-tab" data-status="pending">
                <span>Belum</span>
                <span class="tab-count tab-gray">{{ $stats['pending'] }}</span>
            </button>
        </div>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table" id="studentsTable">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Sekolah</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskAssignment->tasks->sortByDesc(function($task) {
                        $order = ['submitted' => 5, 'revision' => 4, 'in_progress' => 3, 'pending' => 2, 'completed' => 1];
                        return $order[$task->status] ?? 0;
                    }) as $task)
                        <tr class="student-row" data-status="{{ $task->status }}">
                            <td>
                                <div class="d-flex align-center gap-3">
                                    <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">
                                        {{ strtoupper(substr($task->intern->user->name ?? 'N', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $task->intern->user->name ?? 'N/A' }}</strong>
                                        <div class="text-muted" style="font-size: 11px;">{{ $task->intern->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $task->intern->school ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $task->status_color }}">
                                    {{ $task->status_label }}
                                </span>
                                @if($task->is_late)
                                    <span class="badge badge-danger" style="font-size: 9px;">LATE</span>
                                @endif
                            </td>
                            <td>
                                @if($task->submitted_at)
                                    {{ $task->submitted_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($task->score)
                                    <span style="font-weight: 700; color: {{ $task->score >= 80 ? '#10b981' : ($task->score >= 60 ? '#f59e0b' : '#ef4444') }};">
                                        {{ $task->score }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($task->status === 'submitted')
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-check"></i> Review
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        border-radius: var(--radius-lg);
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
    }

    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-total .stat-icon { background: rgba(99, 102, 241, 0.15); color: #6366f1; }
    .stat-success .stat-icon { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .stat-warning .stat-icon { background: rgba(139, 92, 246, 0.15); color: #8b5cf6; }
    .stat-primary .stat-icon { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }

    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
    }

    .stat-card .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    .progress-circle-container {
        display: flex;
        justify-content: center;
        padding: 20px 0;
    }

    .progress-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: conic-gradient(
            #10b981 calc(var(--progress) * 1%),
            var(--bg-tertiary) calc(var(--progress) * 1%)
        );
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-circle::before {
        content: '';
        position: absolute;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: var(--bg-secondary);
    }

    .progress-value {
        position: relative;
        font-size: 32px;
        font-weight: 800;
        color: #10b981;
    }

    .progress-text {
        position: relative;
        font-size: 12px;
        color: var(--text-muted);
        margin-top: -4px;
    }

    .progress-breakdown {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 16px;
        background: var(--bg-tertiary);
        border-radius: 12px;
    }

    .breakdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .breakdown-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .breakdown-label {
        flex: 1;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .breakdown-value {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .detail-item {
        padding: 12px 16px;
        background: var(--bg-tertiary);
        border-radius: 8px;
    }

    .detail-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 4px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .status-tabs {
        display: flex;
        gap: 8px;
        padding: 0 0 16px 0;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .status-tab {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        transition: all 0.2s;
    }

    .status-tab:hover {
        border-color: var(--accent-primary);
    }

    .status-tab.active {
        background: var(--accent-primary);
        border-color: var(--accent-primary);
        color: white;
    }

    .tab-count {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 10px;
        background: rgba(0,0,0,0.1);
    }

    .status-tab.active .tab-count {
        background: rgba(255,255,255,0.2);
    }

    .tab-green { color: #10b981; }
    .tab-purple { color: #8b5cf6; }
    .tab-blue { color: #3b82f6; }
    .tab-gray { color: #6b7280; }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Chart
    new Chart(document.getElementById('statusChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Selesai', 'Review', 'Proses', 'Revisi', 'Belum Mulai'],
            datasets: [{
                data: [
                    {{ $stats['completed'] }},
                    {{ $stats['submitted'] }},
                    {{ $stats['in_progress'] }},
                    {{ $stats['revision'] }},
                    {{ $stats['pending'] }}
                ],
                backgroundColor: ['#10b981', '#8b5cf6', '#3b82f6', '#f59e0b', '#9ca3af'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#64748b',
                        font: { size: 11 },
                        padding: 12,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Tab Filtering
    document.querySelectorAll('.status-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active class
            document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const status = this.dataset.status;

            // Filter rows
            document.querySelectorAll('.student-row').forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
@endsection
