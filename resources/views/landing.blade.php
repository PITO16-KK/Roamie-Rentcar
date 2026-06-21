<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROAMIE - Sewa Mobil Pintar & Live Fleet Tracking</title>
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
            --feature-gradient: linear-gradient(180deg, #1e1b4b 0%, #0b111e 100%);
            --border: rgba(255, 255, 255, 0.05);
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
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.15), transparent 50%);
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

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 4rem 0 6rem;
            min-height: 80vh;
            gap: 2rem;
        }

        .hero-content {
            flex: 1.2;
            max-width: 580px;
        }

        .hero-tag {
            color: #a855f7;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 1.25rem;
            display: inline-block;
            background: rgba(168, 85, 247, 0.1);
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -1.5px;
        }

        .hero-title span {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .cta-button {
            background: var(--accent-gradient);
            color: white;
            text-decoration: none;
            padding: 1.1rem 2.8rem;
            border-radius: 0.85rem;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px 0 rgba(99, 102, 241, 0.4);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px 0 rgba(99, 102, 241, 0.5);
            opacity: 0.95;
        }

        /* Blob Image Container */
        .hero-image-container {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
        }

        .blob-shape {
            width: 460px;
            height: 460px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(168, 85, 247, 0.25) 100%);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blobby 12s infinite linear;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 40px rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.05);
        }

        .blob-shape img {
            width: 115%;
            height: 115%;
            object-fit: cover;
            position: absolute;
            transition: transform 0.5s ease;
        }

        .blob-shape:hover img {
            transform: scale(1.05);
        }

        @keyframes blobby {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
            25% { border-radius: 58% 42% 75% 25% / 56% 45% 55% 44%; }
            50% { border-radius: 50% 50% 33% 67% / 62% 31% 69% 38%; }
            75% { border-radius: 42% 58% 52% 48% / 33% 73% 27% 67%; }
            100% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        }

        /* Features Section */
        .features-section {
            background: var(--feature-gradient);
            padding: 6rem 0;
            border-top: 1px solid var(--border);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border);
            border-radius: 1.25rem;
            padding: 2.5rem 2rem;
            text-align: left;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(5px);
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .feature-icon {
            width: 54px;
            height: 54px;
            background: rgba(99, 102, 241, 0.12);
            border-radius: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            margin-bottom: 1.75rem;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .feature-icon i {
            width: 24px;
            height: 24px;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.85rem;
            color: var(--text-primary);
        }

        .feature-desc {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Popular Cars Section */
        .popular-cars-section {
            padding: 6rem 0;
            border-top: 1px solid var(--border);
        }

        .popular-cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
            gap: 2rem;
        }

        .car-card {
            background: rgba(30, 41, 59, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
        }

        .car-card:hover {
            transform: translateY(-8px);
            border-color: rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .car-image-container {
            width: 100%;
            height: 220px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .car-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.08);
        }

        .car-content {
            padding: 1.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .car-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.25rem;
        }

        .car-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .car-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            padding: 0.3rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .car-specs {
            display: flex;
            gap: 1.2rem;
            margin-bottom: 1.75rem;
            color: var(--text-secondary);
            font-size: 0.88rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .spec-item i {
            width: 16px;
            height: 16px;
            color: var(--accent);
        }

        .car-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .car-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: #a855f7;
        }

        .car-price span {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .rent-btn {
            background: var(--accent-gradient);
            color: white;
            text-decoration: none;
            padding: 0.75rem 1.4rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .rent-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(99, 102, 241, 0.4);
        }

        /* Contact Section */
        .contact-section {
            padding: 6rem 0;
            border-top: 1px solid var(--border);
            background: radial-gradient(circle at 100% 100%, rgba(168, 85, 247, 0.08), transparent 50%);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 4rem;
            align-items: center;
        }

        /* Footer */
        footer {
            border-top: 1px solid var(--border);
            padding: 3rem 0;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9rem;
            background: rgba(11, 17, 30, 0.5);
        }

        /* Responsive Layouts */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 3rem;
            }
            .blob-shape {
                width: 360px;
                height: 360px;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 1.5rem 0;
            }
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem 0 4rem;
                gap: 3rem;
            }
            .hero-content {
                max-width: 100%;
                margin-bottom: 1.5rem;
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .hero-title {
                font-size: 2.6rem;
            }
            .hero-subtitle {
                font-size: 1rem;
            }
            .hero-image-container {
                justify-content: center;
                width: 100%;
            }
            .blob-shape {
                width: 320px;
                height: 320px;
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
            .contact-grid {
                gap: 3rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .blob-shape {
                width: 280px;
                height: 280px;
            }
            .container {
                padding: 0 1.25rem;
            }
            .car-footer {
                flex-direction: column;
                align-items: stretch !important;
                gap: 1rem;
            }
            .car-price {
                text-align: center;
            }
            .rent-btn {
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
            <a href="#" class="logo">ROAMIE</a>
            <nav>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#features">Fitur</a></li>
                    <li><a href="#popular-cars">Armada</a></li>
                    <li><a href="#contact">Kontak</a></li>
                </ul>
            </nav>
            <div class="header-ctas" style="display:flex;gap:.75rem;align-items:center;">
                <a href="{{ route('catalog.index') }}" class="cta-header">Promo</a>
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
                <li><a href="#" class="mobile-link">Beranda</a></li>
                <li><a href="#features" class="mobile-link">Fitur</a></li>
                <li><a href="#popular-cars" class="mobile-link">Armada</a></li>
                <li><a href="#contact" class="mobile-link">Kontak</a></li>
                <li style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
                    <a href="{{ route('catalog.index') }}" class="cta-header" style="display: block; text-align: center; margin-bottom: 1rem;">Promo</a>
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

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <span class="hero-tag">Smart Car Rental & Tracking</span>
                <h1 class="hero-title">Rasakan Kebebasan Berkendara Bersama <span>ROAMIE</span></h1>
                <p class="hero-subtitle">Platform sewa mobil premium yang dilengkapi teknologi pelacakan langsung (*GPS Live Fleet Tracking*). Nikmati kenyamanan memesan armada modern kami dengan transparansi penuh, keandalan tanpa batas, dan perlindungan keamanan maksimal.</p>
                <a href="{{ route('catalog.index') }}" class="cta-button">
                    Mulai Sekarang
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                </a>
            </div>

            <div class="hero-image-container">
                <div class="blob-shape">
                    <!-- High-quality professional automotive header image from Unsplash -->
                    <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1200&q=80" alt="Mobil Sport Premium Modern">
                </div>
            </div>
        </section>
    </div>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="navigation"></i>
                    </div>
                    <h3 class="feature-title">Live GPS Tracking</h3>
                    <p class="feature-desc">Keamanan tanpa kompromi. Lacak posisi real-time mobil sewaan Anda secara instan di peta interaktif terintegrasi selama masa perjalanan.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="calendar-check"></i>
                    </div>
                    <h3 class="feature-title">Smart Booking</h3>
                    <p class="feature-desc">Pemesanan anti-bentrok. Sistem penjadwalan pintar kami memproses ketersediaan armada secara akurat demi kenyamanan rencana Anda.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="sparkles"></i>
                    </div>
                    <h3 class="feature-title">Armada Premium</h3>
                    <p class="feature-desc">Performa terbaik di kelasnya. Semua tipe armada, dari mobil listrik hingga SUV premium, dirawat berkala untuk perjalanan yang mulus.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="message-square"></i>
                    </div>
                    <h3 class="feature-title">AI Asisten 24/7</h3>
                    <p class="feature-desc">Siap siaga melayani Anda. Chatbot asisten pintar berbasis AI kami siap memberikan rekomendasi mobil dan menjawab pertanyaan Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Cars Section -->
    <section class="popular-cars-section" id="popular-cars">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: 4rem;">
                <span class="hero-tag">Pilihan Populer</span>
                <h2 class="hero-title" style="font-size: 2.5rem;">Temukan Mobil <span>Impian Anda</span></h2>
                <p class="hero-subtitle" style="max-width: 600px; margin-left: auto; margin-right: auto;">Mulai dari kenyamanan berkendara ramah lingkungan hingga performa sport mewah, pilih armada terbaik untuk perjalanan Anda.</p>
            </div>

            <div class="popular-cars-grid">
                <!-- Tesla Model S -->
                <div class="car-card">
                    <div class="car-image-container">
                        <img src="https://images.unsplash.com/photo-1619767886558-efdc259cde1a?auto=format&fit=crop&w=600&q=80" alt="Tesla Model S" class="car-image">
                    </div>
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">Tesla Model S</h3>
                            <span class="car-badge">Tersedia</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="zap"></i><span>Listrik</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Otomatis</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>5 Kursi</span></div>
                        </div>
                        <div class="car-footer">
                            <div class="car-price">Rp 1.200.000 <span>/ hari</span></div>
                            @auth
                                <a href="{{ route('catalog.index') }}" class="rent-btn">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></a>
                            @else
                                <button class="rent-btn" onclick="requireLogin()">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- BMW M4 -->
                <div class="car-card">
                    <div class="car-image-container">
                        <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=600&q=80" alt="BMW M4" class="car-image">
                    </div>
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">BMW M4 Coupe</h3>
                            <span class="car-badge">Tersedia</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="fuel"></i><span>Bensin</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Otomatis</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>4 Kursi</span></div>
                        </div>
                        <div class="car-footer">
                            <div class="car-price">Rp 1.500.000 <span>/ hari</span></div>
                            @auth
                                <a href="{{ route('catalog.index') }}" class="rent-btn">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></a>
                            @else
                                <button class="rent-btn" onclick="requireLogin()">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- G-Wagon -->
                <div class="car-card">
                    <div class="car-image-container">
                        <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=600&q=80" alt="Mercedes G-Wagon" class="car-image">
                    </div>
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">Mercedes G-Wagon</h3>
                            <span class="car-badge">Tersedia</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="fuel"></i><span>Bensin</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Otomatis</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>5 Seats</span></div>
                        </div>
                        <div class="car-footer">
                            <div class="car-price">Rp 2.500.000 <span>/ hari</span></div>
                            @auth
                                <a href="{{ route('catalog.index') }}" class="rent-btn">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></a>
                            @else
                                <button class="rent-btn" onclick="requireLogin()">Sewa Sekarang <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info">
                    <span class="hero-tag">Hubungi Kami</span>
                    <h2 class="hero-title" style="font-size: 2.5rem; text-align: left;">Mari Mulai <span>Eksplorasi Anda</span></h2>
                    <p class="hero-subtitle" style="text-align: left;">Ada pertanyaan mengenai tarif sewa, integrasi pelacak GPS, atau butuh bantuan pemesanan? Hubungi tim support kami.</p>
                    
                    <div class="info-items" style="margin-top: 2.5rem; display: flex; flex-direction: column; gap: 1.5rem;">
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 44px; height: 44px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.2);">
                                <i data-lucide="map-pin"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Lokasi Kantor</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">Jl. Teknologi No. 40, Jakarta Selatan, Indonesia</p>
                            </div>
                        </div>
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 44px; height: 44px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.2);">
                                <i data-lucide="phone"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Layanan Telepon</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">+62 21 5555 1234 (Pukul 08.00 - 20.00)</p>
                            </div>
                        </div>
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 44px; height: 44px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent); border: 1px solid rgba(99, 102, 241, 0.2);">
                                <i data-lucide="mail"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Alamat Surel</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">support@roamie.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border); padding: 2.5rem; border-radius: 1.5rem; backdrop-filter: blur(10px);">
                    <form class="contact-form" style="display: flex; flex-direction: column; gap: 1.5rem;" onsubmit="event.preventDefault(); Swal.fire({title:'Pesan Terkirim', text:'Terima kasih! Pesan Anda telah diterima oleh tim ROAMIE.', icon:'success', confirmButtonColor:'#6366f1', background:'#1e293b', color:'#fff'});">
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama lengkap Anda" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem; outline: none;">
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Email Aktif</label>
                            <input type="email" placeholder="Masukkan alamat email Anda" required style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem; outline: none;">
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Isi Pesan</label>
                            <textarea rows="4" placeholder="Tuliskan pertanyaan atau pesan Anda di sini..." required style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem; resize: none; outline: none;"></textarea>
                        </div>
                        <button type="submit" class="submit-btn" style="background: var(--accent-gradient); color: white; border: none; padding: 0.85rem; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

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

        // Require Login Popup
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
</body>
</html>
