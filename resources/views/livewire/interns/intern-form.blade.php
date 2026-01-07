<div class="slide-up" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
    <div class="d-flex justify-between align-center mb-6">
        <div>
            <h2 style="margin-bottom: 4px;">{{ $pageTitle }}</h2>
            <p class="text-muted">Isi data lengkap anggota magang baru</p>
        </div>
        <a href="{{ route('interns.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form wire:submit="save">
            
            <!-- Section: Informasi Akun -->
            <div style="padding: 40px 60px;">
                <div class="d-flex align-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-user-shield text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg m-0">Informasi Akun</h4>
                        <p class="text-sm text-gray-500 m-0">Credential login untuk siswa magang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <input type="text" wire:model="name"
                                class="form-control pl-10 @error('name') border-red-500 @enderror"
                                placeholder="Contoh: Ahmad Fauzi"
                                style="padding-left: 45px;">
                        </div>
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input type="email" wire:model="email"
                                class="form-control pl-10 @error('email') border-red-500 @enderror"
                                placeholder="email@sekolah.com"
                                style="padding-left: 45px;">
                        </div>
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Password -->
                    @if(!$isEditing)
                    <div class="form-group md:col-span-2">
                        <label class="form-label font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" wire:model="password"
                                class="form-control pl-10 @error('password') border-red-500 @enderror" 
                                placeholder="Minimal 8 karakter"
                                style="padding-left: 45px;">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Gunakan kombinasi huruf dan angka untuk keamanan.</p>
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>
            </div>

            <div class="h-2 bg-gray-50 border-t border-b border-gray-100"></div>

            <!-- Section: Data Profil -->
            <div style="padding: 40px 60px;">
                <div class="d-flex align-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-id-card text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg m-0">Data Pribadi</h4>
                        <p class="text-sm text-gray-500 m-0">Informasi detail siswa magang</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIS -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">NIS (Nomor Induk Siswa)</label>
                        <input type="text" wire:model="nis" class="form-control @error('nis') border-red-500 @enderror" placeholder="Nomor Induk">
                        @error('nis') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- No Telepon -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">WhatsApp / Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <input type="text" wire:model="phone"
                                class="form-control pl-10 @error('phone') border-red-500 @enderror" 
                                placeholder="08xxxxxxxxxx"
                                style="padding-left: 45px;">
                        </div>
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Asal Sekolah -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Asal Sekolah / Kampus</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-school"></i>
                            </div>
                            <input type="text" wire:model="school"
                                class="form-control pl-10 @error('school') border-red-500 @enderror"
                                placeholder="Nama Instansi Pendidikan"
                                style="padding-left: 45px;">
                        </div>
                        @error('school') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Jurusan -->
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Jurusan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <input type="text" wire:model="department"
                                class="form-control pl-10 @error('department') border-red-500 @enderror"
                                placeholder="Contoh: RPL, TKJ"
                                style="padding-left: 45px;">
                        </div>
                        @error('department') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Alamat -->
                    <div class="form-group md:col-span-2">
                        <label class="form-label font-medium text-gray-700 mb-2">Alamat Domisili</label>
                        <textarea wire:model="address" 
                            class="form-control @error('address') border-red-500 @enderror"
                            rows="2" placeholder="Alamat lengkap tempat tinggal sekarang"></textarea>
                        @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="h-2 bg-gray-50 border-t border-b border-gray-100"></div>

            <!-- Section: Periode Magang -->
            <div style="padding: 40px 60px;">
                <div class="d-flex align-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <div class="bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-clock text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg m-0">Periode Magang</h4>
                        <p class="text-sm text-gray-500 m-0">Durasi dan pembimbing lapangan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" wire:model="start_date"
                            class="form-control @error('start_date') border-red-500 @enderror">
                        @error('start_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" wire:model="end_date"
                            class="form-control @error('end_date') border-red-500 @enderror">
                        @error('end_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Pembimbing -->
                    <div class="form-group @if(!$isEditing) md:col-span-2 @endif">
                        <label class="form-label font-medium text-gray-700 mb-2">Pembimbing Lapangan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none text-gray-400" style="padding-left: 16px;">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <select wire:model="supervisor_id"
                                class="form-control pl-10 @error('supervisor_id') border-red-500 @enderror"
                                style="padding-left: 45px;">
                                <option value="">Pilih Pembimbing</option>
                                @foreach($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('supervisor_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @if($isEditing)
                        <div class="form-group">
                            <label class="form-label font-medium text-gray-700 mb-2">Status Magang</label>
                            <select wire:model="status" class="form-control">
                                <option value="active">Aktif</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan/Berhenti</option>
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Action -->
            <div class="bg-gray-50 py-5 border-t border-gray-100 flex justify-end gap-3 rounded-b-xl" style="padding-left: 60px; padding-right: 60px;">
                <a href="{{ route('interns.index') }}" class="btn btn-secondary px-6">Batal</a>
                <button type="submit" class="btn btn-primary px-6 shadow-md hover:shadow-lg transition-all" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-save mr-2"></i> {{ $isEditing ? 'Simpan Perubahan' : 'Simpan Data Lengkap' }}
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>
