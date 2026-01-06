@extends('layouts.app')

@section('title', 'Detail Tugas')

@section('content')
    <div class="slide-up">
        <!-- Header Navigation & Title -->
        <div class="d-flex align-center gap-4 mb-6">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-icon" style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: all 0.2s;">
                <i class="fas fa-arrow-left" style="color: #64748b;"></i>
            </a>
            <div style="flex: 1;">
                <div class="d-flex align-center gap-3" style="flex-wrap: wrap;">
                    <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: #1e293b; letter-spacing: -0.5px;">{{ $task->title }}</h2>
                    <div style="display: flex; gap: 8px;">
                         <span class="badge badge-{{ $task->priority_color }}" style="border-radius: 8px; padding: 6px 12px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; font-size: 11px;">
                            {{ ucfirst($task->priority) }}
                        </span>
                        <span class="badge badge-{{ $task->status_color }}" style="border-radius: 8px; padding: 6px 12px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; font-size: 11px;">
                            {{ $task->status_label }}
                        </span>
                        @if($task->is_late && $task->status === 'completed')
                            <span class="badge badge-warning" style="border-radius: 8px; padding: 6px 12px; font-weight: 600; font-size: 11px;">
                                <i class="fas fa-clock me-1"></i> Terlambat
                            </span>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-center gap-2 mt-2">
                    <div style="width: 24px; height: 24px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #64748b; font-weight: 700;">
                        {{ strtoupper(substr($task->assignedBy->name, 0, 1)) }}
                    </div>
                    <p class="text-muted" style="margin: 0; font-size: 13px;">Diberikan oleh <span style="font-weight: 600; color: #475569;">{{ $task->assignedBy->name }}</span></p>
                </div>
            </div>
            @if(auth()->user()->canManage())
                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning" style="border-radius: 12px; padding: 10px 20px; font-weight: 600; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);">
                    <i class="fas fa-edit me-2"></i> Edit
                </a>
            @endif
        </div>

        <div class="grid-2" style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <!-- Main Info Card -->
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                    <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                         <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #334155;">Informasi Tugas</h3>
                </div>

                <div style="display: grid; gap: 24px;">
                    <div>
                        <label class="text-muted" style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 8px; color: #94a3b8;">Deskripsi</label>
                        <div style="line-height: 1.8; color: #475569; font-size: 15px;">
                            {{ $task->description ?? 'Tidak ada deskripsi.' }}
                        </div>
                    </div>

                    <div class="grid-2" style="gap: 24px;">
                        <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Siswa</label>
                            <div class="d-flex align-center gap-3">
                                <div class="user-avatar" style="width: 36px; height: 36px; font-size: 14px; background: white; border: 2px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                    {{ strtoupper(substr($task->intern->user->name ?? 'N', 0, 1)) }}
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <strong style="color: #334155; font-size: 14px;">{{ $task->intern->user->name ?? 'N/A' }}</strong>
                                    <span style="font-size: 11px; color: #94a3b8;">{{ $task->intern->position ?? 'Intern' }}</span>
                                </div>
                            </div>
                        </div>
                         
                         <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Tenggat Waktu</label>
                            @if($task->deadline)
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 36px; height: 36px; background: #fff1f2; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #f43f5e;">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div>
                                        <strong style="color: #334155; display: block; font-size: 14px;">{{ $task->deadline->format('d M Y') }}</strong>
                                        @if($task->deadline_time)
                                            <span style="font-size: 12px; color: #ef4444; font-weight: 500;">{{ $task->deadline_time }} WIB</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Tidak ada deadline</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid-2" style="gap: 24px;">
                         <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Estimasi Waktu</label>
                            <div style="display: flex; align-items: center; gap: 8px; color: #334155; font-weight: 700; font-size: 15px;">
                                <i class="fas fa-hourglass-start text-primary"></i>
                                {{ $task->estimated_hours ?? '-' }} Jam
                            </div>
                        </div>
                        
                         <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0;">
                            <label class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 6px;">Metode Pengumpulan</label>
                            <div style="font-weight: 700; font-size: 14px; color: #334155;">
                                @if($task->submission_type === 'github')
                                    <div style="display: flex; align-items: center; gap: 8px;"><i class="fab fa-github"></i> Link GitHub</div>
                                @elseif($task->submission_type === 'file')
                                    <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-folder"></i> Upload File</div>
                                @else
                                    <div style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-layer-group"></i> GitHub / File</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; height: fit-content;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;">
                    <div style="width: 40px; height: 40px; background: #f0fdf4; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #22c55e;">
                         <i class="fas fa-history text-lg"></i>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #334155;">Timeline</h3>
                </div>

                <div style="position: relative; padding-left: 12px;">
                    <!-- Line -->
                    <div style="position: absolute; left: 19px; top: 10px; bottom: 30px; width: 2px; background: #e2e8f0; border-radius: 2px;"></div>

                    <!-- Item 1: Created -->
                    <div style="margin-bottom: 30px; position: relative; padding-left: 30px;">
                        <div style="position: absolute; left: 0; width: 16px; height: 16px; background: #fff; border: 3px solid #6366f1; border-radius: 50%; z-index: 2; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);"></div>
                        <div style="color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Dibuat</div>
                        <strong style="color: #334155;">{{ $task->created_at->format('d M Y') }}</strong>
                        <div style="font-size: 12px; color: #64748b;">{{ $task->created_at->format('H:i') }} WIB</div>
                    </div>

                    <!-- Item 2: Started -->
                    @if($task->started_at)
                         <div style="margin-bottom: 30px; position: relative; padding-left: 30px;">
                            <div style="position: absolute; left: 0; width: 16px; height: 16px; background: #fff; border: 3px solid #06b6d4; border-radius: 50%; z-index: 2; box-shadow: 0 0 0 4px rgba(6, 182, 212, 0.1);"></div>
                            <div style="color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Mulai Dikerjakan</div>
                            <strong style="color: #334155;">{{ $task->started_at->format('d M Y') }}</strong>
                            <div style="font-size: 12px; color: #64748b;">{{ $task->started_at->format('H:i') }} WIB</div>
                        </div>
                    @endif

                    <!-- Item 3: Submitted -->
                    @if($task->submitted_at)
                         <div style="position: relative; padding-left: 30px;">
                            <div style="position: absolute; left: 0; width: 16px; height: 16px; background: #fff; border: 3px solid {{ $task->is_late ? '#f59e0b' : '#22c55e' }}; border-radius: 50%; z-index: 2; box-shadow: 0 0 0 4px {{ $task->is_late ? 'rgba(245, 158, 11, 0.1)' : 'rgba(34, 197, 94, 0.1)' }};"></div>
                            <div style="color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Dikumpulkan</div>
                            <strong style="color: #334155;">{{ $task->submitted_at->format('d M Y') }}</strong>
                            <div style="font-size: 12px; color: #64748b;">{{ $task->submitted_at->format('H:i') }} WIB</div>
                            @if($task->is_late)
                                <div style="margin-top: 6px; display: inline-block; padding: 2px 8px; background: #fffbeb; color: #b45309; border-radius: 4px; font-size: 10px; font-weight: 700; border: 1px solid #fef3c7;">TERLAMBAT</div>
                            @else
                                <div style="margin-top: 6px; display: inline-block; padding: 2px 8px; background: #f0fdf4; color: #166534; border-radius: 4px; font-size: 10px; font-weight: 700; border: 1px solid #dcfce7;">ON TIME</div>
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
            <div class="mt-6" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.05); background: #fff; border: 1px solid {{ $task->status === 'submitted' ? '#bae6fd' : ($task->status === 'completed' ? '#bbf7d0' : '#e2e8f0') }};">
                
                <!-- Status Header -->
                @php
                    $headerBg = $task->status === 'submitted' 
                        ? 'linear-gradient(to right, #f0f9ff, #fff)' 
                        : ($task->status === 'completed' ? 'linear-gradient(to right, #f0fdf4, #fff)' : '#f8fafc');
                    
                    $iconBg = $task->status === 'submitted' ? '#e0f2fe' : ($task->status === 'completed' ? '#dcfce7' : '#f1f5f9');
                    $iconColor = $task->status === 'submitted' ? '#0369a1' : ($task->status === 'completed' ? '#15803d' : '#64748b');
                    $borderColor = $task->status === 'submitted' ? '#bae6fd' : ($task->status === 'completed' ? '#bbf7d0' : '#e2e8f0');
                    $titleColor = $task->status === 'submitted' ? '#075985' : ($task->status === 'completed' ? '#166534' : '#334155');
                @endphp

                <div style="background: {{ $headerBg }}; padding: 24px; border-bottom: 1px dashed {{ $borderColor }}; display: flex; align-items: center; gap: 20px;">
                    <div style="background: {{ $iconBg }}; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid {{ $borderColor }};">
                        @if($task->status === 'completed')
                            <i class="fas fa-check-circle" style="font-size: 24px; color: {{ $iconColor }};"></i>
                        @elseif($task->status === 'revision')
                             <i class="fas fa-history" style="font-size: 24px; color: {{ $iconColor }};"></i>
                        @else
                            <i class="fas fa-hourglass-half" style="font-size: 24px; color: {{ $iconColor }};"></i>
                        @endif
                    </div>
                    <div>
                        <h3 style="color: {{ $titleColor }}; font-weight: 700; margin-bottom: 4px; font-size: 18px;">
                            @if($task->status === 'completed')
                                Tugas Selesai
                            @elseif($task->status === 'revision')
                                Riwayat Pengumpulan
                            @else
                                Menunggu Review
                            @endif
                        </h3>
                        <div style="font-size: 14px; color: #64748b; display: flex; align-items: center; gap: 8px;">
                            <span><i class="far fa-clock me-1"></i> Dikumpulkan {{ $task->submitted_at?->diffForHumans() ?? '-' }}</span>
                            @if($task->is_late)
                                <span class="badge badge-warning" style="padding: 2px 8px; font-size: 11px;">Terlambat</span>
                            @else
                                <span class="badge badge-success" style="padding: 2px 8px; font-size: 11px;">Tepat Waktu</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Submission Content -->
                @if($task->github_link || $task->submission_file || $task->submission_notes)
                    <div style="padding: 24px; background: #fff;">
                        <div class="grid-2" style="gap: 20px;">
                            @if($task->github_link)
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">GitHub Repository</span>
                                    <a href="{{ $task->github_link }}" target="_blank" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; color: #334155; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.background='#f1f5f9'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                                        <i class="fab fa-github" style="font-size: 20px; color: #333;"></i>
                                        <span style="font-weight: 500; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ Str::limit($task->github_link, 40) }}</span>
                                        <i class="fas fa-external-link-alt" style="margin-left: auto; font-size: 12px; color: #94a3b8;"></i>
                                    </a>
                                </div>
                            @endif

                            @if($task->submission_file)
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">File Upload</span>
                                    <a href="{{ Storage::url('submissions/' . $task->submission_file) }}" target="_blank" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; color: #334155; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.borderColor='#cbd5e1'; this.style.background='#f1f5f9'" onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc'">
                                        <div style="width: 32px; height: 32px; background: #e0f2fe; color: #0284c7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div style="display: flex; flex-direction: column; overflow: hidden;">
                                            <span style="font-weight: 600; font-size: 14px;">Download File</span>
                                            <span style="font-size: 12px; color: #64748b; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $task->submission_file }}</span>
                                        </div>
                                        <i class="fas fa-download" style="margin-left: auto; font-size: 14px; color: #94a3b8;"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($task->submission_notes)
                            <div style="margin-top: 24px;">
                                <span style="font-size: 12px; font-weight: 600; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px; display: block; letter-spacing: 0.5px;">Catatan Siswa</span>
                                <div style="background: #f8fafc; border-radius: 10px; padding: 16px; border: 1px solid #e2e8f0; color: #475569; font-size: 14px; line-height: 1.6;">
                                    {{ $task->submission_notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        <!-- Admin Review Form -->
        <!-- Admin Review Form -->
        @if(auth()->user()->canManage() && $task->status === 'submitted')
            <div class="mt-6" style="background: white; border-radius: 20px; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #e2e8f0;">
                <div style="padding: 24px; background: #fff; border-bottom: 1px solid #f1f5f9;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 32px; height: 32px; background: #eff6ff; color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-gavel"></i>
                        </span>
                        Review & Penilaian
                    </h3>
                </div>

                <form action="{{ route('tasks.review', $task) }}" method="POST" style="padding: 30px;">
                    @csrf

                    <div class="form-group mb-6">
                        <label class="form-label" style="font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; display: block;">Keputusan Pembimbing</label>
                        <div class="d-flex gap-4 review-actions" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <!-- Approve Option -->
                            <label class="cursor-pointer">
                                <input type="radio" name="action" value="approve" checked onchange="toggleScoreInput(true)" style="display: none;" id="radioApprove">
                                <div class="review-card p-4 rounded-xl border text-center transition-all" id="cardApprove" 
                                    style="border: 2px solid #22c55e; background: #f0fdf4; border-radius: 16px; cursor: pointer; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: all 0.2s;">
                                    <div style="width: 48px; height: 48px; background: #dcfce7; color: #166534; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-check text-xl"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #166534; font-size: 16px;">Terima & Nilai</div>
                                        <div style="font-size: 13px; color: #15803d; opacity: 0.8;">Tugas sudah sesuai</div>
                                    </div>
                                </div>
                            </label>

                            <!-- Revision Option -->
                            <label class="cursor-pointer">
                                <input type="radio" name="action" value="revision" onchange="toggleScoreInput(false)" style="display: none;" id="radioRevision">
                                <div class="review-card p-4 rounded-xl border text-center transition-all" id="cardRevision"
                                     style="border: 2px solid #e2e8f0; background: #fff; border-radius: 16px; cursor: pointer; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; transition: all 0.2s;">
                                    <div style="width: 48px; height: 48px; background: #fff7ed; color: #c2410c; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-redo text-xl"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight: 700; color: #334155; font-size: 16px;">Minta Revisi</div>
                                        <div style="font-size: 13px; color: #64748b; opacity: 0.8;">Kembalikan ke siswa</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div id="scoreInputGroup" class="mb-6" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; animation: fadeIn 0.3s ease;">
                        <label class="form-label" style="font-weight: 600; color: #334155; margin-bottom: 8px; display: block;">Berikan Nilai (0-100)</label>
                        <div style="position: relative; max-width: 200px;">
                            <input type="number" name="score" class="form-control" min="0" max="100" placeholder="0" required
                                style="font-size: 24px; font-weight: 700; padding: 12px 16px; height: auto; border-radius: 12px; border: 2px solid #cbd5e1; width: 100%; color: #334155;">
                            <span style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-weight: 600; color: #94a3b8;">/ 100</span>
                        </div>
                    </div>

                    <div class="form-group mb-6">
                        <label class="form-label" style="font-weight: 600; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Feedback / Catatan</label>
                        <textarea name="feedback" class="form-control" rows="4"
                            placeholder="Tuliskan masukan yang membangun untuk siswa..."
                            style="padding: 16px; border-radius: 12px; border: 1px solid #e2e8f0; background: #f8fafc; font-size: 14px; width: 100%; resize: vertical; transition: all 0.2s;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3" style="font-size: 16px; font-weight: 600; border-radius: 12px; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3); transition: transform 0.1s;">
                        <i class="fas fa-paper-plane me-2"></i> Kirim Keputusan
                    </button>
                </form>
            </div>

            <style>
                textarea:focus, input[type="number"]:focus {
                    outline: none;
                    border-color: #6366f1 !important;
                    background: #fff !important;
                    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
                }
                .review-card:hover {
                    transform: translateY(-2px);
                }
            </style>

            <script>
                function toggleScoreInput(show) {
                    const group = document.getElementById('scoreInputGroup');
                    const cardApprove = document.getElementById('cardApprove');
                    const cardRevision = document.getElementById('cardRevision');
                    
                    if (show) {
                        group.style.display = 'block';
                        group.querySelector('input').setAttribute('required', 'required');
                        
                        // Active State for Approve
                        cardApprove.style.border = '2px solid #22c55e';
                        cardApprove.style.background = '#f0fdf4';
                        cardApprove.querySelector('div').style.color = '#166534';
                        
                        // Inactive State for Revision
                        cardRevision.style.border = '2px solid #e2e8f0';
                        cardRevision.style.background = '#fff';
                        cardRevision.querySelector('div').style.color = '#334155';
                    } else {
                        group.style.display = 'none';
                        group.querySelector('input').removeAttribute('required');
                        group.querySelector('input').value = '';
                        
                        // Active State for Revision
                        cardRevision.style.border = '2px solid #f59e0b';
                        cardRevision.style.background = '#fffbeb';
                        cardRevision.querySelector('div').style.color = '#92400e';
                        
                        // Inactive State for Approve
                        cardApprove.style.border = '2px solid #e2e8f0';
                        cardApprove.style.background = '#fff';
                        cardApprove.querySelector('div').style.color = '#334155';
                    }
                }
                
                // Init state
                document.addEventListener('DOMContentLoaded', function() {
                    const radioApprove = document.getElementById('radioApprove');
                   if(radioApprove.checked) {
                       toggleScoreInput(true);
                   }
                });
            </script>
        @endif

        <!-- Grading Result (If completed) -->
        @if($task->status === 'completed' && $task->score !== null)
            <div class="mt-6" style="background: white; border-radius: 24px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.08); overflow: hidden; position: relative;">
                <!-- Decorative Top Border -->
                <div style="height: 6px; background: linear-gradient(90deg, #22c55e, #10b981, #34d399); width: 100%;"></div>
                
                <div style="padding: 40px; display: grid; grid-template-columns: 1fr 1.5fr; gap: 40px; align-items: center;">
                    <!-- Left Side: Score -->
                    <div style="text-align: center; border-right: 1px dashed #e2e8f0; padding-right: 40px;">
                        <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 20px;">
                            <!-- Outer Glow -->
                            <div style="position: absolute; inset: -10px; background: radial-gradient(circle, rgba(34,197,94,0.2) 0%, rgba(255,255,255,0) 70%); border-radius: 50%;"></div>
                            
                            <!-- Progress Circle Background -->
                            <svg viewBox="0 0 36 36" style="width: 100%; height: 100%; transform: rotate(-90deg);">
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="#f1f5f9" stroke-width="2" />
                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none" stroke="url(#gradientScore)" stroke-width="2.5"
                                    stroke-dasharray="{{ $task->score }}, 100" stroke-linecap="round" 
                                    style="filter: drop-shadow(0 2px 4px rgba(34,197,94,0.3));" />
                                <defs>
                                    <linearGradient id="gradientScore" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#22c55e" />
                                        <stop offset="100%" stop-color="#10b981" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            
                            <!-- Score Text -->
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <div style="font-size: 48px; font-weight: 800; color: #15803d; letter-spacing: -1px; line-height: 1;">{{ $task->score }}</div>
                                <div style="font-size: 11px; font-weight: 700; color: #86efac; text-transform: uppercase;">POIN</div>
                            </div>
                        </div>
                        
                        <div style="font-size: 18px; font-weight: 700; color: #166534; margin-bottom: 4px;">
                            @if($task->score >= 90)
                                Excellent Job!
                            @elseif($task->score >= 75)
                                Good Job!
                            @else
                                Keep Going!
                            @endif
                        </div>
                        <div style="font-size: 13px; color: #64748b;">Tugas dinilai pada {{ $task->approved_at?->format('d M Y') }}</div>
                    </div>
                    
                    <!-- Right Side: Feedback -->
                    <div>
                        <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #166534;">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <span style="font-size: 14px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px;">Feedback Pembimbing</span>
                        </div>
                        
                        <div style="position: relative;">
                            <i class="fas fa-quote-left" style="position: absolute; top: -10px; left: -10px; color: #f1f5f9; font-size: 40px; z-index: 0;"></i>
                            <div style="position: relative; z-index: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; font-size: 15px; line-height: 1.8; color: #475569; font-style: italic;">
                                "{{ $task->admin_feedback ?? 'Tidak ada catatan tambahan.' }}"
                            </div>
                        </div>

                        <div style="margin-top: 24px; display: flex; gap: 12px;">
                             <div style="padding: 10px 16px; background: #f0fdf4; border-radius: 12px; border: 1px solid #dcfce7; color: #166534; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-check-double"></i> Status: Selesai
                             </div>
                             @if($task->is_late)
                                 <div style="padding: 10px 16px; background: #fffbeb; border-radius: 12px; border: 1px solid #fef3c7; color: #b45309; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-clock"></i> Terlambat
                                 </div>
                             @else
                                  <div style="padding: 10px 16px; background: #eff6ff; border-radius: 12px; border: 1px solid #dbeafe; color: #1e40af; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-calendar-check"></i> Tepat Waktu
                                 </div>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
