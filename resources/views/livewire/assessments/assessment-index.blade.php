<div class="slide-up space-y-5">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 mb-1">Penilaian Pekerjaan</h2>
            <p class="text-slate-400 text-sm">Evaluasi performa siswa magang</p>
        </div>
        <a href="{{ route('assessments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penilaian
        </a>
    </div>

    <!-- Filter -->
    <div class="filter-bar">
        <div class="filter-group max-w-[220px]">
            <label>Siswa</label>
            <select wire:model.live="intern_id" class="form-control">
                <option value="">Semua Siswa</option>
                @foreach($interns as $intern)
                    <option value="{{ $intern->id }}">{{ $intern->user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        @if($assessments->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h4 class="empty-state-title">Belum Ada Penilaian</h4>
                <p class="empty-state-text">Mulai dengan memberikan penilaian untuk siswa.</p>
                <a href="{{ route('assessments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Penilaian
                </a>
            </div>
        @else
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th class="hidden md:table-cell">Tugas</th>
                            <th class="hidden lg:table-cell">Kualitas</th>
                            <th class="hidden lg:table-cell">Kecepatan</th>
                            <th class="hidden lg:table-cell">Inisiatif</th>
                            <th>Rata-rata</th>
                            <th>Grade</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assessments as $assessment)
                            <tr wire:key="assessment-{{ $assessment->id }}">
                                <td>
                                    @if($assessment->intern)
                                        <div class="flex items-center gap-2">
                                            <div class="user-avatar w-8 h-8 text-xs">
                                                {{ strtoupper(substr($assessment->intern->user->name ?? 'N', 0, 1)) }}
                                            </div>
                                            <span
                                                class="text-sm text-slate-700">{{ $assessment->intern->user->name ?? 'N/A' }}</span>
                                        </div>
                                    @else
                                        <span class="badge badge-secondary text-[10px]">Dihapus</span>
                                    @endif
                                </td>
                                <td class="hidden md:table-cell text-sm text-slate-600">
                                    {{ Str::limit($assessment->task->title ?? 'Penilaian Umum', 25) }}</td>
                                <td class="hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="progress w-14">
                                            <div class="progress-bar" style="width: {{ $assessment->quality_score }}%;"></div>
                                        </div>
                                        <span class="text-xs text-slate-600">{{ $assessment->quality_score }}</span>
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="progress w-14">
                                            <div class="progress-bar bg-emerald-500"
                                                style="width: {{ $assessment->speed_score }}%;"></div>
                                        </div>
                                        <span class="text-xs text-slate-600">{{ $assessment->speed_score }}</span>
                                    </div>
                                </td>
                                <td class="hidden lg:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="progress w-14">
                                            <div class="progress-bar bg-amber-500"
                                                style="width: {{ $assessment->initiative_score }}%;"></div>
                                        </div>
                                        <span class="text-xs text-slate-600">{{ $assessment->initiative_score }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-lg font-bold text-slate-700">{{ $assessment->average_score }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $assessment->grade_color }} text-sm px-3 py-1.5">
                                        {{ $assessment->grade }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex gap-1.5">
                                        <a href="{{ route('assessments.show', $assessment) }}" class="btn btn-sm btn-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('assessments.edit', $assessment) }}" class="btn btn-sm btn-warning"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteAssessment({{ $assessment->id }})" wire:confirm="Yakin?"
                                            class="btn btn-sm btn-danger" title="Hapus">
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
                {{ $assessments->links('vendor.livewire.simple-tailwind') }}
            </div>
        @endif
    </div>
</div>
