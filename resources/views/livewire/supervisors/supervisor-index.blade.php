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
            <!-- Desktop Table View -->
            <div class="hidden sm:block table-container">
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
                            <tr wire:key="supervisor-d-{{ $supervisor->id }}">
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

            <!-- Mobile Card View -->
            <div class="block sm:hidden p-4 space-y-4 bg-slate-50/50">
                @foreach($supervisors as $supervisor)
                    <div wire:key="supervisor-m-{{ $supervisor->id }}"
                        class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-12 h-12 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center text-lg font-bold">
                                        {{ strtoupper(substr($supervisor->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $supervisor->name }}</h4>
                                        <p class="text-xs text-slate-400">{{ $supervisor->email }}</p>
                                    </div>
                                </div>
                                <span
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold {{ $supervisor->supervised_interns_count > 0 ? 'bg-indigo-50 text-indigo-600' : 'bg-slate-50 text-slate-500' }}">
                                    <i class="fas fa-users"></i> {{ $supervisor->supervised_interns_count }}
                                </span>
                            </div>

                            <div class="text-xs text-slate-400 mb-4 flex items-center gap-2">
                                <i class="far fa-calendar-alt"></i> Terdaftar sejak
                                {{ $supervisor->created_at->format('d M Y') }}
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-4 border-t border-slate-100">
                                <a href="{{ route('supervisors.edit', $supervisor) }}"
                                    class="btn bg-amber-50 text-amber-600 hover:bg-amber-100 border-0 justify-center">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>

                                @if($supervisor->supervised_interns_count == 0)
                                    <button wire:click="deleteSupervisor({{ $supervisor->id }})" wire:confirm="Yakin ingin menghapus?"
                                        class="btn bg-rose-50 text-rose-600 hover:bg-rose-100 border-0 justify-center">
                                        <i class="fas fa-trash mr-2"></i> Hapus
                                    </button>
                                @else
                                    <button class="btn bg-slate-100 text-slate-400 border-0 justify-center cursor-not-allowed opacity-70"
                                        disabled>
                                        <i class="fas fa-lock mr-2"></i> Terkunci
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination">
                {{ $supervisors->links('vendor.livewire.simple-tailwind') }}
            </div>
        @endif
    </div>
</div>
