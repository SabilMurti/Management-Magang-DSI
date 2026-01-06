<div class="slide-up">
    <!-- Header Actions -->
    <div class="d-flex justify-between align-center mb-6" style="flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="margin-bottom: 4px;">Daftar Pembimbing</h2>
            <p class="text-muted">Kelola data pembimbing magang</p>
        </div>
        <a href="{{ route('supervisors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pembimbing
        </a>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group">
            <label>Cari</label>
            <div class="search-input">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="Nama atau email...">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        @if($supervisors->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h4 class="empty-state-title">Belum Ada Pembimbing</h4>
                <p class="empty-state-text">Mulai dengan menambahkan pembimbing baru.</p>
                <a href="{{ route('supervisors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Pembimbing
                </a>
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Jumlah Siswa</th>
                            <th>Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supervisors as $supervisor)
                            <tr wire:key="supervisor-{{ $supervisor->id }}">
                                <td>
                                    <div class="d-flex align-center gap-2">
                                        <div class="user-avatar" style="width: 40px; height: 40px; font-size: 15px; background: linear-gradient(135deg, #8b5cf6, #6366f1);">
                                            {{ strtoupper(substr($supervisor->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $supervisor->name }}</strong>
                                            <div class="text-muted" style="font-size: 12px;">
                                                <i class="fas fa-user-tie" style="margin-right: 4px;"></i>Pembimbing
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="color: var(--text-secondary);">{{ $supervisor->email }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $supervisor->supervised_interns_count > 0 ? 'badge-info' : 'badge-secondary' }}">
                                        <i class="fas fa-users" style="margin-right: 4px;"></i>
                                        {{ $supervisor->supervised_interns_count }} Siswa
                                    </span>
                                </td>
                                <td>
                                    <span style="color: var(--text-muted); font-size: 13px;">
                                        {{ $supervisor->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('supervisors.edit', $supervisor) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($supervisor->supervised_interns_count == 0)
                                            <button wire:click="deleteSupervisor({{ $supervisor->id }})"
                                                wire:confirm="Yakin ingin menghapus pembimbing ini?" 
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled
                                                title="Tidak dapat dihapus karena memiliki siswa">
                                                <i class="fas fa-lock"></i>
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
                {{ $supervisors->links() }}
            </div>
        @endif
    </div>
</div>
