@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    /* VARIABLES - FLAT & CLEAN THEME */
    :root {
        --color-bg: #f3f4f6;
        --color-white: #ffffff;
        --color-primary: #4f46e5;      /* Indigo-600 */
        --color-primary-hover: #4338ca; 
        --color-success: #10b981;      /* Emerald-500 */
        --color-warning: #f59e0b;      /* Amber-500 */
        --color-danger: #ef4444;       /* Red-500 */
        --color-text-dark: #111827;    /* Gray-900 */
        --color-text-medium: #4b5563;  /* Gray-600 */
        --color-text-light: #9ca3af;   /* Gray-400 */
        --color-border: #e5e7eb;       /* Gray-200 */
        
        --radius-card: 12px;
        --radius-btn: 8px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    body {
        background-color: var(--color-bg);
        font-family: 'Inter', sans-serif;
    }

    /* GRID & LAYOUT */
    .intern-dashboard-container {
        padding-bottom: 50px;
    }

    .dashboard-header-simple {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--color-border);
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: start;
    }

    /* CARDS */
    .card-flat {
        background: var(--color-white);
        border-radius: var(--radius-card);
        border: 1px solid var(--color-border);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: var(--shadow-sm);
    }

    .card-header-flat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-title-flat {
        font-size: 16px;
        font-weight: 700;
        color: var(--color-text-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* MAP SECTION */
    #map-wrapper {
        position: relative;
        height: 350px;
        width: 100%;
        border-radius: var(--radius-btn);
        overflow: hidden;
        border: 1px solid var(--color-border);
        background: #e5e7eb;
        z-index: 1;
    }
    
    #map {
        height: 100%;
        width: 100%;
    }

    /* BUTTONS */
    .btn-flat {
        width: 100%;
        padding: 12px 20px;
        border: none;
        border-radius: var(--radius-btn);
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-flat-primary {
        background-color: var(--color-primary);
        color: white;
    }
    .btn-flat-primary:hover { background-color: var(--color-primary-hover); }
    .btn-flat-primary:disabled { background-color: #cbd5e1; cursor: not-allowed; }

    .btn-flat-warning { background-color: var(--color-warning); color: white; }
    .btn-flat-warning:hover { background-color: #d97706; }

    .btn-flat-outline {
        background-color: transparent;
        border: 1px solid var(--color-border);
        color: var(--color-text-dark);
    }
    .btn-flat-outline:hover { background-color: #f9fafb; border-color: #d1d5db; }

    /* BADGES */
    .badge-status {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-gray { background: #f3f4f6; color: #4b5563; }
    .badge-green { background: #dcfce7; color: #166534; }
    .badge-red { background: #fee2e2; color: #991b1b; }
    
    /* MODAL */
    .modal-backdrop-custom {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .modal-content-custom {
        background: white;
        border-radius: var(--radius-card);
        width: 100%;
        max-width: 480px;
        padding: 30px;
        box-shadow: var(--shadow-md);
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .dashboard-grid { grid-template-columns: 1fr; }
        #map-wrapper { height: 280px; }
    }
</style>
@endpush

<div class="intern-dashboard-container">
    <!-- Header -->
    <div class="dashboard-header-simple">
        <h1 style="font-size: 24px; font-weight: 800; color: #111827; margin: 0;">Dashboard</h1>
        <p style="color: #6b7280; font-size: 14px; margin-top: 4px;">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    <div class="dashboard-grid">
        <!-- LEFT COLUMN (2/3) -->
        <div class="left-section">
            
            <!-- ATTENDANCE CARD -->
            <div class="card-flat">
                <div class="card-header-flat">
                    <h3 class="card-title-flat">
                        <i class="fas fa-map-marked-alt" style="color: var(--color-primary);"></i> Presensi Harian
                    </h3>
                    <div id="gps-status" class="badge-status badge-gray">Mencari Lokasi...</div>
                </div>

                <div style="margin-bottom: 20px;">
                    <div id="map-wrapper">
                        <div id="map"></div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; background: #f9fafb; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f3f4f6;">
                    <span style="font-size: 13px; color: #4b5563;">
                        <i class="fas fa-building me-1"></i> Kantor: <strong>PT. DUTA SOLUSI INFORMATIKA</strong>
                    </span>
                    <span style="font-size: 13px; color: #4b5563;" id="distance-display">
                        Jarak: <strong>-- m</strong>
                    </span>
                </div>

                <!-- Action Buttons -->
                <div>
                     @if(!$todayAttendance)
                        <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm">
                            @csrf
                            <input type="hidden" name="latitude" id="lat">
                            <input type="hidden" name="longitude" id="lon">
                            <input type="hidden" name="late_reason" id="lateReasonInput">
                            
                            <button type="submit" id="checkInBtn" class="btn-flat btn-flat-primary" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;" id="loadingSpinner"></span>
                                <i class="fas fa-location-arrow" id="btnIcon"></i> Menunggu GPS...
                            </button>
                        </form>
                    @elseif(!$todayAttendance->check_out && !in_array($todayAttendance->status, ['permission', 'sick']))
                        <div style="text-align: center; margin-bottom: 15px;">
                            <div style="font-size: 14px; color: #059669; background: #d1fae5; padding: 8px; border-radius: 6px; display: inline-block;">
                                Anda masuk pukul <strong>{{ $todayAttendance->check_in }}</strong>
                            </div>
                        </div>
                        <form action="{{ route('attendance.checkOut') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-flat btn-flat-warning">
                                <i class="fas fa-sign-out-alt"></i> CHECK OUT SEKARANG
                            </button>
                        </form>
                    @else
                        <!-- Attendance Completed -->
                        <div style="text-align: center; padding: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;">
                            <i class="fas fa-check-circle" style="font-size: 32px; color: #16a34a; margin-bottom: 10px; display: block;"></i>
                            <strong style="color: #166534; font-size: 16px;">Selesai Hari Ini</strong>
                            <p style="margin: 4px 0 0; color: #15803d; font-size: 13px;">Status: {{ $todayAttendance->status_label }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- TASKS CARD -->
            <div class="card-flat">
                <div class="card-header-flat">
                    <h3 class="card-title-flat">
                        <i class="fas fa-clipboard-list" style="color: #0d9488;"></i> Tugas Saya
                    </h3>
                    <a href="{{ route('tasks.index') }}" style="font-size: 13px; color: var(--color-primary); font-weight: 600; text-decoration: none;">Lihat Semua</a>
                </div>

                @if($tasks->isEmpty())
                    <div style="text-align: center; padding: 40px; color: #9ca3af;">
                        <i class="far fa-sad-tear" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                        Belum ada tugas aktif.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($tasks as $task)
                            <div style="border: 1px solid var(--color-border); border-radius: 8px; padding: 16px; display: flex; justify-content: space-between; align-items: center; background: white;">
                                <div>
                                    <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 4px;">
                                        <span class="badge-status" style="background: {{ $task->priority == 'high' ? '#fee2e2' : '#e0f2fe' }}; color: {{ $task->priority == 'high' ? '#991b1b' : '#075985' }}; font-size: 10px;">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                        <span style="font-size: 12px; color: #6b7280;">{{ $task->deadline ? $task->deadline->format('d M') : 'No Deadline' }}</span>
                                    </div>
                                    <div style="font-weight: 600; font-size: 14px; color: #111827;">{{ $task->title }}</div>
                                </div>
                                <a href="{{ route('tasks.show', $task) }}" class="btn-flat-outline" style="padding: 6px 12px; width: auto; font-size: 12px; border-radius: 6px;">Detail</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT COLUMN (1/3) -->
        <div class="right-section">
            
            <!-- QUICK MENU IZIN -->
            <div class="card-flat">
                <h4 style="font-size: 12px; font-weight: 700; color: #6b7280; text-transform: uppercase; margin-bottom: 16px; letter-spacing: 0.5px;">Menu Izin</h4>
                
                @if(!$todayAttendance)
                    <button onclick="openModal('permissionModal')" class="btn-flat btn-flat-outline" style="justify-content: space-between; text-align: left;">
                        <span style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-file-medical" style="color: var(--color-primary);"></i> Form Izin / Sakit
                        </span>
                        <i class="fas fa-chevron-right" style="font-size: 12px; color: #9ca3af;"></i>
                    </button>
                @else
                    <div style="font-size: 13px; color: #6b7280; text-align: center; padding: 10px; background: #f9fafb; border-radius: 6px;">
                        Presensi hari ini sudah tercatat.
                    </div>
                @endif
            </div>

            <!-- STATS SUMMARY -->
            <div class="card-flat">
                <div class="card-header-flat" style="margin-bottom: 16px;">
                    <h3 class="card-title-flat">Statistik Ringkas</h3>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                    <div style="background: #f0f9ff; padding: 12px; border-radius: 8px; text-align: center; border: 1px solid #bae6fd;">
                        <div style="font-size: 20px; font-weight: 800; color: #0284c7;">{{ $attendancePercentage }}%</div>
                        <div style="font-size: 10px; font-weight: 600; color: #075985;">KEHADIRAN</div>
                    </div>
                    <div style="background: #f0fdf4; padding: 12px; border-radius: 8px; text-align: center; border: 1px solid #bbf7d0;">
                        <div style="font-size: 20px; font-weight: 800; color: #16a34a;">{{ $completedTasks }}</div>
                        <div style="font-size: 10px; font-weight: 600; color: #166534;">TUGAS SELESAI</div>
                    </div>
                </div>

                <h5 style="margin: 0 0 10px; font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase;">Riwayat Terakhir</h5>
                <div>
                     @foreach($attendances->take(3) as $log)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e5e7eb; font-size: 13px;">
                            <span style="color: #374151;">{{ $log->date->format('d/m') }}</span>
                            <span class="badge-status {{ $log->status == 'present' ? 'badge-green' : ($log->status == 'late' ? 'badge-red' : 'badge-gray') }}" style="font-size: 10px;">
                                {{ $log->status_label }}
                            </span>
                        </div>
                     @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL PERMISSION -->
<div id="permissionModal" class="modal-backdrop-custom">
    <div class="modal-content-custom">
        <div style="text-align: center; margin-bottom: 24px;">
            <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: #111827;">Form Izin</h3>
            <p style="margin: 4px 0 0; color: #6b7280; font-size: 14px;">Silakan isi detail ketidakhadiran Anda.</p>
        </div>
        
        <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" id="permissionForm">
            @csrf
            
            <input type="hidden" name="latitude" id="permLat">
            <input type="hidden" name="longitude" id="permLon">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #374151;">Jenis Izin</label>
                <div style="display: flex; gap: 16px;">
                    <label style="flex: 1; display: block; cursor: pointer;">
                        <input type="radio" name="status" value="permission" checked style="margin-right: 8px;"> Izin Biasa
                    </label>
                    <label style="flex: 1; display: block; cursor: pointer;">
                        <input type="radio" name="status" value="sick" style="margin-right: 8px;"> Sakit
                    </label>
                </div>
            </div>

            <!-- Upload Bukti -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #374151;">Bukti Lampiran (Surat Dokter/Lainnya)</label>
                <input type="file" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" class="form-control" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px; font-size: 13px;">
                <small style="color: #6b7280; font-size: 11px;">Max: 2MB (PDF/JPG/PNG)</small>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 8px; color: #374151;">Keterangan</label>
                <textarea name="notes" rows="4" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; font-family: inherit; font-size: 14px;" required placeholder="Jelaskan alasan Anda..."></textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeModal('permissionModal')" class="btn-flat btn-flat-outline">Batal</button>
                <button type="submit" class="btn-flat btn-flat-primary">Kirim</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL LATE REASON -->
<div id="lateReasonModal" class="modal-backdrop-custom" style="display: {{ session('show_late_reason_form') ? 'flex' : 'none' }};">
    <div class="modal-content-custom">
        <div style="text-align: center; margin-bottom: 24px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 32px; color: #f59e0b; margin-bottom: 12px; display: block;"></i>
            <h3 style="margin: 0; font-size: 20px; font-weight: 800; color: #111827;">Terlambat Check-in</h3>
            <p style="margin: 4px 0 0; color: #6b7280; font-size: 14px;">Waktu masuk telah berlalu. Mohon sertakan alasan.</p>
        </div>

        <div style="margin-bottom: 24px;">
            <textarea id="lateReasonText" rows="3" style="width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; font-family: inherit; font-size: 14px;" placeholder="Alasan keterlambatan..."></textarea>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="button" onclick="closeModal('lateReasonModal')" class="btn-flat btn-flat-outline">Batal</button>
            <button type="button" id="submitLateBtn" class="btn-flat btn-flat-primary">Simpan & Check In</button>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // --- MAP & GPS ---
    const officeLat = {{ $officeLat ?? -7.052683 }};
    const officeLon = {{ $officeLon ?? 110.469375 }};
    const maxDist = {{ $maxDist ?? 100 }};

    function initMap() {
        const mapContainer = document.getElementById('map');
        if(!mapContainer) return;

        const map = L.map('map').setView([officeLat, officeLon], 16);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        L.marker([officeLat, officeLon]).addTo(map).bindPopup("<b>Kantor</b>").openPopup();
        L.circle([officeLat, officeLon], {
            color: '#4f46e5',
            fillColor: '#4f46e5',
            fillOpacity: 0.15,
            radius: maxDist
        }).addTo(map);
        
        return map;
    }

    // Delay init to ensure container layout is ready
    setTimeout(() => {
        const map = initMap();
        
        // GPS Logic
        const checkInBtn = document.getElementById('checkInBtn');
        const latInput = document.getElementById('lat');
        const lonInput = document.getElementById('lon');
        const distDisplay = document.getElementById('distance-display');
        const gpsStatus = document.getElementById('gps-status');
        const btnIcon = document.getElementById('btnIcon');
        let userMarker;

        if (navigator.geolocation && map) {
            navigator.geolocation.watchPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                if(latInput) latInput.value = lat;
                if(lonInput) lonInput.value = lng;

                if(userMarker) userMarker.setLatLng([lat, lng]);
                else userMarker = L.marker([lat, lng]).addTo(map);

                const dist = map.distance([officeLat, officeLon], [lat, lng]);
                
                if(distDisplay) distDisplay.innerHTML = "Jarak: <strong>" + Math.round(dist) + " m</strong>";

                if (checkInBtn) {
                    if (dist <= maxDist) {
                        checkInBtn.disabled = false;
                        checkInBtn.classList.remove('btn-flat-primary'); 
                        checkInBtn.classList.add('btn-flat-primary'); // Ensure primary color
                        checkInBtn.style.background = "#10b981"; // Success green override
                        checkInBtn.innerHTML = '<i class="fas fa-fingerprint"></i> CHECK IN SEKARANG';
                        
                        if(gpsStatus) {
                            gpsStatus.innerHTML = "Lokasi Valid";
                            gpsStatus.className = "badge-status badge-green";
                        }
                    } else {
                        checkInBtn.disabled = true;
                        checkInBtn.style.background = "#cbd5e1";
                        checkInBtn.innerHTML = '<i class="fas fa-ban"></i> Terlalu Jauh';
                        
                        if(gpsStatus) {
                            gpsStatus.innerHTML = "Diluar Jangkauan";
                            gpsStatus.className = "badge-status badge-red";
                        }
                    }
                }
            }, (error) => {
                console.error("GPS Error", error);
                if(gpsStatus) {
                    gpsStatus.innerHTML = "GPS Error";
                    gpsStatus.className = "badge-status badge-red";
                }
            }, {
                enableHighAccuracy: true,
                maximumAge: 10000
            });
        }
    }, 500);

    // --- MODALS ---
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
        
        // If opening permission modal, try to get GPS
        if (id === 'permissionModal') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    document.getElementById('permLat').value = lat;
                    document.getElementById('permLon').value = lon;
                }, (err) => {
                    console.log("GPS Permission Error: " + err.message);
                });
            }
        }
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    
    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-backdrop-custom')) {
            event.target.style.display = "none";
        }
    }

    // Late Reason Submit
    const lateSubmitBtn = document.getElementById('submitLateBtn');
    if(lateSubmitBtn) {
        lateSubmitBtn.addEventListener('click', function() {
            const reason = document.getElementById('lateReasonText').value;
            if(!reason.trim()) {
                alert("Mohon isi alasan keterlambatan!");
                return;
            }
            document.getElementById('lateReasonInput').value = reason;
            document.getElementById('checkInForm').submit();
        });
    }
</script>
@endpush
@endsection
