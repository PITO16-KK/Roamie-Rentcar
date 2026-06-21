<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - ROAMIE</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --bg-primary: #0b111e;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #6366f1;
            --accent-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --border: rgba(255,255,255,0.05);
            --glass: rgba(30,41,59,0.4);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Plus Jakarta Sans',sans-serif; }
        body { background-color:var(--bg-primary); color:var(--text-primary); min-height:100vh; background-image:radial-gradient(circle at 20% 0%, rgba(99,102,241,0.12), transparent 50%); }

        /* NAV */
        .navbar { display:flex; justify-content:space-between; align-items:center; padding:1.25rem 2.5rem; border-bottom:1px solid var(--border); background:rgba(11,17,30,0.8); backdrop-filter:blur(12px); position:sticky; top:0; z-index:100; }
        .logo { font-size:1.4rem; font-weight:800; background:var(--accent-gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; text-transform:uppercase; letter-spacing:2px; text-decoration:none; }
        .nav-actions { display:flex; align-items:center; gap:1rem; }
        .nav-link { color:var(--text-secondary); text-decoration:none; font-size:0.9rem; font-weight:500; transition:color .3s; }
        .nav-link:hover { color:var(--text-primary); }
        .btn-logout { display:inline-flex; align-items:center; gap:.4rem; padding:.5rem 1.1rem; border-radius:2rem; border:1px solid rgba(239,68,68,.3); background:rgba(239,68,68,.08); color:#ef4444; font-size:.85rem; font-weight:600; text-decoration:none; transition:all .3s; }
        .btn-logout:hover { background:rgba(239,68,68,.15); border-color:rgba(239,68,68,.5); }

        /* LAYOUT */
        .page-container { max-width:1100px; margin:0 auto; padding:2.5rem 2rem; }
        .page-header { margin-bottom:2.5rem; }
        .page-title { font-size:2rem; font-weight:800; letter-spacing:-0.5px; }
        .page-subtitle { color:var(--text-secondary); margin-top:.3rem; font-size:.95rem; }

        .grid-2 { display:grid; grid-template-columns:340px 1fr; gap:2rem; align-items:start; }
        @media(max-width:900px) { .grid-2 { grid-template-columns:1fr; } }

        /* CARD */
        .card { background:var(--glass); border:1px solid var(--border); border-radius:1.25rem; padding:1.75rem; backdrop-filter:blur(12px); }

        /* PROFILE CARD */
        .avatar-ring { width:80px; height:80px; border-radius:50%; background:var(--accent-gradient); display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:800; color:#fff; margin:0 auto 1.25rem; box-shadow:0 0 0 4px rgba(99,102,241,.2); }
        .profile-name { font-size:1.35rem; font-weight:700; text-align:center; }
        .profile-email { color:var(--text-secondary); font-size:.85rem; text-align:center; margin-top:.25rem; }
        .profile-badge { display:inline-flex; align-items:center; gap:.4rem; background:rgba(99,102,241,.1); border:1px solid rgba(99,102,241,.3); color:var(--accent); border-radius:2rem; padding:.3rem .85rem; font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; margin:.75rem auto 1.5rem; }
        .profile-divider { border:none; border-top:1px solid var(--border); margin:1.25rem 0; }
        .info-item { display:flex; align-items:center; gap:.75rem; padding:.6rem 0; }
        .info-item i { width:16px; height:16px; color:var(--accent); flex-shrink:0; }
        .info-label { color:var(--text-secondary); font-size:.8rem; display:block; }
        .info-value { font-size:.9rem; font-weight:600; }

        .edit-form { margin-top:1.25rem; display:flex; flex-direction:column; gap:.85rem; }
        .form-label { display:block; font-size:.8rem; color:var(--text-secondary); margin-bottom:.35rem; font-weight:500; }
        .form-input { width:100%; padding:.7rem 1rem; background:rgba(15,23,42,.6); border:1px solid var(--border); border-radius:.75rem; color:var(--text-primary); font-size:.9rem; transition:border-color .3s; }
        .form-input:focus { outline:none; border-color:var(--accent); }
        .btn-save { background:var(--accent-gradient); color:#fff; border:none; padding:.7rem; border-radius:.75rem; font-weight:700; cursor:pointer; transition:all .3s; font-size:.9rem; }
        .btn-save:hover { opacity:.9; transform:translateY(-1px); }

        /* RENTAL CARDS */
        .section-title { font-size:1.15rem; font-weight:700; margin-bottom:1.25rem; display:flex; align-items:center; gap:.6rem; }
        .section-title i { width:18px; height:18px; color:var(--accent); }
        .rental-card { background:rgba(15,23,42,.5); border:1px solid var(--border); border-radius:1rem; padding:1.25rem; margin-bottom:1rem; transition:all .3s; position:relative; overflow:hidden; }
        .rental-card:hover { border-color:rgba(99,102,241,.2); background:rgba(30,41,59,.5); }
        .rental-card-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:.85rem; }
        .rental-car-name { font-size:1.05rem; font-weight:700; }
        .rental-car-type { color:var(--text-secondary); font-size:.8rem; margin-top:.15rem; }
        .badge { padding:.3rem .75rem; border-radius:2rem; font-size:.7rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; flex-shrink:0; }
        .badge-paid { background:rgba(16,185,129,.1); color:var(--success); border:1px solid rgba(16,185,129,.2); }
        .badge-unpaid { background:rgba(245,158,11,.1); color:var(--warning); border:1px solid rgba(245,158,11,.2); }
        .badge-ongoing { background:rgba(99,102,241,.1); color:var(--accent); border:1px solid rgba(99,102,241,.2); }
        .badge-completed { background:rgba(148,163,184,.1); color:var(--text-secondary); border:1px solid rgba(148,163,184,.2); }
        .badge-booked { background:rgba(16,185,129,.1); color:var(--success); border:1px solid rgba(16,185,129,.2); }
        .rental-meta { display:flex; gap:1.25rem; flex-wrap:wrap; margin-bottom:.85rem; }
        .meta-item { display:flex; align-items:center; gap:.4rem; color:var(--text-secondary); font-size:.82rem; }
        .meta-item i { width:13px; height:13px; color:var(--accent); }
        .rental-price { font-size:1.2rem; font-weight:800; background:var(--accent-gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; }
        .rental-price-label { color:var(--text-secondary); font-size:.78rem; }
        .btn-pay { display:inline-flex; align-items:center; gap:.4rem; background:var(--accent-gradient); color:#fff; border:none; padding:.6rem 1.2rem; border-radius:.75rem; font-size:.85rem; font-weight:700; cursor:pointer; text-decoration:none; transition:all .3s; margin-top:.75rem; }
        .btn-pay:hover { opacity:.9; transform:translateY(-1px); box-shadow:0 4px 14px rgba(99,102,241,.3); }
        .rental-glow { position:absolute; top:0; left:0; right:0; height:2px; background:var(--accent-gradient); opacity:0; transition:opacity .3s; }
        .rental-card:hover .rental-glow { opacity:1; }

        .empty-state { text-align:center; padding:3rem; color:var(--text-secondary); }
        .empty-state i { width:44px; height:44px; color:var(--accent); opacity:.4; margin-bottom:1rem; }

        /* ALERT */
        .alert { padding:.85rem 1rem; border-radius:.75rem; margin-bottom:1.5rem; font-size:.88rem; display:flex; align-items:center; gap:.6rem; }
        .alert-success { background:rgba(16,185,129,.1); border:1px solid rgba(16,185,129,.3); color:var(--success); }

        /* FLOATING CHATBOT WIDGET */
        .chatbot-fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--accent-gradient);
            box-shadow: 0 4px 20px rgba(99,102,241,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .chatbot-fab:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 6px 24px rgba(99,102,241,0.6);
        }
        .chatbot-fab i {
            width: 28px;
            height: 28px;
        }
        
        .chatbot-container {
            position: fixed;
            bottom: 6.5rem;
            right: 2rem;
            width: 380px;
            height: 500px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1.25rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px) scale(0.95);
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.15);
            overflow: hidden;
        }
        .chatbot-container.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: all;
        }
        
        .chatbot-header {
            padding: 1.25rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(168, 85, 247, 0.2) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chatbot-header-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .chatbot-header-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--accent-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .chatbot-header-title {
            font-weight: 700;
            font-size: 0.95rem;
        }
        .chatbot-header-subtitle {
            font-size: 0.75rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .chatbot-header-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--success);
            display: inline-block;
            box-shadow: 0 0 8px var(--success);
        }
        .chatbot-close-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }
        .chatbot-close-btn:hover {
            color: var(--text-primary);
        }
        
        .chatbot-messages {
            flex: 1;
            padding: 1.25rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            scroll-behavior: smooth;
        }
        
        .chat-bubble {
            max-width: 80%;
            padding: 0.85rem 1.1rem;
            border-radius: 1rem;
            font-size: 0.88rem;
            line-height: 1.4;
            position: relative;
            word-wrap: break-word;
        }
        .chat-bubble-ai {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            align-self: flex-start;
            border-top-left-radius: 0.25rem;
            color: var(--text-primary);
        }
        .chat-bubble-user {
            background: var(--accent-gradient);
            color: #fff;
            align-self: flex-end;
            border-top-right-radius: 0.25rem;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);
        }
        
        .chatbot-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(15, 23, 42, 0.4);
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }
        .chatbot-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border-radius: 2rem;
            background: rgba(11, 17, 30, 0.6);
            border: 1px solid rgba(255,255,255,0.08);
            color: var(--text-primary);
            font-size: 0.88rem;
            outline: none;
            transition: border-color 0.3s;
        }
        .chatbot-input:focus {
            border-color: var(--accent);
        }
        .chatbot-send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-gradient);
            border: none;
            color: #fff;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.3s, transform 0.3s;
            flex-shrink: 0;
        }
        .chatbot-send-btn:hover {
            transform: scale(1.05);
        }
        .chatbot-send-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }
        
        /* TYPING INDICATOR */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 0.5rem 0.75rem;
            background: rgba(30, 41, 59, 0.4);
            border-radius: 1rem;
            align-self: flex-start;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }
        .typing-dot {
            width: 6px;
            height: 6px;
            background: var(--text-secondary);
            border-radius: 50%;
            animation: typingWave 1.4s infinite ease-in-out;
            opacity: 0.6;
        }
        .typing-dot:nth-child(1) { animation-delay: 0s; }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        
        @keyframes typingWave {
            0%, 60%, 100% { transform: translateY(0); }
            30% { transform: translateY(-4px); }
        }
        @media(max-width: 480px) {
            .chatbot-container {
                width: calc(100% - 2rem);
                height: 400px;
                right: 1rem;
                left: 1rem;
                bottom: 5.5rem;
            }
            .chatbot-fab {
                bottom: 1rem;
                right: 1rem;
                width: 50px;
                height: 50px;
            }
        }

        /* GPS TOGGLE SWITCH */
        .switch input:checked + .slider {
            background: var(--accent-gradient);
        }
        .switch .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        .switch input:checked + .slider:before {
            transform: translateX(22px);
        }
        @keyframes pulse {
            0% { opacity: 0.6; }
            50% { opacity: 1; }
            100% { opacity: 0.6; }
        }
    </style>
</head>

<body>
<nav class="navbar">
    <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
    <div class="nav-actions">
        <a href="{{ route('catalog.index') }}" class="nav-link">Promo</a>
        <a href="{{ route('logout') }}" class="btn-logout">
            <i data-lucide="log-out"></i> Keluar
        </a>
    </div>
</nav>

<div class="page-container">
    @if(session('success'))
        <div class="alert alert-success">
            <i data-lucide="check-circle" style="width:16px;height:16px;flex-shrink:0;"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-header">
        <h1 class="page-title">Profil Saya</h1>
        <p class="page-subtitle">Kelola informasi akun dan lihat riwayat sewa kendaraan Anda.</p>
    </div>

    <div class="grid-2">
        <!-- Left: Profile Card -->
        <div>
            <div class="card" style="text-align:center;">
                <div class="avatar-ring" style="overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="profile-name">{{ $user->name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
                <div style="display:flex;justify-content:center;">
                    <span class="profile-badge">
                        <i data-lucide="shield-check" style="width:12px;height:12px;"></i>
                        Customer Terverifikasi
                    </span>
                </div>

                <hr class="profile-divider">

                <div class="info-item">
                    <i data-lucide="mail"></i>
                    <div>
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i data-lucide="phone"></i>
                    <div>
                        <span class="info-label">No. Handphone</span>
                        <span class="info-value">{{ $user->phone ?? 'Belum diatur' }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i data-lucide="map-pin"></i>
                    <div>
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $user->address ?? 'Belum diatur' }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i data-lucide="calendar"></i>
                    <div>
                        <span class="info-label">Bergabung sejak</span>
                        <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="info-item">
                    <i data-lucide="car"></i>
                    <div>
                        <span class="info-label">Total Pemesanan</span>
                        <span class="info-value">{{ $rentals->count() }} kali sewa</span>
                    </div>
                </div>

                <hr class="profile-divider">

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-form" style="text-align:left;">
                    @csrf
                    <div>
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="avatar" class="form-input" accept="image/*">
                    </div>
                    <div>
                        <label class="form-label">Ubah Nama</label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div>
                        <label class="form-label">No. Handphone</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                    </div>
                    <div>
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-input" style="resize:none;height:80px;" placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <!-- Right: Rentals -->
        <div>
            <div class="section-title">
                <i data-lucide="clipboard-list"></i>
                Riwayat & Status Pemesanan
            </div>

            @forelse($rentals as $rental)
                @php
                    $total = $rental->car->rental_price * $rental->duration_days;
                    $isPaid = $rental->payment_status === 'paid';
                    $endDate = \Carbon\Carbon::parse($rental->start_date)->addDays((int) $rental->duration_days)->format('d M Y');
                @endphp
                <div class="rental-card">
                    <div class="rental-glow"></div>
                    <div class="rental-card-header">
                        <div>
                            <div class="rental-car-name">{{ $rental->car->name ?? 'N/A' }}</div>
                            <div class="rental-car-type">
                                {{ $rental->car->type ?? '' }} &bull; Plat: <span style="font-family: monospace; font-weight: 700; color: var(--accent);">{{ $rental->car->plate_number ?? '-' }}</span>
                            </div>
                        </div>
                        <div style="display:flex;flex-direction:column;gap:.4rem;align-items:flex-end;">
                            <span class="badge badge-{{ $rental->status === 'on-going' ? 'ongoing' : ($rental->status === 'completed' ? 'completed' : 'booked') }}">
                                {{ $rental->status === 'on-going' ? 'Sedang Berjalan' : ($rental->status === 'completed' ? 'Selesai' : 'Dipesan') }}
                            </span>
                            <span class="badge badge-{{ $isPaid ? 'paid' : 'unpaid' }}">
                                {{ $isPaid ? '✓ Lunas' : '⏳ Belum Bayar' }}
                            </span>
                        </div>
                    </div>

                    <div class="rental-meta">
                        <div class="meta-item">
                            <i data-lucide="calendar-check"></i>
                            <span>{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</span>
                        </div>
                        <div class="meta-item">
                            <i data-lucide="calendar-x"></i>
                            <span>{{ $endDate }}</span>
                        </div>
                        <div class="meta-item">
                            <i data-lucide="clock"></i>
                            <span>{{ $rental->duration_days }} hari</span>
                        </div>
                        @if($rental->payment_method)
                        <div class="meta-item">
                            <i data-lucide="credit-card"></i>
                            <span>{{ strtoupper($rental->payment_method) }}</span>
                        </div>
                        @endif
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--border);padding-top:.85rem;margin-top:.25rem;">
                        <div>
                            <div class="rental-price-label">Total Pembayaran</div>
                            <div class="rental-price">Rp {{ number_format($total, 0, ',', '.') }}</div>
                        </div>
                        @if(!$isPaid)
                            <a href="{{ route('payment.show', $rental->id) }}" class="btn-pay">
                                <i data-lucide="credit-card" style="width:14px;height:14px;"></i>
                                Bayar Sekarang
                            </a>
                        @else
                            <a href="{{ route('payment.invoice', $rental->id) }}" target="_blank" class="btn-pay" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                <i data-lucide="file-text" style="width:14px;height:14px;"></i>
                                Cetak Invoice
                            </a>
                        @endif
                    </div>

                    @if($isPaid)
                        <div style="margin-top: 1rem; padding-top: 0.85rem; border-top: 1px dashed var(--border); display: flex; flex-direction: column; gap: 0.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-lucide="navigation" style="width: 16px; height: 16px; color: var(--success);"></i>
                                    <span style="font-size: 0.85rem; font-weight: 600;">Lacak GPS Unit Mobil</span>
                                </div>
                                <label class="switch" style="position: relative; display: inline-block; width: 44px; height: 22px;">
                                    <input type="checkbox" class="gps-toggle" data-car-id="{{ $rental->car_id }}" style="opacity: 0; width: 0; height: 0;" onchange="toggleGpsTracking(this)">
                                    <span class="slider" style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #334155; transition: 0.3s; border-radius: 22px;"></span>
                                </label>
                            </div>
                            <div class="gps-coords-display" id="gps-coords-{{ $rental->car_id }}" style="display: none; font-size: 0.78rem; color: var(--success); align-items: center; gap: 0.35rem; animation: pulse 2s infinite;">
                                <span>📡 GPS Aktif: Mengirimkan posisi real-time ke Admin...</span>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="card empty-state">
                    <i data-lucide="car"></i>
                    <h3 style="margin-bottom:.5rem;">Belum ada pemesanan</h3>
                    <p style="font-size:.9rem;">Temukan berbagai penawaran sewa menarik di halaman promo kami.</p>
                    <a href="{{ route('catalog.index') }}" class="btn-pay" style="margin-top:1.25rem;display:inline-flex;">
                        <i data-lucide="search" style="width:14px;height:14px;"></i>
                        Jelajahi Promo
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Floating Chatbot FAB -->
<div class="chatbot-fab" id="chatbotFab" title="Tanya Asisten AI">
    <i data-lucide="message-square-more"></i>
</div>

<!-- Chatbot Window -->
<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-header">
        <div class="chatbot-header-info">
            <div class="chatbot-header-avatar">🤖</div>
            <div>
                <div class="chatbot-header-title">Asisten AI Roamie</div>
                <div class="chatbot-header-subtitle">
                    <span class="chatbot-header-status-dot"></span>
                    <span>Online • 24/7 CS AI</span>
                </div>
            </div>
        </div>
        <button class="chatbot-close-btn" id="chatbotCloseBtn" title="Tutup Chat">
            <i data-lucide="x" style="width:20px;height:20px;"></i>
        </button>
    </div>
    
    <div class="chatbot-messages" id="chatbotMessages">
        <div class="chat-bubble chat-bubble-ai">
            Halo! Saya Asisten AI Roamie. Ada yang bisa saya bantu mengenai persyaratan sewa, tata cara pembayaran, atau kendala pemesanan mobil Anda?
        </div>
    </div>
    
    <div class="chatbot-footer">
        <input type="text" class="chatbot-input" id="chatbotInput" placeholder="Tulis pesan Anda..." autocomplete="off">
        <button class="chatbot-send-btn" id="chatbotSendBtn" disabled>
            <i data-lucide="send" style="width:16px;height:16px;"></i>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotFab = document.getElementById('chatbotFab');
    const chatbotContainer = document.getElementById('chatbotContainer');
    const chatbotCloseBtn = document.getElementById('chatbotCloseBtn');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotSendBtn = document.getElementById('chatbotSendBtn');
    const chatbotMessages = document.getElementById('chatbotMessages');

    // State riwayat percakapan untuk dikirim ke API Gemini
    let chatHistory = [
        { role: 'model', content: 'Halo! Saya Asisten AI Roamie. Ada yang bisa saya bantu mengenai persyaratan sewa, tata cara pembayaran, atau kendala pemesanan mobil Anda?' }
    ];

    // Toggle Tampilan Panel Chat
    chatbotFab.addEventListener('click', () => {
        chatbotContainer.classList.toggle('active');
        if (chatbotContainer.classList.contains('active')) {
            chatbotInput.focus();
            scrollToBottom();
        }
    });

    chatbotCloseBtn.addEventListener('click', () => {
        chatbotContainer.classList.remove('active');
    });

    // Validasi input untuk mengaktifkan tombol kirim
    chatbotInput.addEventListener('input', () => {
        chatbotSendBtn.disabled = chatbotInput.value.trim() === '';
    });

    // Kirim pesan dengan Enter
    chatbotInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && chatbotInput.value.trim() !== '') {
            sendMessage();
        }
    });

    // Kirim pesan dengan tombol Kirim
    chatbotSendBtn.addEventListener('click', () => {
        if (chatbotInput.value.trim() !== '') {
            sendMessage();
        }
    });

    function scrollToBottom() {
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function addMessage(role, text) {
        const bubble = document.createElement('div');
        bubble.className = `chat-bubble chat-bubble-${role === 'user' ? 'user' : 'ai'}`;
        bubble.textContent = text;
        chatbotMessages.appendChild(bubble);
        scrollToBottom();
    }

    function addTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'typing-indicator';
        indicator.id = 'typingIndicator';
        indicator.innerHTML = `
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        `;
        chatbotMessages.appendChild(indicator);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) {
            indicator.remove();
        }
    }

    async function sendMessage() {
        const text = chatbotInput.value.trim();
        chatbotInput.value = '';
        chatbotSendBtn.disabled = true;

        // Tambah pesan user ke antarmuka dan riwayat
        addMessage('user', text);
        chatHistory.push({ role: 'user', content: text });

        // Tampilkan indikator mengetik
        addTypingIndicator();

        try {
            const response = await fetch('{{ route("chatbot.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    messages: chatHistory
                })
            });

            removeTypingIndicator();

            if (!response.ok) {
                throw new Error('Gagal berkomunikasi dengan server.');
            }

            const data = await response.json();

            if (data.success) {
                addMessage('model', data.reply);
                chatHistory.push({ role: 'model', content: data.reply });
            } else {
                addMessage('model', data.message || 'Maaf, terjadi kesalahan pada sistem.');
            }
        } catch (error) {
            removeTypingIndicator();
            console.error('Chatbot Error:', error);
            addMessage('model', 'Maaf, koneksi bermasalah. Pastikan Anda terhubung ke internet dan coba kembali.');
        }

        chatbotInput.focus();
    }
});
</script>

<script>
// GPS Geolocation Watcher Store
var gpsWatchers = {};

function toggleGpsTracking(checkbox) {
    var carId = checkbox.getAttribute('data-car-id');
    var coordsDisplay = document.getElementById('gps-coords-' + carId);
    
    if (checkbox.checked) {
        if (!navigator.geolocation) {
            Swal.fire({
                title: 'GPS Tidak Didukung',
                text: 'Browser atau perangkat Anda tidak mendukung fitur Geolocation.',
                icon: 'error',
                background: '#1e293b',
                color: '#fff'
            });
            checkbox.checked = false;
            return;
        }
        
        coordsDisplay.style.display = 'block';
        coordsDisplay.innerHTML = '<span>📡 Menghubungkan GPS...</span>';
        
        // Helper to send coordinates to API
        function sendCoords(lat, lng) {
            fetch('/api/gps/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    car_id: carId,
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(r => r.json())
            .then(data => {
                console.log('Location updated:', data);
                coordsDisplay.innerHTML = '<span>📡 GPS Aktif (' + lat.toFixed(6) + ', ' + lng.toFixed(6) + ') - Posisi terkirim</span>';
            })
            .catch(err => {
                console.error('Error posting location:', err);
            });
        }

        // Get initial position immediately
        navigator.geolocation.getCurrentPosition(
            function(position) {
                sendCoords(position.coords.latitude, position.coords.longitude);
            },
            function(error) {
                console.warn('Initial GPS query failed, fallback to watch:', error);
                if (error.code === 1) { // Permission Denied
                    Swal.fire({
                        title: 'Izin GPS Ditolak',
                        text: 'Silakan aktifkan izin lokasi di browser Anda untuk menggunakan fitur ini.',
                        icon: 'warning',
                        background: '#1e293b',
                        color: '#fff'
                    });
                    checkbox.checked = false;
                    coordsDisplay.style.display = 'none';
                }
            },
            {
                enableHighAccuracy: false,
                maximumAge: 10000,
                timeout: 20000 // Increased to 20s
            }
        );
        
        // Start watching position
        gpsWatchers[carId] = navigator.geolocation.watchPosition(
            function(position) {
                sendCoords(position.coords.latitude, position.coords.longitude);
            },
            function(error) {
                console.error('GPS watch error:', error);
                if (error.code === 1) { // Permission Denied
                    Swal.fire({
                        title: 'Izin GPS Ditolak',
                        text: 'Silakan aktifkan izin lokasi di browser Anda untuk menggunakan fitur ini.',
                        icon: 'warning',
                        background: '#1e293b',
                        color: '#fff'
                    });
                    checkbox.checked = false;
                    coordsDisplay.style.display = 'none';
                    if (gpsWatchers[carId]) {
                        navigator.geolocation.clearWatch(gpsWatchers[carId]);
                        delete gpsWatchers[carId];
                    }
                } else if (error.code === 3) {
                    // Timeout - ignore to keep UI clean and active
                    console.warn('GPS watch timeout. Retrying in background...');
                } else {
                    coordsDisplay.innerHTML = '<span style="color:var(--danger)">⚠️ Gagal mengambil GPS: ' + error.message + '</span>';
                }
            },
            {
                enableHighAccuracy: false,
                maximumAge: 10000,
                timeout: 30000 // Increased to 30s
            }
        );
    } else {
        coordsDisplay.style.display = 'none';
        if (gpsWatchers[carId]) {
            navigator.geolocation.clearWatch(gpsWatchers[carId]);
            delete gpsWatchers[carId];
        }
    }
}
</script>

<script>lucide.createIcons();</script>
</body>
</html>
