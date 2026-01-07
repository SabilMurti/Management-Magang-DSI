@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Custom Style for White/Sweet/Acrylic Theme (No Gradient) -->
    @push('styles')
        <style>
            /* Styling Dasar Dashboard */
            .dashboard-container {
                position: relative;
            }

            /* Acrylic Cards - Solid Feel */
            .card,
            .stat-card {
                background: rgba(255, 255, 255, 0.85) !important;
                /* Lebih solid */
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
                /* Light border */
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
                border-radius: 20px !important;
                transition: transform 0.2s ease, box-shadow 0.2s ease !important;
            }

            .card:hover,
            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025) !important;
            }

            .card-header {
                border-bottom: 1px solid #f1f5f9 !important;
                padding-bottom: 20px !important;
                margin-bottom: 24px !important;
            }

            /* Sweet Stats Symbols (Solid Colors) */
            .stat-value {
                color: #1e293b;
                /* Solid Dark Color */
                font-weight: 800 !important;
            }

            .stat-label {
                font-weight: 500;
                color: #64748b !important;
                letter-spacing: 0.5px;
            }

            .stat-icon {
                border-radius: 16px !important;
                width: 60px !important;
                height: 60px !important;
                font-size: 24px !important;
                margin-bottom: 20px !important;
                box-shadow: none !important;
                /* Remove shadow for cleaner look */
            }

            /* Solid Pastel Colors */
            .stat-icon.primary {
                background-color: #ddd6fe !important;
                /* Violet 200 */
                color: #5b21b6 !important;
                /* Violet 800 */
            }

            .stat-icon.success {
                background-color: #bbf7d0 !important;
                /* Green 200 */
                color: #166534 !important;
                /* Green 800 */
            }

            .stat-icon.warning {
                background-color: #fed7aa !important;
                /* Orange 200 */
                color: #9a3412 !important;
                /* Orange 800 */
            }

            .stat-icon.info {
                background-color: #bae6fd !important;
                /* Sky 200 */
                color: #075985 !important;
                /* Sky 800 */
            }

            /* Typography */
            h2,
            h3,
            .card-title {
                color: #334155;
                letter-spacing: -0.3px;
            }

            .text-muted {
                color: #94a3b8 !important;
            }

            /* Buttons (Solid) */
            .btn {
                border-radius: 10px !important;
                font-weight: 600 !important;
                letter-spacing: 0.3px;
                box-shadow: none !important;
                border: none !important;
            }

            .btn-primary {
                background-color: #8b5cf6 !important;
                /* Violet 500 */
                color: white !important;
            }

            .btn-primary:hover {
                background-color: #7c3aed !important;
                /* Violet 600 */
            }

            .btn-secondary {
                background-color: #f8fafc !important;
                /* Slate 50 */
                color: #475569 !important;
                /* Slate 600 */
                border: 1px solid #e2e8f0 !important;
            }

            .btn-secondary:hover {
                background-color: #f1f5f9 !important;
                /* Slate 100 */
                color: #1e293b !important;
            }

            /* Tables */
            table {
                border-spacing: 0;
                border-collapse: separate !important;
                width: 100%;
            }

            thead th {
                border: none !important;
                background: transparent !important;
                color: #94a3b8 !important;
                text-transform: uppercase;
                font-size: 11px !important;
                letter-spacing: 1px;
                padding-bottom: 12px !important;
            }

            tbody tr {
                background: transparent;
                transition: background-color 0.2s ease;
            }

            tbody tr:hover {
                background-color: #f8fafc !important;
            }

            td {
                border-bottom: 1px solid #f1f5f9 !important;
                padding: 16px 12px !important;
            }

            /* Badges (Pastel Solid) */
            .badge {
                padding: 6px 12px !important;
                border-radius: 6px !important;
                font-weight: 600 !important;
                font-size: 11px !important;
            }

            /* Warna Badge Custom */
            .badge-success {
                background-color: #dcfce7 !important;
                color: #166534 !important;
            }

            .badge-warning {
                background-color: #ffedd5 !important;
                color: #9a3412 !important;
            }

            .badge-danger {
                background-color: #fee2e2 !important;
                color: #991b1b !important;
            }

            .badge-info {
                background-color: #e0f2fe !important;
                color: #075985 !important;
            }

            .badge-primary {
                background-color: #ede9fe !important;
                color: #5b21b6 !important;
            }
        </style>
    @endpush

    <div class="dashboard-container slide-up">
        <!-- Header tanpa gradien -->
        <div style="margin-bottom: 30px;">
            <h2 style="font-size: 28px; margin-bottom: 8px; font-weight: 700; color: #1e293b;">Selamat Datang,
                {{ auth()->user()->name }}! 👋
            </h2>
            <p style="color: #64748b; font-size: 15px;">Dashboard ringkas dan bersih untuk memantau aktivitas magang.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $totalInterns }}</div>
                <div class="stat-label">Total Siswa</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value">{{ $completedOnTime }}</div>
                <div class="stat-label">Tepat Waktu</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value">{{ $completedLate }}</div>
                <div class="stat-label">Terlambat</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $presentToday }} / {{ $totalInterns }}</div>
                <div class="stat-label">Kehadiran</div>
            </div>
        </div>

        <!-- Task Overview Card -->
        <div class="card mb-6 mt-6">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-chart-pie" style="color: #8b5cf6; margin-right: 8px;"></i> Statistik
                    Tugas</h3>
                <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Buat Tugas
                </a>
            </div>
            <div class="grid-2" style="align-items: center;">
                <div class="chart-container" style="height: 250px;">
                    <canvas id="taskPieChart"></canvas>
                </div>
                <div>
                    <div class="task-stat-item"
                        style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; padding: 12px 16px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div style="width: 10px; height: 10px; background-color: #4ade80; border-radius: 50%;"></div>
                        <div style="flex: 1; color: #475569; font-weight: 500; font-size: 14px;">Tepat Waktu</div>
                        <strong style="color: #1e293b; font-size: 16px;">{{ $completedOnTime }}</strong>
                    </div>
                    <div class="task-stat-item"
                        style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; padding: 12px 16px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div style="width: 10px; height: 10px; background-color: #fbbf24; border-radius: 50%;"></div>
                        <div style="flex: 1; color: #475569; font-weight: 500; font-size: 14px;">Terlambat</div>
                        <strong style="color: #1e293b; font-size: 16px;">{{ $completedLate }}</strong>
                    </div>
                    <div class="task-stat-item"
                        style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px; padding: 12px 16px; background-color: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                        <div style="width: 10px; height: 10px; background-color: #a78bfa; border-radius: 50%;"></div>
                        <div style="flex: 1; color: #475569; font-weight: 500; font-size: 14px;">Dalam Proses</div>
                        <strong style="color: #1e293b; font-size: 16px;">{{ $pendingTasks }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submitted Tasks (Pending Review) -->
        @if(isset($submittedTasks) && $submittedTasks->isNotEmpty())
            <div class="card mb-6"
                style="border: 2px solid #bae6fd !important; background: linear-gradient(to right, #f0f9ff, #e0f2fe) !important;">
                <div class="card-header border-0" style="background: transparent !important; padding-bottom: 10px !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title" style="color: #0284c7; font-weight: 700;">
                            <i class="fas fa-clipboard-check" style="margin-right: 8px; font-size: 20px;"></i> Tugas Menunggu
                            Review
                            <span class="badge"
                                style="background: #0284c7; color: white; margin-left: 8px; border-radius: 50%; padding: 4px 10px;">{{ $submittedTasks->count() }}</span>
                        </h3>
                    </div>
                    <p style="color: #0369a1; margin: 4px 0 0 32px; font-size: 14px;">Tugas berikut menunggu penilaian dan
                        konfirmasi dari Anda.</p>
                </div>
                <div class="table-container" style="padding: 0 20px 20px;">
                    <table>
                        <thead>
                            <tr>
                                <th style="color: #0369a1; border-color: #bae6fd !important;">Tugas</th>
                                <th style="color: #0369a1; border-color: #bae6fd !important;">Siswa</th>
                                <th style="color: #0369a1; border-color: #bae6fd !important;">Waktu Submit</th>
                                <th style="color: #0369a1; text-align: right; border-color: #bae6fd !important;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submittedTasks as $task)
                                <tr style="border-bottom-color: #e0f2fe !important;">
                                    <td style="border-bottom-color: #e0f2fe !important;">
                                        <div style="font-weight: 600; color: #0c4a6e;">{{ Str::limit($task->title, 40) }}</div>
                                        @if($task->is_late)
                                            <span class="badge badge-warning" style="font-size: 10px;">Terlambat</span>
                                        @endif
                                    </td>
                                    <td style="color: #0284c7; border-bottom-color: #e0f2fe !important;">
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                style="width: 24px; height: 24px; background: #bae6fd; color: #0284c7; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 10px;">
                                                {{ substr($task->intern->user->name, 0, 1) }}
                                            </div>
                                            {{ $task->intern->user->name }}
                                        </div>
                                    </td>
                                    <td style="color: #0284c7; border-bottom-color: #e0f2fe !important;">
                                        {{ $task->submitted_at->diffForHumans() }}
                                    </td>
                                    <td style="text-align: right; border-bottom-color: #e0f2fe !important;">
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-primary shadow-sm"
                                            style="background: #0284c7 !important; border: none; padding: 6px 16px;">
                                            <i class="fas fa-feather-alt me-1"></i> Review & Nilai
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="grid-2">
            <!-- Recent Tasks -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-tasks" style="color: #f59e0b; margin-right: 8px;"></i> Tugas
                        Terbaru</h3>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">Semua</a>
                </div>

                @if($recentTasks->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada tugas.</p>
                    </div>
                @else
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tugas</th>
                                    <th>Siswa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTasks as $task)
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600; color: #334155;">{{ Str::limit($task->title, 20) }}</div>
                                            @if($task->is_late && $task->status === 'completed')
                                                <span class="badge badge-danger" style="margin-top: 2px;">Late</span>
                                            @endif
                                        </td>
                                        <td style="color: #64748b; font-size: 13px;">{{ $task->intern->user->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $task->status_color }}">
                                                {{ $task->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Today's Attendance -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-calendar-check" style="color: #0ea5e9; margin-right: 8px;"></i>
                        Presensi Hari Ini</h3>
                    <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-secondary">Semua</a>
                </div>

                @if($recentAttendances->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada presensi.</p>
                    </div>
                @else
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAttendances as $attendance)
                                    <tr>
                                        <td style="color: #334155; font-weight: 500;">{{ $attendance->intern->user->name ?? '-' }}
                                        </td>
                                        <td style="font-family: monospace; color: #64748b;">{{ $attendance->check_in ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $attendance->status_color }}">
                                                {{ $attendance->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($attendance->proof_file)
                                                <a href="{{ asset('storage/' . $attendance->proof_file) }}" target="_blank"
                                                    style="color: #6366f1;">
                                                    <i class="fas fa-paperclip"></i> Lihat
                                                </a>
                                            @elseif($attendance->status == 'sick' || $attendance->status == 'permission')
                                                <span style="color: #ef4444; font-size: 11px;">-</span>
                                            @else
                                                <span style="color: #94a3b8;">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Attendance Charts Row -->
        <div class="grid-2 mt-6">
            <!-- Attendance Today - Donut Chart -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-user-check" style="color: #10b981; margin-right: 8px;"></i>
                        Kehadiran Hari Ini</h3>
                </div>
                <div class="chart-container" style="height: 280px;">
                    <canvas id="attendanceTodayChart"></canvas>
                </div>
            </div>

            <!-- Weekly Attendance Trend - Bar Chart -->
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title"><i class="fas fa-chart-bar" style="color: #6366f1; margin-right: 8px;"></i> Tren
                        Kehadiran 7 Hari</h3>
                </div>
                <div class="chart-container" style="height: 280px;">
                    <canvas id="attendanceTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Performance Line Chart -->
        <div class="card mt-6">
            <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-chart-line" style="color: #f43f5e; margin-right: 8px;"></i> Performa
                    Siswa</h3>
            </div>
            <div class="chart-container" style="height: 350px;">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Task Pie Chart
            new Chart(document.getElementById('taskPieChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Tepat Waktu', 'Terlambat', 'Dalam Proses'],
                    datasets: [{
                        data: [{{ $completedOnTime }}, {{ $completedLate }}, {{ $pendingTasks }}],
                        // Solid Pastel Colors (No Gradient)
                        backgroundColor: ['#4ade80', '#fbbf24', '#a78bfa'],
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
                                font: { family: 'Inter', size: 12 },
                                padding: 20
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });

            // Performance Chart
            const interns = [
                @foreach($interns as $intern)
                                {
                        name: "{{ $intern->user->name }}",
                        on_time: {{ $intern->getCompletedOnTimeCount() }},
                        late: {{ $intern->getCompletedLateCount() }},
                    },
                @endforeach
                    ];

            new Chart(document.getElementById('performanceChart').getContext('2d'), {
                type: 'line', // Reverted to line chart as requested
                data: {
                    labels: interns.map(i => i.name),
                    datasets: [
                        {
                            label: 'Tepat Waktu',
                            data: interns.map(i => i.on_time),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34, 197, 94, 0.15)', // Light green gradient feel
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4, // Smooth curves
                            pointRadius: 6,
                            pointBackgroundColor: '#22c55e',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#16a34a',
                        },
                        {
                            label: 'Terlambat',
                            data: interns.map(i => i.late),
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.15)', // Light orange gradient feel
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4, // Smooth curves
                            pointRadius: 6,
                            pointBackgroundColor: '#f59e0b',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointHoverRadius: 8,
                            pointHoverBackgroundColor: '#d97706',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Inter', size: 12, weight: 500 },
                                padding: 8
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.6)',
                                drawBorder: false,
                            },
                            ticks: {
                                color: '#64748b',
                                font: { family: 'Inter', size: 12 },
                                padding: 12,
                                stepSize: 1
                            },
                            border: { display: false }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                color: '#64748b',
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { family: 'Inter', size: 13, weight: 500 }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(30, 41, 59, 0.95)',
                            titleColor: '#fff',
                            bodyColor: '#e2e8f0',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 12,
                            padding: 14,
                            titleFont: { family: 'Inter', size: 14, weight: 600 },
                            bodyFont: { family: 'Inter', size: 13 },
                            displayColors: true,
                            boxWidth: 12,
                            boxHeight: 12,
                            boxPadding: 4
                        }
                    }
                }
            });

            // Panggil SweetAlert test jika diperlukan (hanya untuk debug)
            // Swal.fire('Dashboard Siap!', 'Tampilan baru tanpa gradient.', 'success');
        // Attendance Today Donut Chart
                    new Chart(document.getElementById('attendanceTodayChart').getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Belum Absen'],
                            datasets: [{
                                data: [
                                    {{ $attendanceToday['present'] }},
                                    {{ $attendanceToday['late'] }},
                                    {{ $attendanceToday['permission'] }},
                                    {{ $attendanceToday['sick'] }},
                                    {{ $attendanceToday['absent'] }}
                                ],
                                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#a855f7', '#ef4444'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'right',
                                    labels: {
                                        color: '#64748b',
                                        font: { family: 'Inter', size: 11 },
                                        padding: 12,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                }
                            },
                            cutout: '65%'
                        }
                    });

                    // Attendance Trend Bar Chart
                    const trendData = @json($attendanceTrend);
                    new Chart(document.getElementById('attendanceTrendChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: trendData.map(d => d.date),
                            datasets: [
                                {
                                    label: 'Hadir',
                                    data: trendData.map(d => d.present),
                                    backgroundColor: '#10b981',
                                    borderRadius: 6,
                                    barThickness: 20
                                },
                                {
                                    label: 'Tidak Hadir',
                                    data: trendData.map(d => d.absent),
                                    backgroundColor: '#ef4444',
                                    borderRadius: 6,
                                    barThickness: 20
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: {
                                    stacked: true,
                                    grid: { display: false },
                                    ticks: { color: '#64748b', font: { size: 11 } }
                                },
                                y: {
                                    stacked: true,
                                    beginAtZero: true,
                                    grid: { color: 'rgba(226, 232, 240, 0.6)' },
                                    ticks: { color: '#64748b', stepSize: 1 }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    align: 'end',
                                    labels: {
                                        color: '#64748b',
                                        usePointStyle: true,
                                        padding: 16,
                                        font: { size: 12 }
                                    }
                                }
                            }
                        }
                    });
                </script>
    @endpush
@endsection
