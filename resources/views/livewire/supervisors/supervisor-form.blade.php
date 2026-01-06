<div class="slide-up">
    <!-- Header -->
    <div class="d-flex justify-between align-center mb-6" style="flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="margin-bottom: 4px;">{{ $pageTitle }}</h2>
            <p class="text-muted">
                @if($isEditing)
                    Perbarui informasi pembimbing
                @else
                    Tambahkan pembimbing baru ke sistem
                @endif
            </p>
        </div>
        <a href="{{ route('supervisors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form wire:submit="save">
            <div class="grid-2" style="gap: 24px;">
                <!-- Left Column - Basic Info -->
                <div>
                    <h3 style="margin-bottom: 20px; font-size: 16px; color: var(--text-primary);">
                        <i class="fas fa-user" style="color: var(--accent-primary); margin-right: 8px;"></i>
                        Informasi Dasar
                    </h3>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color: var(--danger);">*</span></label>
                        <input type="text" wire:model="name" class="form-control" placeholder="Masukkan nama lengkap">
                        @error('name')
                            <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span style="color: var(--danger);">*</span></label>
                        <input type="email" wire:model="email" class="form-control" placeholder="contoh@email.com">
                        @error('email')
                            <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Password -->
                <div>
                    <h3 style="margin-bottom: 20px; font-size: 16px; color: var(--text-primary);">
                        <i class="fas fa-lock" style="color: var(--accent-primary); margin-right: 8px;"></i>
                        Keamanan
                    </h3>

                    <div class="form-group">
                        <label class="form-label">
                            Password 
                            @if(!$isEditing)
                                <span style="color: var(--danger);">*</span>
                            @else
                                <span style="color: var(--text-muted); font-size: 12px;">(Kosongkan jika tidak ingin mengubah)</span>
                            @endif
                        </label>
                        <input type="password" wire:model="password" class="form-control" placeholder="Minimal 8 karakter">
                        @error('password')
                            <span style="color: var(--danger); font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Konfirmasi Password
                            @if(!$isEditing)
                                <span style="color: var(--danger);">*</span>
                            @endif
                        </label>
                        <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            @if(!$isEditing)
            <div style="margin-top: 24px; padding: 16px; background: rgba(99, 102, 241, 0.1); border-radius: var(--radius-md); border: 1px solid rgba(99, 102, 241, 0.2);">
                <div class="d-flex align-center gap-2" style="color: var(--accent-primary);">
                    <i class="fas fa-info-circle"></i>
                    <strong>Informasi</strong>
                </div>
                <p style="color: var(--text-secondary); font-size: 14px; margin-top: 8px; margin-bottom: 0;">
                    Pembimbing yang ditambahkan akan dapat login ke sistem dan mengelola siswa magang yang ditugaskan kepadanya.
                </p>
            </div>
            @endif

            <!-- Submit Button -->
            <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: flex-end;">
                <a href="{{ route('supervisors.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-save" style="margin-right: 8px;"></i>
                        {{ $isEditing ? 'Perbarui' : 'Simpan' }}
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
