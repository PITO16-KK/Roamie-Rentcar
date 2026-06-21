<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo & Penawaran Eksklusif - ROAMIE</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bg-primary: #0b111e;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #6366f1;
            --accent-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --border: rgba(255, 255, 255, 0.05);
            --glass: rgba(30, 41, 59, 0.3);
            --glass-border: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.1), transparent 50%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border);
            position: relative;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2.5rem;
        }

        nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--text-primary);
        }

        .cta-header {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border);
            padding: 0.6rem 1.5rem;
            border-radius: 2rem;
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .cta-header:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.1);
        }

        /* Mobile Menu Styles */
        .mobile-menu-btn {
            display: none;
            background: transparent;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 0.5rem;
            z-index: 1001;
        }

        .mobile-menu-btn i {
            width: 28px;
            height: 28px;
        }

        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 380px;
            height: 100vh;
            background: rgba(11, 17, 30, 0.98);
            backdrop-filter: blur(20px);
            border-left: 1px solid var(--border);
            z-index: 1000;
            padding: 6rem 2.5rem 2.5rem;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .mobile-nav-overlay.active {
            right: 0;
        }

        .mobile-close-btn {
            position: absolute;
            top: 2rem;
            right: 2rem;
            background: transparent;
            border: none;
            color: var(--text-secondary);
            font-size: 2.2rem;
            cursor: pointer;
            line-height: 1;
            transition: color 0.3s;
        }

        .mobile-close-btn:hover {
            color: var(--text-primary);
        }

        .mobile-nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
        }

        .mobile-link {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 600;
            transition: color 0.3s;
        }

        .mobile-link:hover {
            color: var(--accent);
        }

        /* Promo Section */
        .promo-container {
            padding: 4rem 0 6rem;
        }

        .page-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -1.5px;
        }

        .page-title span {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-subtitle {
            color: var(--text-secondary);
            margin-bottom: 3rem;
            font-size: 1.1rem;
            line-height: 1.6;
            max-width: 600px;
        }

        /* Mega Promo Hero Banner */
        .mega-banner {
            background: linear-gradient(rgba(11, 17, 30, 0.65), rgba(11, 17, 30, 0.9)), url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 4rem 3rem;
            margin-bottom: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .badge-seasonal {
            background: rgba(168, 85, 247, 0.15);
            color: #c084fc;
            padding: 0.4rem 1.1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            align-self: flex-start;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }

        .mega-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .mega-desc {
            color: var(--text-secondary);
            font-size: 1.05rem;
            line-height: 1.6;
            max-width: 650px;
            margin-bottom: 2rem;
        }

        .promo-claim-action {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .promo-code-box {
            background: rgba(255, 255, 255, 0.05);
            border: 1px dashed rgba(99, 102, 241, 0.5);
            padding: 0.8rem 1.5rem;
            border-radius: 0.75rem;
            font-family: 'Courier New', Courier, monospace;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-primary);
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-copy-code {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 0.9rem 1.8rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-copy-code:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
        }

        /* Active Promos Grid */
        .section-header {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .section-title i {
            color: var(--accent);
        }

        .promos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 2rem;
        }

        .promo-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }

        .promo-card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .promo-image-container {
            width: 100%;
            height: 190px;
            overflow: hidden;
            border-bottom: 1px solid var(--glass-border);
            position: relative;
        }

        .promo-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .promo-card:hover .promo-image {
            transform: scale(1.06);
        }

        .promo-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background: var(--accent-gradient);
            color: white;
            padding: 0.35rem 0.9rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.3);
        }

        .promo-content {
            padding: 1.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .promo-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.6rem;
        }

        .promo-card-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex: 1;
        }

        .promo-card-footer {
            border-top: 1px solid var(--glass-border);
            padding-top: 1.25rem;
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .promo-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.2rem;
        }

        .promo-code-value {
            font-family: monospace;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--accent);
            letter-spacing: 1px;
        }

        .btn-card-copy {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-card-copy:hover {
            background: rgba(99, 102, 241, 0.1);
            border-color: rgba(99, 102, 241, 0.3);
            color: white;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 3rem 0;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            background: rgba(11, 17, 30, 0.5);
            margin-top: 6rem;
        }

        /* Responsive Layouts */
        @media (max-width: 992px) {
            .mega-title {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1.5rem 0;
            }
            .page-title {
                font-size: 2.2rem;
            }
            .page-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            .mega-banner {
                padding: 3rem 2rem;
            }
            .mega-title {
                font-size: 1.8rem;
            }
            .mega-desc {
                font-size: 0.95rem;
            }
            nav {
                display: none;
            }
            .header-ctas {
                display: none !important;
            }
            .mobile-menu-btn {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .mega-banner {
                padding: 2.5rem 1.5rem;
            }
            .promo-claim-action {
                flex-direction: column;
                align-items: stretch;
            }
            .promo-code-box {
                justify-content: center;
            }
            .btn-copy-code {
                justify-content: center;
            }
            .container {
                padding: 0 1.25rem;
            }
            .promo-card-footer {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }
            .promo-card-footer .car-price {
                text-align: center;
            }
            .promo-card-footer button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Navigation Header -->
        <header>
            <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
            <nav>
                <ul>
                    <li><a href="{{ route('landing') }}">Beranda</a></li>
                    <li><a href="{{ route('landing') }}#features">Fitur</a></li>
                    <li><a href="{{ route('landing') }}#popular-cars">Armada</a></li>
                    <li><a href="{{ route('landing') }}#contact">Kontak</a></li>
                </ul>
            </nav>
            <div class="header-ctas" style="display:flex;gap:.75rem;align-items:center;">
                <a href="{{ route('catalog.index') }}" class="cta-header" style="border-color: var(--accent); color: white;">Promo</a>
                @auth
                    @if(auth()->user()->role==='admin')
                        <a href="{{ route('admin.dashboard') }}" class="cta-header">Dashboard</a>
                    @else
                        <a href="{{ route('profile') }}" class="cta-header">Profil Saya</a>
                    @endif
                    <a href="{{ route('logout') }}" style="color:#ef4444;font-size:.85rem;font-weight:600;text-decoration:none;margin-left:0.5rem;">Keluar</a>
                @else
                    <a href="{{ route('login') }}" class="cta-header">Masuk</a>
                @endauth
            </div>
            
            <button class="mobile-menu-btn" id="menuToggleBtn" aria-label="Buka Menu">
                <i data-lucide="menu"></i>
            </button>
        </header>

        <!-- Mobile Navigation Drawer -->
        <div class="mobile-nav-overlay" id="mobileNav">
            <button class="mobile-close-btn" id="closeMenuBtn" aria-label="Tutup Menu">&times;</button>
            <ul class="mobile-nav-links">
                <li><a href="{{ route('landing') }}" class="mobile-link">Beranda</a></li>
                <li><a href="{{ route('landing') }}#features" class="mobile-link">Fitur</a></li>
                <li><a href="{{ route('landing') }}#popular-cars" class="mobile-link">Armada</a></li>
                <li><a href="{{ route('landing') }}#contact" class="mobile-link">Kontak</a></li>
                <li style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <a href="{{ route('catalog.index') }}" class="cta-header" style="display: block; text-align: center; margin-bottom: 1rem; border-color: var(--accent); color: white;">Promo</a>
                    @auth
                        @if(auth()->user()->role==='admin')
                            <a href="{{ route('admin.dashboard') }}" class="cta-header" style="display: block; text-align: center; margin-bottom: 1rem;">Dashboard</a>
                        @else
                            <a href="{{ route('profile') }}" class="cta-header" style="display: block; text-align: center; margin-bottom: 1rem;">Profil Saya</a>
                        @endif
                        <a href="{{ route('logout') }}" style="color:#ef4444;font-size:1rem;font-weight:600;text-decoration:none;display:block;text-align:center;margin-top:1.5rem;">Keluar</a>
                    @else
                        <a href="{{ route('login') }}" class="cta-header" style="display: block; text-align: center;">Masuk</a>
                    @endauth
                </li>
            </ul>
        </div>

        <!-- Promo Content Container -->
        <div class="promo-container">
            <h1 class="page-title">Katalog Armada & <span>Promo Spesial</span></h1>
            <p class="page-subtitle">Temukan armada mobil premium terbaik yang tersedia untuk disewa, lengkapi rencana perjalanan Anda dengan teknologi live tracking kami.</p>

            <!-- Seasonal Mega Banner -->
            <div class="mega-banner">
                <span class="badge-seasonal">Promo Terbatas - Musim Liburan</span>
                <h2 class="mega-title">Mega Liburan Akhir Tahun:<br>Diskon Flat 30% Semua Armada</h2>
                <p class="mega-desc">Rencanakan petualangan luar kota Anda sekarang. Diskon berlaku untuk penyewaan semua armada (termasuk mobil SUV premium dan sport) dengan durasi sewa di atas 5 hari.</p>
                <div class="promo-claim-action">
                    <div class="promo-code-box">
                        <span>ROAMIEHOLIDAY</span>
                    </div>
                    <button class="btn-copy-code" onclick="copyPromoCode('ROAMIEHOLIDAY')">
                        <i data-lucide="copy" style="width: 16px; height: 16px;"></i> Salin Kode Promo
                    </button>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="search-filter-container" style="background: var(--glass); border: 1px solid var(--glass-border); padding: 1.5rem; border-radius: 1.25rem; margin-bottom: 3rem; backdrop-filter: blur(10px);">
                <form action="{{ route('catalog.index') }}" method="GET" style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
                    <div style="flex: 1; min-width: 250px; position: relative;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mobil..." style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.8rem; background: rgba(11, 17, 30, 0.6); border: 1px solid var(--border); border-radius: 0.75rem; color: var(--text-primary); font-size: 0.95rem; outline: none; transition: border-color 0.3s; border-color: var(--border);">
                        <i data-lucide="search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); width: 18px; height: 18px; color: var(--text-secondary);"></i>
                    </div>
                    <div style="width: 200px; min-width: 150px; position: relative;">
                        <select name="type" style="width: 100%; padding: 0.8rem 1rem; background: rgba(11, 17, 30, 0.6); border: 1px solid var(--border); border-radius: 0.75rem; color: var(--text-primary); font-size: 0.95rem; outline: none; cursor: pointer; appearance: none; transition: border-color 0.3s; border-color: var(--border);">
                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua Tipe</option>
                            <option value="SUV" {{ request('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                            <option value="Sedan" {{ request('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="MPV" {{ request('type') == 'MPV' ? 'selected' : '' }}>MPV</option>
                            <option value="EV" {{ request('type') == 'EV' ? 'selected' : '' }}>EV (Listrik)</option>
                        </select>
                        <i data-lucide="chevron-down" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: var(--text-secondary); pointer-events: none;"></i>
                    </div>
                    <button type="submit" style="background: var(--accent-gradient); color: white; border: none; padding: 0.8rem 1.8rem; border-radius: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="filter" style="width: 16px; height: 16px;"></i> Filter
                    </button>
                    @if(request('search') || request('type'))
                        <a href="{{ route('catalog.index') }}" style="color: var(--text-secondary); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: color 0.3s; margin-left: 0.5rem;" onmouseover="this.style.color='#f8fafc'" onmouseout="this.style.color='var(--text-secondary)'">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Available Cars Section -->
            <div class="section-header" style="margin-bottom: 2rem;">
                <h3 class="section-title">
                    <i data-lucide="car"></i> Daftar Armada Tersedia
                </h3>
            </div>

            <div class="promos-grid" style="margin-bottom: 5rem;">
                @forelse($cars as $car)
                    @php
                        // Fallback image URLs
                        $fallbackImages = [
                            'EV' => 'https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=600&q=80',
                            'SUV' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80',
                            'Sedan' => 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80',
                            'MPV' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80',
                        ];
                        $imagePath = $car->image ? asset('car-images/' . $car->image) : ($fallbackImages[strtoupper($car->type)] ?? 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=600&q=80');
                    @endphp
                    <div class="promo-card">
                        <div class="promo-image-container" style="height: 220px;">
                            <img src="{{ $imagePath }}" alt="{{ $car->name }}" class="promo-image">
                            <span class="promo-badge" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.25); box-shadow: none;">Tersedia</span>
                        </div>
                        <div class="promo-content">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <h4 class="promo-card-title" style="margin-bottom: 0;">{{ $car->name }}</h4>
                            </div>
                            <div style="margin-bottom: 1.25rem;">
                                <code style="font-family: monospace; font-weight: 700; background: rgba(255, 255, 255, 0.05); padding: 0.2rem 0.5rem; border-radius: 0.35rem; border: 1px solid rgba(255, 255, 255, 0.05); font-size: 0.8rem; color: var(--accent);">
                                    {{ $car->plate_number ?? $car->plat_nomor ?? '-' }}
                                </code>
                            </div>
                            
                            <p class="promo-card-desc" style="margin-bottom: 1.5rem; font-size: 0.85rem;">{{ $car->description ?? 'Nikmati kenyamanan berkendara premium dengan performa prima dan kondisi unit yang bersih dan terawat.' }}</p>
                            
                            <div class="car-specs" style="display: flex; gap: 1rem; margin-bottom: 1.5rem; color: var(--text-secondary); font-size: 0.8rem; border-top: 1px solid var(--glass-border); padding-top: 1rem;">
                                <div class="spec-item" style="display: flex; align-items: center; gap: 0.3rem;">
                                    <i data-lucide="settings" style="width: 14px; height: 14px; color: var(--accent);"></i>
                                    <span>{{ $car->gearbox ?? 'Otomatis' }}</span>
                                </div>
                                <div class="spec-item" style="display: flex; align-items: center; gap: 0.3rem;">
                                    <i data-lucide="users" style="width: 14px; height: 14px; color: var(--accent);"></i>
                                    <span>{{ $car->seats ?? 5 }} Kursi</span>
                                </div>
                                <div class="spec-item" style="display: flex; align-items: center; gap: 0.3rem;">
                                    <i data-lucide="fuel" style="width: 14px; height: 14px; color: var(--accent);"></i>
                                    <span>{{ $car->engine ?? 'Bensin' }}</span>
                                </div>
                            </div>
                            
                            <div class="promo-card-footer" style="border: none; padding-top: 0; margin-top: 0;">
                                <div class="car-price" style="font-size: 1.25rem; font-weight: 800; color: #a855f7;">
                                    Rp {{ number_format($car->rental_price, 0, ',', '.') }} <span style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 500;">/ hari</span>
                                </div>
                                @auth
                                    <button class="btn-copy-code" style="padding: 0.6rem 1.2rem; border-radius: 0.6rem; font-size: 0.85rem;" onclick="openBookingModal({{ json_encode($car) }})">
                                        Sewa <i data-lucide="arrow-right" style="width: 14px; height: 14px; margin-left: 0.25rem;"></i>
                                    </button>
                                @else
                                    <button class="btn-copy-code" style="padding: 0.6rem 1.2rem; border-radius: 0.6rem; font-size: 0.85rem;" onclick="requireLogin()">
                                        Sewa <i data-lucide="arrow-right" style="width: 14px; height: 14px; margin-left: 0.25rem;"></i>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: var(--glass); border: 1px dashed var(--border); border-radius: 1.25rem; backdrop-filter: blur(10px);">
                        <i data-lucide="car-front" style="width: 48px; height: 48px; color: var(--text-secondary); margin-bottom: 1rem; opacity: 0.5; display: inline-block;"></i>
                        <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Tidak Ada Armada</h4>
                        <p style="color: var(--text-secondary); font-size: 0.9rem;">Maaf, tidak ada mobil dengan status tersedia yang cocok dengan pencarian Anda saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Active Promos Section -->
            <div class="section-header" style="margin-bottom: 2rem;">
                <h3 class="section-title">
                    <i data-lucide="tags"></i> Promo Aktif Bulan Ini
                </h3>
            </div>

            <div class="promos-grid">
                <!-- Promo 1: Harian -->
                <div class="promo-card">
                    <div class="promo-image-container">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80" alt="Rental Mobil Harian" class="promo-image">
                        <span class="promo-badge">Diskon 15%</span>
                    </div>
                    <div class="promo-content">
                        <h4 class="promo-card-title">Hemat Rental Mingguan</h4>
                        <p class="promo-card-desc">Sewa minimal selama 3 hari untuk keperluan dinas atau liburan keluarga, dan nikmati potongan flat sebesar 15% untuk semua jenis sedan dan MPV.</p>
                        <div class="promo-card-footer">
                            <div>
                                <div class="promo-label">Kode Promo</div>
                                <div class="promo-code-value">ROAMIEHEMAT</div>
                            </div>
                            <button class="btn-card-copy" onclick="copyPromoCode('ROAMIEHEMAT')">
                                <i data-lucide="copy" style="width: 13px; height: 13px;"></i> Salin
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Promo 2: Member -->
                <div class="promo-card">
                    <div class="promo-image-container">
                        <img src="https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=600&q=80" alt="Member Baru Roamie" class="promo-image">
                        <span class="promo-badge">Cashback Rp 150k</span>
                    </div>
                    <div class="promo-content">
                        <h4 class="promo-card-title">Welcome Member Baru</h4>
                        <p class="promo-card-desc">Daftarkan diri Anda hari ini dan dapatkan saldo cashback langsung senilai Rp 150.000 untuk transaksi penyewaan armada pertama Anda.</p>
                        <div class="promo-card-footer">
                            <div>
                                <div class="promo-label">Kode Promo</div>
                                <div class="promo-code-value">ROAMIEMEMBER</div>
                            </div>
                            <button class="btn-card-copy" onclick="copyPromoCode('ROAMIEMEMBER')">
                                <i data-lucide="copy" style="width: 13px; height: 13px;"></i> Salin
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Promo 3: EV Special -->
                <div class="promo-card">
                    <div class="promo-image-container">
                        <img src="https://images.unsplash.com/photo-1563720223185-11003d516935?auto=format&fit=crop&w=600&q=80" alt="Mobil Listrik EV Premium" class="promo-image">
                        <span class="promo-badge">Potongan 20%</span>
                    </div>
                    <div class="promo-content">
                        <h4 class="promo-card-title">Green Eco-Friendly Promo</h4>
                        <p class="promo-card-desc">Ikut serta dalam aksi pelestarian lingkungan dengan menyewa armada bertenaga listrik penuh (EV) premium dan dapatkan diskon khusus 20%.</p>
                        <div class="promo-card-footer">
                            <div>
                                <div class="promo-label">Kode Promo</div>
                                <div class="promo-code-value">ROAMIEEV</div>
                            </div>
                            <button class="btn-card-copy" onclick="copyPromoCode('ROAMIEEV')">
                                <i data-lucide="copy" style="width: 13px; height: 13px;"></i> Salin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(11, 17, 30, 0.8); backdrop-filter: blur(8px); display: none; justify-content: center; align-items: center; z-index: 2000; padding: 1rem;">
        <div class="modal-content" style="background: rgba(30, 41, 59, 0.85); border: 1px solid var(--glass-border); border-radius: 1.5rem; width: 100%; max-width: 500px; padding: 2rem; box-shadow: 0 20px 50px rgba(0,0,0,0.5); backdrop-filter: blur(20px); position: relative; animation: modalFadeIn 0.3s ease;">
            <button onclick="closeBookingModal()" style="position: absolute; top: 1.25rem; right: 1.25rem; background: transparent; border: none; color: var(--text-secondary); font-size: 1.8rem; cursor: pointer; line-height: 1; transition: color 0.3s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='var(--text-secondary)'">&times;</button>
            
            <div style="margin-bottom: 1.5rem; text-align: left;">
                <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; color: var(--accent); font-weight: 700;">Formulir Pemesanan</span>
                <h3 id="modalCarName" style="font-size: 1.6rem; font-weight: 800; margin-top: 0.25rem; color: var(--text-primary);">Nama Mobil</h3>
                <p id="modalCarSpecs" style="font-size: 0.85rem; color: var(--text-secondary); margin-top: 0.25rem;">Spesifikasi Mobil</p>
            </div>

            <form id="bookingForm" action="" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                @csrf
                <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem; text-align: left;">
                    <label style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600;">Tanggal Mulai Sewa</label>
                    <input type="date" name="start_date" id="bookingStartDate" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(11, 17, 30, 0.6); border: 1px solid var(--border); border-radius: 0.75rem; color: var(--text-primary); font-size: 0.95rem; outline: none; transition: border-color 0.3s; border-color: var(--border);" onchange="calculateTotalPrice()">
                </div>
                
                <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem; text-align: left;">
                    <label style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600;">Durasi Sewa (Hari)</label>
                    <input type="number" name="duration_days" id="bookingDuration" value="1" min="1" max="30" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(11, 17, 30, 0.6); border: 1px solid var(--border); border-radius: 0.75rem; color: var(--text-primary); font-size: 0.95rem; outline: none; transition: border-color 0.3s; border-color: var(--border);" oninput="calculateTotalPrice()">
                </div>

                <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border); border-radius: 0.85rem; padding: 1.25rem; display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                    <div style="text-align: left;">
                        <span style="font-size: 0.78rem; color: var(--text-secondary); display: block;">Total Pembayaran</span>
                        <span id="modalTotalPriceDisplay" style="font-size: 1.4rem; font-weight: 800; color: #a855f7;">Rp 0</span>
                    </div>
                    <div style="text-align: right;">
                        <span id="modalPricePerDay" style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 500;">Rp 0 / hari</span>
                    </div>
                </div>

                <button type="submit" style="background: var(--accent-gradient); color: white; border: none; padding: 0.9rem; border-radius: 0.75rem; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 0.5rem;">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i> Konfirmasi Pemesanan
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-overlay {
            transition: opacity 0.3s ease;
        }
    </style>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 ROAMIE Car Rental & Fleet Tracking. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Mobile Navigation Toggle Logic
        const menuToggleBtn = document.getElementById('menuToggleBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const mobileNav = document.getElementById('mobileNav');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        function openMenu() {
            mobileNav.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            mobileNav.classList.remove('active');
            document.body.style.overflow = '';
        }

        menuToggleBtn.addEventListener('click', openMenu);
        closeMenuBtn.addEventListener('click', closeMenu);

        mobileLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Click outside drawer to close
        document.addEventListener('click', function(event) {
            const isClickInsideMenu = mobileNav.contains(event.target);
            const isClickToggleBtn = menuToggleBtn.contains(event.target);
            if (!isClickInsideMenu && !isClickToggleBtn && mobileNav.classList.contains('active')) {
                closeMenu();
            }
        });

        // Copy Promo Code function
        function copyPromoCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                Swal.fire({
                    title: 'Disalin!',
                    text: 'Kode promo "' + code + '" berhasil disalin ke papan klip.',
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500,
                    background: '#1e293b',
                    color: '#fff',
                    iconColor: '#6366f1'
                });
            }).catch(() => {
                Swal.fire({
                    title: 'Gagal Menyalin',
                    text: 'Silakan salin secara manual: ' + code,
                    icon: 'error',
                    confirmButtonColor: '#6366f1',
                    background: '#1e293b',
                    color: '#fff'
                });
            });
        }

        // Active Car Price variable for booking modal
        var activeCarPrice = 0;

        // Open Booking Modal function
        function openBookingModal(car) {
            document.getElementById('modalCarName').innerText = car.name;
            document.getElementById('modalCarSpecs').innerHTML = car.type + ' &bull; ' + (car.gearbox || 'Otomatis') + ' &bull; ' + (car.seats || 5) + ' Kursi';
            document.getElementById('modalPricePerDay').innerText = 'Rp ' + formatIDR(car.rental_price) + ' / hari';
            
            // Set action URL dynamically
            var actionUrl = "{{ route('booking.book', ':id') }}".replace(':id', car.id);
            document.getElementById('bookingForm').action = actionUrl;
            
            activeCarPrice = parseFloat(car.rental_price);
            
            // Set min date to today
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('bookingStartDate').min = today;
            document.getElementById('bookingStartDate').value = today;
            document.getElementById('bookingDuration').value = 1;
            
            calculateTotalPrice();
            
            var modal = document.getElementById('bookingModal');
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Close Booking Modal function
        function closeBookingModal() {
            var modal = document.getElementById('bookingModal');
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }

        // Calculate Total Price function
        function calculateTotalPrice() {
            var durationInput = document.getElementById('bookingDuration');
            var duration = parseInt(durationInput.value) || 1;
            if (duration < 1) duration = 1;
            if (duration > 30) duration = 30;
            durationInput.value = duration;
            
            var total = activeCarPrice * duration;
            document.getElementById('modalTotalPriceDisplay').innerText = 'Rp ' + formatIDR(total);
        }

        // Format IDR function
        function formatIDR(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }

        // Close modal on click outside modal container
        document.getElementById('bookingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBookingModal();
            }
        });

        // Require Login Modal function
        function requireLogin() {
            Swal.fire({
                title: 'Silakan Masuk',
                text: 'Anda perlu masuk (login) terlebih dahulu untuk mulai memesan mobil.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ke Halaman Login',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#fff',
                iconColor: '#6366f1'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#6366f1',
                    background: '#1e293b',
                    color: '#fff'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#6366f1',
                    background: '#1e293b',
                    color: '#fff'
                });
            });
        </script>
    @endif
</body>
</html>
