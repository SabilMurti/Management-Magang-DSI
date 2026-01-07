<div class="slide-up space-y-5">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 mb-1">Daftar Pembimbing</h2>
            <p class="text-slate-400 text-sm">Kelola data pembimbing magang</p>
        </div>
        <a href="{{ route('supervisors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pembimbing
        </a>
    </div>

    <!-- Filter -->
    <div class="filter-bar">
        <div class="filter-group flex-[2]">
            <label>Cari</label>
            <div class="search-input">
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                    placeholder="Nama atau email...">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
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
                            <th class="hidden sm:table-cell">Email</th>
                            <th>Siswa</th>
                            <th class="hidden md:table-cell">Terdaftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supervisors as $supervisor)
                            <tr wire:key="supervisor-{{ $supervisor->id }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="user-avatar w-10 h-10">
                                            {{ strtoupper(substr($supervisor->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-slate-700 text-sm">{{ $supervisor->name }}</div>
                                            <div class="text-slate-400 text-[11px] flex items-center gap-1">
                                                <i class="fas fa-user-tie"></i> Pembimbing
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell text-sm text-slate-500">{{ $supervisor->email }}</td>
                                <td>
                                    <span
                                        class="badge {{ $supervisor->supervised_interns_count > 0 ? 'badge-info' : 'badge-secondary' }}">
                                        <i class="fas fa-users mr-1"></i> {{ $supervisor->supervised_interns_count }}
                                    </span>
                                </td>
                                <td class="hidden md:table-cell text-sm text-slate-400">
                                    {{ $supervisor->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('supervisors.edit', $supervisor) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($supervisor->supervised_interns_count == 0)
                                            <button wire:click="deleteSupervisor({{ $supervisor->id }})"
                                                wire:confirm="Yakin ingin menghapus?" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-secondary opacity-50 cursor-not-allowed" disabled
                                                title="Memiliki siswa">
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
                {{ $supervisors->links('vendor.livewire.simple-tailwind') }}
            </div>
        @endif
    </div>
</div>
