<div class="slide-up space-y-5">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 mb-1">Daftar Anggota Magang</h2>
            <p class="text-slate-400 text-sm">Kelola data siswa magang</p>
        </div>
        <div class="flex gap-2">
            <div class="dropdown">
                <button class="btn btn-secondary" data-toggle="dropdown">
                    <i class="fas fa-file-export"></i>
                    <span class="hidden sm:inline">Export / Import</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('export.interns') }}">
                        <i class="fas fa-file-excel text-emerald-500"></i> Export Excel
                    </a>
                    <a class="dropdown-item" href="{{ route('export.interns', ['status' => 'active']) }}">
                        <i class="fas fa-check-circle text-emerald-500"></i> Export Aktif
                    </a>
                    <a class="dropdown-item" href="{{ route('export.interns', ['status' => 'completed']) }}">
                        <i class="fas fa-graduation-cap text-violet-500"></i> Export Selesai
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('import.interns.form') }}">
                        <i class="fas fa-upload text-sky-500"></i> Import Data
                    </a>
                    <a class="dropdown-item" href="{{ route('import.template') }}">
                        <i class="fas fa-download text-amber-500"></i> Download Template
                    </a>
                </div>
            </div>
            <a href="{{ route('interns.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span class="hidden sm:inline">Tambah Anggota</span>
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-bar">
        <div class="filter-group flex-[2]">
            <label>Cari</label>
            <div class="search-input">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Nama, email, sekolah...">
                <i class="fas fa-search"></i>
            </div>
        </div>
        <div class="filter-group max-w-[160px]">
            <label>Status</label>
            <select wire:model.live="status" class="form-control">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="completed">Selesai</option>
                <option value="cancelled">Dibatalkan</option>
            </select>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if(count($selectedInterns) > 0)
        <div class="bulk-action-bar p-4 flex flex-wrap items-center gap-3" style="background: linear-gradient(135deg, #a78bfa 0%, #c084fc 100%);">
            <div class="text-white font-semibold text-sm">
                <i class="fas fa-check-square"></i> {{ count($selectedInterns) }} dipilih
            </div>
            <div class="flex gap-2 flex-1">
                <select wire:model="bulkAction" class="form-control max-w-[180px]" style="background: white;">
                    <option value="">-- Pilih Aksi --</option>
                    <option value="delete">🗑️ Hapus</option>
                    <option value="activate">✅ Set Aktif</option>
                    <option value="complete">🎓 Set Selesai</option>
                    <option value="cancel">❌ Set Dibatalkan</option>
                </select>
                <button wire:click="executeBulkAction" wire:confirm="Yakin ingin melakukan aksi ini?" class="btn bg-white text-violet-600 hover:bg-violet-50">
                    <i class="fas fa-play"></i> Jalankan
                </button>
            </div>
            <button wire:click="resetBulkSelection" class="btn bg-white/20 text-white hover:bg-white/30">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
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
                            <th class="w-12">
                                <input type="checkbox" wire:model.live="selectAll" class="form-checkbox">
                            </th>
                            <th>Nama</th>
                            <th class="hidden lg:table-cell">Sekolah</th>
                            <th class="hidden lg:table-cell">Jurusan</th>
                            <th class="hidden md:table-cell">Pembimbing</th>
                            <th class="hidden md:table-cell">Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interns as $intern)
                            <tr wire:key="intern-{{ $intern->id }}" class="{{ in_array((string) $intern->id, $selectedInterns) ? 'selected-row' : '' }}">
                                <td>
                                    <input type="checkbox" wire:model.live="selectedInterns" value="{{ $intern->id }}" class="form-checkbox">
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        @if($intern->user->avatar)
                                            <img src="{{ asset('storage/avatars/' . $intern->user->avatar) }}" alt="{{ $intern->user->name }}" class="w-9 h-9 rounded-full object-cover ring-2 ring-emerald-400/50">
                                        @else
                                            <div class="user-avatar w-9 h-9 text-xs">
                                                {{ strtoupper(substr($intern->user->name ?? 'N', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-semibold text-slate-700 text-sm">{{ $intern->user->name ?? 'N/A' }}</div>
                                            <div class="text-slate-400 text-[11px]">{{ $intern->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell text-sm text-slate-600">{{ $intern->school }}</td>
                                <td class="hidden lg:table-cell text-sm text-slate-600">{{ $intern->department }}</td>
                                <td class="hidden md:table-cell text-sm text-slate-600">{{ $intern->supervisor->name ?? '-' }}</td>
                                <td class="hidden md:table-cell">
                                    <div class="text-xs text-slate-600">
                                        {{ $intern->start_date->format('d M Y') }}
                                        <div class="text-slate-400">s/d {{ $intern->end_date->format('d M Y') }}</div>
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
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('interns.show', $intern) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('interns.edit', $intern) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('interns.downloadReport', $intern) }}" class="btn btn-sm btn-success hidden sm:inline-flex" title="PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                        @if($intern->status === 'completed')
                                            <a href="{{ route('interns.certificate', $intern) }}" class="btn btn-sm btn-primary hidden sm:inline-flex" title="Sertifikat" target="_blank">
                                                <i class="fas fa-certificate"></i>
                                            </a>
                                        @endif
                                        <button wire:click="deleteIntern({{ $intern->id }})" wire:confirm="Yakin ingin menghapus?" class="btn btn-sm btn-danger" title="Hapus">
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
                {{ $interns->links('vendor.livewire.simple-tailwind') }}
            </div>
        @endif
    </div>
</div>
