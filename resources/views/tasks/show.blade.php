@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="slide-up">
        <div class="d-flex align-center gap-4 mb-6">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div style="flex: 1;">
                <div class="d-flex align-center gap-4" style="flex-wrap: wrap;">
                    <h2 style="margin-bottom: 4px;">{{ $task->title }}</h2>
                    <span class="badge badge-{{ $task->priority_color }}">{{ ucfirst($task->priority) }}</span>
                    <span class="badge badge-{{ $task->status_color }}">{{ $task->status_label }}</span>
                    @if($task->is_late && $task->status === 'completed')
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Terlambat</span>
                    @endif
                </div>
                <p class="text-muted">Diberikan oleh {{ $task->assignedBy->name }}</p>
            </div>
            @if(auth()->user()->canManage())
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
            @endif
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Detail Tugas</h3>
                </div>

                <div style="display: grid; gap: 20px;">
                    <div>
                        <label class="text-muted"
                            style="font-size: 12px; display: block; margin-bottom: 4px;">Deskripsi</label>
                        <p style="line-height: 1.7;">{{ $task->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div class="grid-2">
                        <div>
                            <label class="text-muted"
                                style="font-size: 12px; display: block; margin-bottom: 4px;">Siswa</label>
                            <div class="d-flex align-center gap-2">
                                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 12px;">
                                    {{ strtoupper(substr($task->intern->user->name ?? 'N', 0, 1)) }}
                                </div>
                                <strong>{{ $task->intern->user->name ?? 'N/A' }}</strong>
                            </div>
                        </div>
                        <div>
                            <label class="text-muted"
                                style="font-size: 12px; display: block; margin-bottom: 4px;">Deadline</label>
                            @if($task->deadline)
                                <strong>{{ $task->deadline->format('d M Y') }}</strong>
                                @if($task->deadline_time)
                                    <span class="text-muted">pukul {{ $task->deadline_time }}</span>
                                @endif
                                @if($task->isOverdue())
                                    <span class="badge badge-danger" style="margin-left: 8px;">Lewat!</span>
                                @endif
                            @else
                                <span class="text-muted">Tidak ada deadline</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid-2">
                        <div>
                            <label class="text-muted" style="font-size: 12px; display: block; margin-bottom: 4px;">Estimasi
                                Waktu</label>
                            <strong>{{ $task->estimated_hours ?? '-' }} Jam</strong>
                        </div>
                        <div>
                            <label class="text-muted" style="font-size: 12px; display: block; margin-bottom: 4px;">Metode
                                Pengumpulan</label>
                            <strong>
                                @if($task->submission_type === 'github')
                                    <i class="fab fa-github"></i> Link GitHub
                                @elseif($task->submission_type === 'file')
                                    <i class="fas fa-folder"></i> Upload File
                                @else
                                    <i class="fas fa-layer-group"></i> GitHub / File
                                @endif
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-clock"></i> Timeline</h3>
                </div>

                <div style="position: relative; padding-left: 30px;">
                    <div
                        style="position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: var(--border-color);">
                    </div>

                    <div style="margin-bottom: 24px; position: relative;">
                        <div
                            style="position: absolute; left: -26px; width: 14px; height: 14px; background: #6366f1; border-radius: 50%;">
                        </div>
                        <div class="text-muted" style="font-size: 12px;">Dibuat</div>
                        <strong>{{ $task->created_at->format('d M Y H:i') }}</strong>
                    </div>

                    @if($task->started_at)
                        <div style="margin-bottom: 24px; position: relative;">
                            <div
                                style="position: absolute; left: -26px; width: 14px; height: 14px; background: #06b6d4; border-radius: 50%;">
                            </div>
                            <div class="text-muted" style="font-size: 12px;">Mulai Dikerjakan</div>
                            <strong>{{ $task->started_at->format('d M Y H:i') }}</strong>
                        </div>
                    @endif

                    @if($task->submitted_at)
                        <div style="margin-bottom: 24px; position: relative;">
                            <div
                                style="position: absolute; left: -26px; width: 14px; height: 14px; background: {{ $task->is_late ? '#f59e0b' : '#22c55e' }}; border-radius: 50%;">
                            </div>
                            <div class="text-muted" style="font-size: 12px;">Dikumpulkan</div>
                            <strong>{{ $task->submitted_at->format('d M Y H:i') }}</strong>
                            @if($task->is_late)
                                <span class="badge badge-warning" style="margin-left: 8px; font-size: 10px;">Terlambat</span>
                            @else
                                <span class="badge badge-success" style="margin-left: 8px; font-size: 10px;">Tepat Waktu</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Revision Alert -->
        @if($task->status === 'revision')
            <div class="mt-6" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: #fff; border: 1px solid #fed7aa;">
                <!-- Header Status -->
                <div style="background: linear-gradient(to right, #fff7ed, #fff); padding: 24px; border-bottom: 1px dashed #fed7aa; display: flex; align-items: flex-start; gap: 20px;">
                    <div style="background: #fffbeb; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #fde68a;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #d97706;"></i>
                    </div>
                    <div>
                        <h3 style="color: #9a3412; font-weight: 700; margin-bottom: 6px; font-size: 18px;">Kompetensi Belum Terpenuhi</h3>
                        <p style="color: #c2410c; margin: 0; font-size: 14px; line-height: 1.5;">
                            Tugas Anda memerlukan revisi. Silakan perbaiki bagian-bagian yang disebutkan oleh pembimbing di bawah ini sebelum mengumpulkannya kembali.
                        </p>
                    </div>
                </div>

                <!-- Evaluator Feedback Area -->
                <div style="padding: 24px; background: #fff;">
                    <div style="margin-bottom: 8px; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px;">
                        <i class="fas fa-comment-dots me-1"></i> Catatan Pembimbing
                    </div>
                    
                    <div style="background: #f8fafc; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 20px; color: #334155; font-size: 15px; line-height: 1.6;">
                        "{{ $task->admin_feedback ?? 'Mohon perbaiki tugas sesuai dengan instruksi awal.' }}"
                    </div>

                    @if(auth()->user()->isIntern())
                        <div style="margin-top: 24px; display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 8px;">
                            <i class="fas fa-info-circle text-danger"></i>
                            <span style="color: #be123c; font-size: 14px; font-weight: 500;">
                                Silakan perbaiki sesuai catatan di atas, lalu upload ulang file/link revisi Anda pada form di bawah.
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Submission Section for Interns (Show also if Revision) -->
        @if(auth()->user()->isIntern() && ($task->status !== 'completed' && $task->status !== 'submitted'))
            <div class="card mt-6">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-paper-plane"></i>
                        {{ $task->status === 'revision' ? 'Kumpulkan Revisi' : 'Kumpulkan Tugas' }}</h3>
                </div>

                @if($task->isOverdue())
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian!</strong> Deadline sudah lewat. Pengumpulan akan dihitung terlambat.
                    </div>
                @endif

                <form action="{{ route('tasks.submit', $task) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if(in_array($task->submission_type, ['github', 'both']))
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fab fa-github"></i> Link GitHub Repository
                                @if($task->submission_type === 'github') * @endif
                            </label>
                            <input type="url" name="github_link" class="form-control"
                                value="{{ old('github_link', $task->github_link) }}"
                                placeholder="https://github.com/username/repository" {{ $task->submission_type === 'github' ? 'required' : '' }}>
                            <small class="text-muted">Contoh: https://github.com/nama-anda/nama-repo</small>
                        </div>
                    @endif

                    @if(in_array($task->submission_type, ['file', 'both']))
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-upload"></i> Upload File
                                @if($task->submission_type === 'file') * @endif
                            </label>
                            <input type="file" name="submission_file" class="form-control" {{ $task->submission_type === 'file' ? 'required' : '' }}>
                            <small class="text-muted">Format: ZIP, RAR, PDF, DOC, atau file lainnya. Maksimal 50MB.</small>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-comment"></i> Catatan Pengumpulan</label>
                        <textarea name="submission_notes" class="form-control" rows="3"
                            placeholder="Tambahkan catatan atau keterangan...">{{ old('submission_notes', $task->submission_notes) }}</textarea>
                    </div>

                    <div class="d-flex gap-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            {{ $task->status === 'revision' ? 'Kirim Revisi' : 'Kumpulkan Tugas' }}
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Submitted Task Info (Show for Completed or Submitted or Revision) -->
        @if(in_array($task->status, ['completed', 'submitted', 'revision']))
            <div class="card mt-6"
                style="background: {{ $task->is_late ? 'rgba(245, 158, 11, 0.05)' : 'rgba(34, 197, 94, 0.05)' }};">
                <div class="d-flex align-center gap-4 mb-4">
                    <div style="font-size: 48px;">
                        @if($task->status === 'completed')
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        @elseif($task->status === 'revision')
                            <i class="fas fa-exclamation-circle" style="color: var(--warning);"></i>
                        @else
                            <i class="fas fa-clock" style="color: var(--info);"></i>
                        @endif
                    </div>
                    <div>
                        <h3 style="margin-bottom: 4px;">
                            @if($task->status === 'completed')
                                Tugas Selesai & Dinilai
                            @elseif($task->status === 'revision')
                                Perlu Revisi
                            @else
                                Menunggu Review
                            @endif
                        </h3>
                        <p class="text-muted">
                            Dikumpulkan: {{ $task->submitted_at?->format('d M Y H:i') ?? '-' }}
                            @if($task->is_late)
                                <span class="badge badge-warning ms-2">Terlambat</span>
                            @else
                                <span class="badge badge-success ms-2">Tepat Waktu</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Submission Details -->
                @if($task->github_link || $task->submission_file || $task->submission_notes)
                    <div style="border-top: 1px solid var(--border-color); padding-top: 20px; margin-top: 16px;">
                        <h4 style="margin-bottom: 16px;"><i class="fas fa-file-alt"></i> Detail Pengumpulan</h4>

                        <div class="grid-2">
                            @if($task->github_link)
                                <div class="mb-4">
                                    <label class="text-muted" style="font-size: 12px; display: block; margin-bottom: 4px;">Link
                                        GitHub</label>
                                    <a href="{{ $task->github_link }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fab fa-github"></i> Buka Repository
                                    </a>
                                </div>
                            @endif

                            @if($task->submission_file)
                                <div class="mb-4">
                                    <label class="text-muted" style="font-size: 12px; display: block; margin-bottom: 4px;">File
                                        Upload</label>
                                    <a href="{{ Storage::url('submissions/' . $task->submission_file) }}" target="_blank"
                                        class="btn btn-sm btn-secondary">
                                        <i class="fas fa-download"></i> Download File
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($task->submission_notes)
                            <div>
                                <label class="text-muted" style="font-size: 12px; display: block; margin-bottom: 4px;">Catatan
                                    Siswa</label>
                                <div class="p-3 rounded"
                                    style="background-color: #f1f5f9; border-left: 4px solid #cbd5e1; color: #334155;">
                                    "{{ $task->submission_notes }}"
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <!-- Admin Review Form -->
        @if(auth()->user()->canManage() && $task->status === 'submitted')
            <div class="card mt-6 border-primary">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title text-white"><i class="fas fa-gavel"></i> Review Tugas</h3>
                </div>
                <form action="{{ route('tasks.review', $task) }}" method="POST" class="p-4">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label">Keputusan</label>
                        <div class="d-flex gap-4">
                            <label class="radio-card p-3 border rounded d-flex align-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="approve" checked onchange="toggleScoreInput(true)">
                                <i class="fas fa-check-circle text-success font-xl"></i>
                                <div>
                                    <strong>Terima & Nilai</strong>
                                    <div class="text-muted text-sm">Tugas sudah sesuai</div>
                                </div>
                            </label>

                            <label class="radio-card p-3 border rounded d-flex align-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="revision" onchange="toggleScoreInput(false)">
                                <i class="fas fa-redo text-warning font-xl"></i>
                                <div>
                                    <strong>Minta Revisi</strong>
                                    <div class="text-muted text-sm">Kembalikan ke siswa</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="scoreInputGroup" class="form-group mb-4">
                        <label class="form-label">Nilai (0-100)</label>
                        <input type="number" name="score" class="form-control" min="0" max="100" placeholder="Contoh: 85"
                            style="max-width: 150px;">
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label">Feedback / Catatan</label>
                        <textarea name="feedback" class="form-control" rows="3"
                            placeholder="Berikan masukan untuk siswa..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="fas fa-save"></i> Simpan Review
                    </button>
                </form>
            </div>

            <script>
                function toggleScoreInput(show) {
                    const group = document.getElementById('scoreInputGroup');
                    if (show) {
                        group.style.display = 'block';
                        group.querySelector('input').setAttribute('required', 'required');
                    } else {
                        group.style.display = 'none';
                        group.querySelector('input').removeAttribute('required');
                        group.querySelector('input').value = '';
                    }
                }
            </script>
        @endif

        <!-- Grading Result (If completed) -->
        @if($task->status === 'completed' && $task->score !== null)
            <div class="card mt-6 p-0 overflow-hidden border-0 shadow-lg" style="border-radius: 20px; background: white; width: 100%;">
                <div class="p-6" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); display: flex; flex-direction: column; align-items: center; text-align: center;">
                    <h4 class="text-success mb-2" style="font-weight: 700; letter-spacing: 1px; text-transform: uppercase; font-size: 14px; width: 100%;">
                         🚀 Hasil Penilaian
                    </h4>

                    <div class="my-5 d-flex justify-content-center" style="width: 100%; display: flex !important; justify-content: center !important;">
                        <div style="position: relative; width: 160px; height: 160px; margin: 0 auto;">
                            <svg viewBox="0 0 36 36" style="width: 100%; height: 100%; transform: rotate(-90deg);">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#e2e8f0" stroke-width="2.5" />
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="var(--success)" stroke-width="2.5"
                                    stroke-dasharray="{{ $task->score }}, 100" stroke-linecap="round"
                                    style="filter: drop-shadow(0 0 5px rgba(34, 197, 94, 0.4));" />
                            </svg>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; width: 100%;">
                                <div style="font-size: 42px; font-weight: 900; color: #166534; line-height: 1;">
                                    {{ $task->score }}
                                </div>
                                <div style="font-size: 11px; font-weight: 600; color: #166534; text-transform: uppercase; margin-top: 4px;">Poin</div>
                            </div>
                        </div>
                    </div>

                    <h3 style="color: #166534; font-weight: 800; margin-bottom: 8px; width: 100%;">
                        @if($task->score >= 90)
                            🎉 Luar Biasa!
                        @elseif($task->score >= 75)
                            ✨ Kerja Bagus!
                        @else
                            👍 Semangat Terus!
                        @endif
                    </h3>
                    <p class="text-success" style="font-size: 14px; opacity: 0.8; width: 100%;">Tugas ini telah berhasil diselesaikan dengan hasil yang membanggakan.</p>
                </div>

                @if($task->admin_feedback)
                    <div class="p-6 bg-white" style="display: flex; flex-direction: column; align-items: center;">
                        <div style="width: 100%; max-width: 600px; text-align: center;">
                            <div class="d-flex align-center gap-2 mb-3 justify-content-center" style="display: flex; justify-content: center; align-items: center;">
                                <i class="fas fa-quote-left text-success" style="font-size: 12px; opacity: 0.5;"></i>
                                <span style="font-size: 12px; font-weight: 700; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase;">
                                    Feedback Pembimbing
                                </span>
                                <i class="fas fa-quote-right text-success" style="font-size: 12px; opacity: 0.5;"></i>
                            </div>
                            <div class="p-4" style="background: #f8fafc; border: 1px solid #e2e8f0; color: #334155; font-size: 15px; line-height: 1.6; text-align: center; border-radius: 12px; margin: 0 auto;">
                                "{{ $task->admin_feedback }}"
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-4 text-center border-top" style="background: #fafafa; font-size: 11px; color: #94a3b8; font-weight: 500; width: 100%;">
                    <i class="fas fa-calendar-check me-1"></i> Dinilai pada {{ $task->approved_at?->format('d M Y H:i') }}
                </div>
            </div>
        @endif
    </div>
@endsection
