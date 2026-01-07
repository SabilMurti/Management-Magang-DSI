<div class="slide-up">
    <div class="d-flex justify-between align-center mb-6" style="flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="margin-bottom: 4px;">Presensi Magang</h2>
            <p class="text-muted">Kelola kehadiran siswa magang</p>
        </div>
        <div class="d-flex gap-3">
            @if(auth()->user()->canManage())
                <button class="btn btn-secondary"
                    onclick="window.location.href='{{ route('export.attendances', array_filter(['date' => $date, 'status' => $status !== '' ? $status : null])) }}'">
                    <i class="fas fa-file-excel"></i> Export Excel
                </button>
                <a href="{{ route('attendances.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Presensi
                </a>
            @endif
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group" style="max-width: 200px;">
            <label>Tanggal</label>
            <input type="date" wire:model.live="date" class="form-control">
        </div>
        <div class="filter-group" style="max-width: 200px;">
            <label>Bulan</label>
            <input type="month" wire:model.live="month" class="form-control">
        </div>
        <div class="filter-group" style="max-width: 180px;">
            <label>Status</label>
            <select wire:model.live="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="present">Hadir</option>
                <option value="late">Terlambat</option>
                <option value="absent">Tidak Hadir</option>
                <option value="sick">Sakit</option>
                <option value="permission">Izin</option>
            </select>
        </div>
        @if(auth()->user()->canManage())
            <div class="filter-group" style="max-width: 200px;">
                <label>Siswa</label>
                <select wire:model.live="intern_id" class="form-control">
                    <option value="">Semua Siswa</option>
                    @foreach($interns as $intern)
                        <option value="{{ $intern->id }}">
                            {{ $intern->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>

    <!-- Bulk Actions Bar -->
    @if(auth()->user()->canManage() && count($selectedAttendances) > 0)
        <div class="bulk-action-bar card"
            style="margin-bottom: 16px; padding: 16px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%); border: none;">
            <div style="color: white; font-weight: 600;">
                <i class="fas fa-check-square"></i> {{ count($selectedAttendances) }} item dipilih
            </div>
            <div class="d-flex gap-2" style="flex: 1;">
                <select wire:model="bulkAction" class="form-control"
                    style="max-width: 200px; background: rgba(255,255,255,0.95);">
                    <option value="">-- Pilih Aksi --</option>
                    <option value="present">✅ Set Hadir</option>
                    <option value="late">⏰ Set Terlambat</option>
                    <option value="absent">❌ Set Tidak Hadir</option>
                    <option value="sick">🏥 Set Sakit</option>
                    <option value="permission">📝 Set Izin</option>
                    <option value="delete">🗑️ Hapus</option>
                </select>
                <button wire:click="executeBulkAction"
                    wire:confirm="Yakin ingin melakukan aksi ini pada {{ count($selectedAttendances) }} data?" class="btn"
                    style="background: white; color: var(--accent-primary); font-weight: 600;">
                    <i class="fas fa-play"></i> Jalankan
                </button>
            </div>
            <button wire:click="resetBulkSelection" class="btn" style="background: rgba(255,255,255,0.2); color: white;">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
    @endif

    <div class="card">
        @if($attendances->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <h4 class="empty-state-title">Belum Ada Presensi</h4>
                <p class="empty-state-text">Mulai dengan menambahkan data presensi.</p>
                @if(auth()->user()->canManage())
                    <a href="{{ route('attendances.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Presensi
                    </a>
                @endif
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            @if(auth()->user()->canManage())
                                <th style="width: 50px;">
                                    <input type="checkbox" wire:model.live="selectAll" class="form-checkbox"
                                        style="width: 18px; height: 18px; cursor: pointer;">
                                </th>
                                <th>Siswa</th>
                            @endif
                            <th>Tanggal</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr wire:key="attendance-{{ $attendance->id }}"
                                class="{{ in_array((string) $attendance->id, $selectedAttendances) ? 'selected-row' : '' }}">
                                @if(auth()->user()->canManage())
                                    <td>
                                        <input type="checkbox" wire:model.live="selectedAttendances" value="{{ $attendance->id }}"
                                            class="form-checkbox" style="width: 18px; height: 18px; cursor: pointer;">
                                    </td>
                                    <td>
                                        @if($attendance->intern)
                                            <div class="d-flex align-center gap-2">
                                                <div class="user-avatar" style="width: 28px; height: 28px; font-size: 11px;">
                                                    {{ strtoupper(substr($attendance->intern->user->name ?? 'N', 0, 1)) }}
                                                </div>
                                                <span style="font-size: 13px;">{{ $attendance->intern->user->name ?? 'N/A' }}</span>
                                            </div>
                                        @else
                                            <span class="badge badge-secondary" style="font-size: 11px;">
                                                <i class="fas fa-user-slash"></i> Siswa Dihapus
                                            </span>
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $attendance->date->format('d M Y') }}</td>
                                <td>
                                    @if($attendance->check_in)
                                        <span style="font-size: 13px;">{{ $attendance->check_in->format('H:i') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->check_out)
                                        <span style="font-size: 13px;">{{ $attendance->check_out->format('H:i') }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $attendance->status_color }}">
                                        {{ $attendance->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <span style="font-size: 12px;">{{ Str::limit($attendance->notes ?? '-', 30) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('attendances.show', $attendance) }}" class="btn btn-sm btn-primary"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->canManage())
                                            <a href="{{ route('attendances.edit', $attendance) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button wire:click="deleteAttendance({{ $attendance->id }})"
                                                wire:confirm="Yakin ingin menghapus presensi ini?" class="btn btn-sm btn-danger"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $attendances->links('vendor.livewire.simple-pagination') }}
            </div>
        @endif
    </div>

    <style>
        .selected-row {
            background: rgba(167, 139, 250, 0.1) !important;
        }

        .selected-row:hover {
            background: rgba(167, 139, 250, 0.15) !important;
        }

        .form-checkbox {
            accent-color: var(--accent-primary);
        }

        .bulk-action-bar {
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>
