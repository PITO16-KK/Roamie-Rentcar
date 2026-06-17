@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Fleet Tracking')

@section('styles')
<!-- ApexCharts CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.css">

<style>
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .metric-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
        border-color: rgba(255, 255, 255, 0.03) !important;
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0.5rem 0;
        background: var(--accent-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -1px;
    }

    .metric-label {
        color: var(--text-secondary);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* Pulse Dot for Live Status */
    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: var(--success);
        border-radius: 50%;
        position: relative;
    }

    .pulse-dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: var(--success);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(3); opacity: 0; }
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: rgba(30, 41, 59, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.03) !important;
        border-radius: 0.75rem;
        padding: 1.25rem;
        backdrop-filter: blur(10px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .stats-value {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--text-primary);
        letter-spacing: -0.5px;
    }

    .stats-label {
        color: var(--text-secondary);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .map-section {
        background: var(--bg-card);
        border: 1px solid rgba(255, 255, 255, 0.03);
        border-radius: 1rem;
        padding: 1.5rem;
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    #map {
        height: 500px;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .status-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-ongoing { background: rgba(99, 102, 241, 0.15); color: var(--accent); }

    /* Table Styles */
    .rentals-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .rentals-table th, .rentals-table td {
        padding: 1.25rem 1rem;
        text-align: left;
        border-bottom: 1px solid rgba(255, 255, 255, 0.03);
    }

    .rentals-table th {
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }

    .rentals-table td {
        font-size: 0.95rem;
    }

    .rentals-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.01);
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        background: transparent;
        color: var(--text-primary);
    }

    .btn-sm:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    /* Custom Map Marker */
    .pulse-marker {
        width: 12px;
        height: 12px;
        background-color: var(--accent);
        border-radius: 50%;
        border: 2px solid #fff;
        position: relative;
    }

    .pulse-marker::after {
        content: '';
        position: absolute;
        width: 300%;
        height: 300%;
        top: -100%;
        left: -100%;
        border-radius: 50%;
        background-color: var(--accent);
        opacity: 0.4;
        animation: marker-pulse 2s infinite;
    }

    @keyframes marker-pulse {
        0% { transform: scale(0.5); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }
</style>
@endsection

@section('content')
<!-- Main Metrics -->
<div class="metrics-grid">
    <div class="card metric-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="metric-label">Total Mobil</span>
            <i data-lucide="car" style="color: var(--text-secondary); width: 18px; height: 18px;"></i>
        </div>
        <span class="metric-value">{{ $totalCars }}</span>
        <div id="sparkline-total" style="margin-top: auto; margin-bottom: -10px;"></div>
    </div>
    
    <div class="card metric-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="metric-label">Tersedia</span>
            <div class="pulse-dot"></div>
        </div>
        <span class="metric-value">{{ $availableCars }}</span>
        <span style="color: var(--success); font-size: 0.8rem; font-weight: 600;">Siap disewa</span>
    </div>
    
    <div class="card metric-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="metric-label">Di-Booking</span>
            <i data-lucide="calendar" style="color: var(--warning); width: 18px; height: 18px;"></i>
        </div>
        <span class="metric-value">{{ $bookedCars }}</span>
        <span style="color: var(--warning); font-size: 0.8rem; font-weight: 600;">Menunggu jadwal</span>
    </div>
    
    <div class="card metric-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="metric-label">Rental Aktif</span>
            <i data-lucide="navigation" style="color: var(--accent); width: 18px; height: 18px;"></i>
        </div>
        <span class="metric-value">{{ $activeRentals }}</span>
        <div id="sparkline-active" style="margin-top: auto; margin-bottom: -10px;"></div>
    </div>
</div>

<!-- Period Statistics -->
<div class="stats-grid">
    <div class="stats-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <span class="stats-label">Rental Hari Ini</span>
            <i data-lucide="calendar" style="color: var(--text-secondary); width: 16px; height: 16px;"></i>
        </div>
        <span class="stats-value">{{ $dailyRentals }}</span>
    </div>
    <div class="stats-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <span class="stats-label">Rental Minggu Ini</span>
            <i data-lucide="calendar-range" style="color: var(--text-secondary); width: 16px; height: 16px;"></i>
        </div>
        <span class="stats-value">{{ $weeklyRentals }}</span>
    </div>
    <div class="stats-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
            <span class="stats-label">Rental Bulan Ini</span>
            <i data-lucide="calendar-days" style="color: var(--text-secondary); width: 16px; height: 16px;"></i>
        </div>
        <span class="stats-value">{{ $monthlyRentals }}</span>
    </div>
</div>

<!-- Map Section -->
<div class="map-section">
    <div class="map-header">
        <h2 style="font-size: 1.25rem; font-weight: 700;">Live Fleet Tracking</h2>
        <div style="display:flex;gap:.75rem;align-items:center;">
            <span class="status-badge status-ongoing" id="gps-status-badge">● Memuat...</span>
            <button id="btn-gps-sim" onclick="startGpsSimulation()" style="background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);color:#6366f1;padding:.4rem .9rem;border-radius:.75rem;font-size:.78rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:.4rem;">
                <i data-lucide="navigation" style="width:13px;height:13px;"></i> Simulasi GPS HP
            </button>
            <a href="{{ route('admin.export.rentals') }}" style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.25);color:#10b981;padding:.4rem .9rem;border-radius:.75rem;font-size:.78rem;font-weight:700;text-decoration:none;display:flex;align-items:center;gap:.4rem;">
                <i data-lucide="download" style="width:13px;height:13px;"></i> Ekspor CSV
            </a>
        </div>
    </div>
    <div id="map"></div>
    <div id="gps-info" style="margin-top:.85rem;font-size:.8rem;color:#94a3b8;display:none;">
        📍 <span id="gps-coords"></span> &nbsp;|&nbsp; 🕐 <span id="gps-time"></span>
    </div>
</div>

<!-- Active Rentals & Export -->
<div class="card" style="border-color: rgba(255,255,255,0.03); margin-bottom:2rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
        <h2 style="font-size:1.25rem;font-weight:700;">Semua Data Rental & Pembayaran</h2>
        <a href="{{ route('admin.export.rentals') }}" style="display:inline-flex;align-items:center;gap:.5rem;background:var(--accent-gradient);color:#fff;padding:.55rem 1.1rem;border-radius:.75rem;font-size:.82rem;font-weight:700;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
            <i data-lucide="download" style="width:14px;height:14px;"></i> Unduh CSV
        </a>
    </div>

    <table class="rentals-table">
        <thead>
            <tr>
                <th>Mobil</th>
                <th>Penyewa</th>
                <th>Mulai</th>
                <th>Durasi</th>
                <th>Status Sewa</th>
                <th>Pembayaran</th>
                <th>Metode</th>
                <th>Total (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activeRentalsList as $rental)
                <tr>
                    <td style="font-weight:600;">{{ $rental->car->name }}</td>
                    <td style="color:var(--text-secondary);">{{ $rental->user->name }}</td>
                    <td style="color:var(--text-secondary);">{{ $rental->start_date }}</td>
                    <td style="color:var(--text-secondary);">{{ $rental->duration_days }} Hari</td>
                    <td><span class="status-badge status-ongoing">{{ $rental->status }}</span></td>
                    <td>
                        @if(($rental->payment_status ?? 'unpaid') === 'paid')
                            <span style="color:#10b981;font-weight:700;font-size:.78rem;">✓ Lunas</span>
                        @else
                            <span style="color:#f59e0b;font-weight:700;font-size:.78rem;">⏳ Belum</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);font-size:.82rem;">{{ strtoupper($rental->payment_method ?? '-') }}</td>
                    <td style="font-weight:700;">{{ number_format(($rental->car->rental_price ?? 0) * $rental->duration_days, 0, ',', '.') }}</td>
                    <td><button class="btn-sm" onclick="focusCar({{ $rental->car_id }})">Fokus Peta</button></td>
                </tr>
            @empty
                <tr><td colspan="9" style="text-align:center;color:var(--text-secondary);padding:2rem;">Tidak ada data rental saat ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>
<script>
    // ── MAP INIT ──
    var map = L.map('map').setView([-6.200000, 106.816666], 13);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_nolabels/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap © CARTO', subdomains: 'abcd', maxZoom: 20
    }).addTo(map);

    var activeRentals = @json($activeRentalsList);
    var locations     = @json($locations);
    var histories     = @json($histories);
    var markers = {}, bounds = [];

    var pulseIcon = L.divIcon({ className:'custom-div-icon', html:"<div class='pulse-marker'></div>", iconSize:[12,12], iconAnchor:[6,6] });
    var deviceIcon = L.divIcon({ className:'custom-div-icon', html:"<div style='width:16px;height:16px;background:#10b981;border-radius:50%;border:3px solid #fff;box-shadow:0 0 0 4px rgba(16,185,129,.3);'></div>", iconSize:[16,16], iconAnchor:[8,8] });

    // Plot static locations
    activeRentals.forEach(function(rental) {
        var loc = locations.find(l => l.car_id === rental.car_id);
        if (loc && loc.latitude) {
            var m = L.marker([loc.latitude, loc.longitude], {icon: pulseIcon})
                .addTo(map)
                .bindPopup("<div style='color:#000'><b>" + rental.car.name + "</b><br>Penyewa: " + rental.user.name + "</div>");
            markers[rental.car_id] = m;
            bounds.push([loc.latitude, loc.longitude]);
        }
    });

    // Draw trip history polylines
    for (var rid in histories) {
        var path = histories[rid].map(p => [p.latitude, p.longitude]);
        if (path.length > 1) {
            L.polyline(path, { color:'#6366f1', weight:3, opacity:.6, dashArray:'5,5' }).addTo(map);
            path.forEach(p => bounds.push(p));
        }
    }
    if (bounds.length > 0) map.fitBounds(bounds);

    function focusCar(carId) {
        var m = markers[carId];
        if (m) { map.setView(m.getLatLng(), 16); m.openPopup(); }
        else Swal.fire({ title:'Lokasi tidak ditemukan', icon:'warning', background:'#1e293b', color:'#fff', confirmButtonColor:'#6366f1' });
    }

    // ── REAL-TIME GPS SIMULATION using Browser Geolocation ──
    var simMarker = null, simWatchId = null, simCarId = null, simInterval = null;
    var gpsActive = false;

    function startGpsSimulation() {
        if (!navigator.geolocation) {
            Swal.fire({ title:'GPS Tidak Tersedia', text:'Browser Anda tidak mendukung Geolocation.', icon:'error', background:'#1e293b', color:'#fff' });
            return;
        }
        // Pick first active rental's car_id for simulation, or use 0
        simCarId = activeRentals.length > 0 ? activeRentals[0].car_id : 1;

        Swal.fire({
            title: '📡 Aktifkan Simulasi GPS',
            html: 'Posisi GPS perangkat ini akan digunakan sebagai lokasi real-time armada.<br><br>Marker <b style="color:#10b981">hijau</b> = posisi HP Anda saat ini.',
            icon: 'info', confirmButtonText: 'Mulai Lacak', showCancelButton: true,
            confirmButtonColor: '#6366f1', background: '#1e293b', color: '#fff'
        }).then(res => {
            if (!res.isConfirmed) return;

            document.getElementById('btn-gps-sim').textContent = '⏹ Stop GPS';
            document.getElementById('btn-gps-sim').onclick = stopGpsSimulation;
            document.getElementById('gps-status-badge').textContent = '● GPS Aktif (Perangkat)';
            document.getElementById('gps-info').style.display = 'block';
            gpsActive = true;

            simWatchId = navigator.geolocation.watchPosition(function(pos) {
                var lat = pos.coords.latitude, lng = pos.coords.longitude;
                var now = new Date().toLocaleTimeString('id-ID');

                // Update or create device marker
                if (!simMarker) {
                    simMarker = L.marker([lat, lng], { icon: deviceIcon })
                        .addTo(map)
                        .bindPopup("<div style='color:#000'><b>📍 Posisi HP Anda</b><br>GPS Simulasi Real-time</div>");
                } else {
                    simMarker.setLatLng([lat, lng]);
                }
                map.setView([lat, lng], 15);

                // Update coords display
                document.getElementById('gps-coords').textContent = lat.toFixed(6) + ', ' + lng.toFixed(6);
                document.getElementById('gps-time').textContent = 'Update: ' + now;

                // Send to server
                fetch('/api/gps/update', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ car_id: simCarId, latitude: lat, longitude: lng })
                });

                // Update static marker on map too
                if (markers[simCarId]) markers[simCarId].setLatLng([lat, lng]);

            }, function(err) {
                Swal.fire({ title:'Error GPS', text: err.message, icon:'error', background:'#1e293b', color:'#fff' });
                stopGpsSimulation();
            }, { enableHighAccuracy: true, maximumAge: 2000, timeout: 10000 });
        });
    }

    function stopGpsSimulation() {
        if (simWatchId !== null) navigator.geolocation.clearWatch(simWatchId);
        if (simMarker) { simMarker.remove(); simMarker = null; }
        gpsActive = false;
        document.getElementById('gps-status-badge').textContent = '● Real-time';
        document.getElementById('gps-info').style.display = 'none';
        var btn = document.getElementById('btn-gps-sim');
        btn.innerHTML = '<i data-lucide="navigation" style="width:13px;height:13px;"></i> Simulasi GPS HP';
        btn.onclick = startGpsSimulation;
        lucide.createIcons();
    }

    // Auto-poll server for location updates every 5 seconds
    setInterval(function() {
        if (gpsActive) return; // skip if device GPS active
        fetch('/api/gps/all')
            .then(r => r.json())
            .then(data => {
                data.forEach(function(loc) {
                    if (markers[loc.car_id]) markers[loc.car_id].setLatLng([loc.latitude, loc.longitude]);
                });
            }).catch(() => {});
    }, 5000);

    // ── SPARKLINES ──
    var spkOpts = { chart:{type:'line',height:40,sparkline:{enabled:true}}, stroke:{curve:'smooth',width:2}, tooltip:{enabled:false} };
    new ApexCharts(document.querySelector("#sparkline-total"), { ...spkOpts, series:[{data:[5,5,5,5,5,5,{{ $totalCars }}]}], colors:['#94a3b8'] }).render();
    new ApexCharts(document.querySelector("#sparkline-active"), { ...spkOpts, series:[{data:[1,2,1,3,2,4,{{ $activeRentals }}]}], colors:['#6366f1'] }).render();

    lucide.createIcons();
</script>
@endsection
