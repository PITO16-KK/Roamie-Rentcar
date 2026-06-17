<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROAMIE - Smart Car Rental & Fleet Tracking</title>
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
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
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        nav a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
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

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5rem 0;
            min-height: 80vh;
        }

        .hero-content {
            flex: 1;
            max-width: 550px;
        }

        .hero-tag {
            color: #a855f7;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            display: block;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero-title span {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtitle {
            color: var(--text-secondary);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2.5rem;
        }

        .cta-button {
            background: var(--accent-gradient);
            color: white;
            text-decoration: none;
            padding: 1rem 2.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(99, 102, 241, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(99, 102, 241, 0.4);
        }

        /* Blob Image Container */
        .hero-image-container {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            position: relative;
        }

        .blob-shape {
            width: 450px;
            height: 450px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(168, 85, 247, 0.2) 100%);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blobby 10s infinite linear;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .blob-shape img {
            width: 120%;
            height: 120%;
            object-fit: cover;
            position: absolute;
            top: -10%;
            left: -10%;
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
            padding: 5rem 0;
            border-top: 1px solid var(--border);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 2rem;
            text-align: left;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-desc {
            color: var(--text-secondary);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 3rem 0;
            }
            .hero-content {
                max-width: 100%;
                margin-bottom: 3rem;
            }
            .hero-image-container {
                justify-content: center;
            }
            .blob-shape {
                width: 300px;
                height: 300px;
            }
            nav {
                display: none;
            }
        }

        /* Popular Cars Section */
        .popular-cars-section {
            padding: 5rem 0;
            border-top: 1px solid var(--border);
        }

        .popular-cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .car-card {
            background: rgba(30, 41, 59, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
        }

        .car-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .car-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .car-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .car-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .car-badge {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .car-specs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .spec-item i {
            width: 14px;
            height: 14px;
            color: var(--accent);
        }

        .car-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .car-price {
            font-size: 1.2rem;
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
            padding: 0.6rem 1.2rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: none;
            cursor: pointer;
        }

        .rent-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Contact Section */
        .contact-section {
            padding: 5rem 0;
            border-top: 1px solid var(--border);
            background: radial-gradient(circle at 100% 100%, rgba(168, 85, 247, 0.1), transparent 50%);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 4rem;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">ROAMIE</div>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#popular-cars">Armada</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
            <div style="display:flex;gap:.75rem;align-items:center;">
                <a href="{{ route('catalog.index') }}" class="cta-header">Katalog</a>
                @auth
                    @if(auth()->user()->role==='admin')
                        <a href="{{ route('admin.dashboard') }}" class="cta-header">Dashboard</a>
                    @else
                        <a href="{{ route('profile') }}" class="cta-header">Profil Saya</a>
                    @endif
                    <a href="{{ route('logout') }}" style="color:#ef4444;font-size:.85rem;font-weight:600;text-decoration:none;">Keluar</a>
                @else
                    <a href="{{ route('login') }}" class="cta-header">Masuk</a>
                @endauth
            </div>
        </header>

        <section class="hero">
            <div class="hero-content">
                <span class="hero-tag">Smart Car Rental</span>
                <h1 class="hero-title">Drive the Future with <span>ROAMIE</span></h1>
                <p class="hero-subtitle">Sistem penyewaan mobil spesifik dan pelacakan armada nyata (fleet tracking) terintegrasi. Kelola armada Anda dengan teknologi terkini.</p>
                <a href="{{ route('catalog.index') }}" class="cta-button">
                    Mulai Sekarang
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
                </a>
            </div>

            <div class="hero-image-container">
                <div class="blob-shape">
                    <!-- Image rendered from public/images/landing_hero.png -->
                    <img src="{{ asset('images/landing_hero.png') }}" alt="Futuristic Car">
                </div>
            </div>
        </section>
    </div>

    <section class="features-section" id="features">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="navigation"></i>
                    </div>
                    <h3 class="feature-title">Live Tracking</h3>
                    <p class="feature-desc">Lacak posisi armada mobil Anda secara real-time dengan peta interaktif presisi tinggi.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="calendar-check"></i>
                    </div>
                    <h3 class="feature-title">Smart Booking</h3>
                    <p class="feature-desc">Sistem ketersediaan pintar mencegah double booking untuk periode tanggal yang sama.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="database"></i>
                    </div>
                    <h3 class="feature-title">Fleet Management</h3>
                    <p class="feature-desc">Kelola data mobil, harga sewa, dan status ketersediaan dengan mudah dan cepat.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="bar-chart-3"></i>
                    </div>
                    <h3 class="feature-title">Live Analytics</h3>
                    <p class="feature-desc">Dapatkan statistik harian, mingguan, dan bulanan performa rental armada Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Cars Section -->
    <section class="popular-cars-section" id="popular-cars">
        <div class="container">
            <div class="section-header" style="text-align: center; margin-bottom: 4rem;">
                <span class="hero-tag">Armada</span>
                <h2 class="hero-title" style="font-size: 2.5rem;">Katalog Mobil <span>Populer</span></h2>
                <p class="hero-subtitle" style="max-width: 600px; margin-left: auto; margin-right: auto;">Pilih mobil terbaik untuk perjalanan Anda. Semua armada dalam kondisi prima dan siap jalan.</p>
            </div>

            <div class="popular-cars-grid">
                <!-- Tesla Model S -->
                <div class="car-card">
                    <img src="https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=600&q=80" alt="Tesla Model S" class="car-image">
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">Tesla Model S</h3>
                            <span class="car-badge">Ready</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="fuel"></i><span>Electric</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Auto</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>5 Seats</span></div>
                        </div>
                        <div class="car-footer">
                            <button class="rent-btn" style="width: 100%; justify-content: center;" onclick="requireLogin()">Lihat Selengkapnya <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                        </div>
                    </div>
                </div>

                <!-- BMW M4 -->
                <div class="car-card">
                    <img src="https://images.unsplash.com/photo-1611245831313-097781f2a32c?auto=format&fit=crop&w=600&q=80" alt="BMW M4" class="car-image">
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">BMW M4</h3>
                            <span class="car-badge">Ready</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="fuel"></i><span>Bensin</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Auto</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>4 Seats</span></div>
                        </div>
                        <div class="car-footer">
                            <button class="rent-btn" style="width: 100%; justify-content: center;" onclick="requireLogin()">Lihat Selengkapnya <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
                        </div>
                    </div>
                </div>

                <!-- G-Wagon -->
                <div class="car-card">
                    <img src="https://images.unsplash.com/photo-1520031447452-4504f8425509?auto=format&fit=crop&w=600&q=80" alt="G-Wagon" class="car-image">
                    <div class="car-content">
                        <div class="car-header">
                            <h3 class="car-title">Mercedes G-Wagon</h3>
                            <span class="car-badge">Ready</span>
                        </div>
                        <div class="car-specs">
                            <div class="spec-item"><i data-lucide="fuel"></i><span>Bensin</span></div>
                            <div class="spec-item"><i data-lucide="settings"></i><span>Auto</span></div>
                            <div class="spec-item"><i data-lucide="users"></i><span>5 Seats</span></div>
                        </div>
                        <div class="car-footer">
                            <button class="rent-btn" style="width: 100%; justify-content: center;" onclick="requireLogin()">Lihat Selengkapnya <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i></button>
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
                    <span class="hero-tag">Contact</span>
                    <h2 class="hero-title" style="font-size: 2.5rem; text-align: left;">Ayo Mulai <span>Bicara</span></h2>
                    <p class="hero-subtitle" style="text-align: left;">Ada pertanyaan atau butuh demo langsung? Hubungi tim kami sekarang.</p>
                    
                    <div class="info-items" style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 40px; height: 40px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                                <i data-lucide="map-pin"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Alamat</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">Jl. Teknologi No. 40, Jakarta Selatan</p>
                            </div>
                        </div>
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 40px; height: 40px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                                <i data-lucide="phone"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Telepon</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">+62 21 5555 1234</p>
                            </div>
                        </div>
                        <div class="info-item" style="display: flex; gap: 1rem; align-items: center;">
                            <div style="width: 40px; height: 40px; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: var(--accent);">
                                <i data-lucide="mail"></i>
                            </div>
                            <div>
                                <h4 style="font-size: 1rem; font-weight: 700;">Email</h4>
                                <p style="color: var(--text-secondary); font-size: 0.9rem;">info@roamie.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-wrapper" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--border); padding: 2.5rem; border-radius: 1.5rem; backdrop-filter: blur(10px);">
                    <form class="contact-form" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama Anda" style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem;">
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Email</label>
                            <input type="email" placeholder="Masukkan email Anda" style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem;">
                        </div>
                        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <label style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;">Pesan</label>
                            <textarea rows="4" placeholder="Tuliskan pesan Anda di sini..." style="width: 100%; padding: 0.75rem 1rem; background: rgba(30, 41, 59, 0.5); border: 1px solid var(--glass-border); border-radius: 0.5rem; color: var(--text-primary); font-size: 0.95rem; resize: none;"></textarea>
                        </div>
                        <button type="submit" class="submit-btn" style="background: var(--accent-gradient); color: white; border: none; padding: 0.75rem; border-radius: 0.5rem; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease;">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        function requireLogin() {
            Swal.fire({
                title: 'Silakan Masuk',
                text: 'Anda perlu masuk (login) terlebih dahulu untuk melihat detail mobil.',
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
