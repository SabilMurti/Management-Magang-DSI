<div class="slide-up">
    <!-- Header Actions -->
    <div class="d-flex justify-between align-center mb-6" style="flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="margin-bottom: 4px;">Daftar Anggota Magang</h2>
            <p class="text-muted">Kelola data siswa magang</p>
        </div>
        <div class="d-flex gap-3">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="exportDropdown"
                    data-toggle="dropdown">
                    <i class="fas fa-file-export"></i> Export / Import
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('export.interns') }}">
                        <i class="fas fa-file-excel text-success"></i> Export Excel
                    </a>
                    <a class="dropdown-item" href="{{ route('export.interns', ['status' => 'active']) }}">
                        <i class="fas fa-check-circle text-success"></i> Export Aktif
                    </a>
                    <a class="dropdown-item" href="{{ route('export.interns', ['status' => 'completed']) }}">
                        <i class="fas fa-graduation-cap text-primary"></i> Export Selesai
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('import.interns.form') }}">
                        <i class="fas fa-upload text-info"></i> Import Data
                    </a>
                    <a class="dropdown-item" href="{{ route('import.template') }}">
                        <i class="fas fa-download text-warning"></i> Download Template
                    </a>
                </div>
            </div>
            <a href="{{ route('interns.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Anggota
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group">
            <label>Cari</label>
            <div class="search-input">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="Nama, email, sekolah...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="filter-group" style="max-width: 200px;">
            <label>Status</label>
            <select wire:model.live="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- Bulk Actions Bar -->
    @if(count($selectedInterns) > 0)
        <div class="bulk-action-bar card"
            style="margin-bottom: 16px; padding: 16px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; background: linear-gradient(135deg, var(--accent-primary) 0%, var(--accent-secondary) 100%); border: none;">
            <div style="color: white; font-weight: 600;">
                <i class="fas fa-check-square"></i> {{ count($selectedInterns) }} item dipilih
            </div>
            <div class="d-flex gap-2" style="flex: 1;">
                <select wire:model="bulkAction" class="form-control"
                    style="max-width: 200px; background: rgba(255,255,255,0.95);">
                    <option value="">-- Pilih Aksi --</option>
                    <option value="delete">🗑️ Hapus</option>
                    <option value="activate">✅ Set Aktif</option>
                    <option value="complete">🎓 Set Selesai</option>
                    <option value="cancel">❌ Set Dibatalkan</option>
                </select>
                <button wire:click="executeBulkAction"
                    wire:confirm="Yakin ingin melakukan aksi ini pada {{ count($selectedInterns) }} data?" class="btn"
                    style="background: white; color: var(--accent-primary); font-weight: 600;">
                    <i class="fas fa-play"></i> Jalankan
                </button>
            </div>
            <button wire:click="resetBulkSelection" class="btn" style="background: rgba(255,255,255,0.2); color: white;">
                <i class="fas fa-times"></i> Batal
            </button>
        </div>
    @endif

    <!-- Table -->
    <div class="card">
        @if($interns->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="empty-state-title">Belum Ada Anggota Magang</h4>
                <p class="empty-state-text">Mulai dengan menambahkan anggota magang baru.</p>
                <a href="{{ route('interns.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anggota
                </a>
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 50px;">
                                <input type="checkbox" wire:model.live="selectAll" class="form-checkbox"
                                    style="width: 18px; height: 18px; cursor: pointer;">
                            </th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Jurusan</th>
                            <th>Pembimbing</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interns as $intern)
                            <tr wire:key="intern-{{ $intern->id }}"
                                class="{{ in_array((string) $intern->id, $selectedInterns) ? 'selected-row' : '' }}">
                                <td>
                                    <input type="checkbox" wire:model.live="selectedInterns" value="{{ $intern->id }}"
                                        class="form-checkbox" style="width: 18px; height: 18px; cursor: pointer;">
                                </td>
                                <td>
                                    <div class="d-flex align-center gap-2">
                                        @if($intern->user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $intern->user->avatar) }}"
                                                alt="{{ $intern->user->name }}"
                                                style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid var(--success);">
                                        @else
                                            <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px;">
                                                {{ strtoupper(substr($intern->user->name ?? 'N', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $intern->user->name ?? 'N/A' }}</strong>
                                            <div class="text-muted" style="font-size: 12px;">{{ $intern->user->email ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $intern->school }}</td>
                                <td>{{ $intern->department }}</td>
                                <td>{{ $intern->supervisor->name ?? '-' }}</td>
                                <td>
                                    <div style="font-size: 13px;">
                                        {{ $intern->start_date->format('d M Y') }}
                                        <br>
                                        <span class="text-muted">s/d {{ $intern->end_date->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($intern->status === 'active')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($intern->status === 'completed')
                                        <span class="badge badge-primary">Selesai</span>
                                    @else
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('interns.show', $intern) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('interns.edit', $intern) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('interns.downloadReport', $intern) }}" class="btn btn-sm btn-success"
                                            title="Download Laporan PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @if($intern->status === 'completed')
                                            <a href="{{ route('interns.certificate', $intern) }}" class="btn btn-sm btn-primary"
                                                title="Download Sertifikat" target="_blank">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                        @endif
                                        <button wire:click="deleteIntern({{ $intern->id }})"
                                            wire:confirm="Yakin ingin menghapus anggota ini?" class="btn btn-sm btn-danger"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $interns->links('vendor.livewire.simple-pagination') }}
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
