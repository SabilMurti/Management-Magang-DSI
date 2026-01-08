<div class="slide-up max-w-5xl mx-auto space-y-5">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800 mb-1">{{ $pageTitle }}</h2>
            <p class="text-slate-400 text-sm">Isi data lengkap pembimbing magang</p>
        </div>
        <a href="{{ route('supervisors.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card overflow-hidden p-0">
        <form wire:submit="save">

            <!-- Section: Informasi Akun -->
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6 pb-4" style="border-bottom: 1px solid rgba(148,163,184,0.1);">
                    <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center">
                        <i class="fas fa-user-shield text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-base">Informasi Akun</h4>
                        <p class="text-sm text-slate-400">Credential login untuk pembimbing</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group mb-0">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="search-input">
                            <input type="text" wire:model="name"
                                class="form-control @error('name') !border-rose-400 @enderror"
                                placeholder="Contoh: Budi Santoso">
                            <i class="fas fa-user"></i>
                        </div>
                        @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Email Address</label>
                        <div class="search-input">
                            <input type="email" wire:model="email"
                                class="form-control @error('email') !border-rose-400 @enderror"
                                placeholder="email@perusahaan.com">
                            <i class="fas fa-envelope"></i>
                        </div>
                        @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Password</label>
                        <div class="search-input">
                            <input type="password" wire:model="password"
                                class="form-control @error('password') !border-rose-400 @enderror"
                                placeholder="Minimal 8 karakter">
                            <i class="fas fa-lock"></i>
                        </div>
                        @if($isEditing)
                            <p class="text-xs text-slate-400 mt-1.5">Kosongkan jika tidak ingin mengubah password.</p>
                        @endif
                        @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="search-input">
                            <input type="password" wire:model="password_confirmation" class="form-control"
                                placeholder="Ulangi password">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="p-6 sm:px-8 flex justify-end gap-3"
                style="background: rgba(248,250,252,0.8); border-top: 1px solid rgba(148,163,184,0.1);">
                <a href="{{ route('supervisors.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-save mr-1"></i> {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
