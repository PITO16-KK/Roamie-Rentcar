<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ROAMIE') - Car Rental & Fleet Tracking</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --bg-primary: #0b111e;
            --bg-secondary: rgba(17, 24, 39, 0.7);
            --bg-card: rgba(30, 41, 59, 0.3);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #6366f1;
            --accent-gradient: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --border: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.05);
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
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            background-image: radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.15), transparent 50%);
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background-color: var(--bg-secondary);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .brand {
            padding: 2.5rem 2rem;
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-links {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-links li {
            margin-bottom: 0.75rem; /* Increased whitespace */
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.25rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-links a i {
            margin-right: 0.75rem;
            width: 18px;
            height: 18px;
            stroke-width: 2px;
        }

        .nav-links a:hover, .nav-links a.active {
            background: rgba(255, 255, 255, 0.03);
            color: var(--text-primary);
        }

        .nav-links a.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 100%);
            border-left: 3px solid var(--accent);
            border-radius: 0 0.75rem 0.75rem 0;
            color: #fff;
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 2.5rem;
            min-height: 100vh;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        header h1 {
            font-size: 1.85rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        /* Profile Admin */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-profile span {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        /* Cards & Components */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 1rem;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.1);
            background: rgba(30, 41, 59, 0.4);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                padding: 1rem 0;
            }
            .brand {
                font-size: 1rem;
                padding: 1rem;
                text-align: center;
            }
            .nav-links a span {
                display: none;
            }
            .nav-links a i {
                margin-right: 0;
            }
            .main-content {
                margin-left: 70px;
                padding: 1.5rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="sidebar">
        <div class="brand">ROAMIE</div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.cars.index') }}" class="{{ request()->routeIs('admin.cars.*') ? 'active' : '' }}">
                    <i data-lucide="car"></i>
                    <span>Mobil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments.index') }}" class="{{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    <i data-lucide="credit-card"></i>
                    <span>Verifikasi Pembayaran</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.export.rentals') }}">
                    <i data-lucide="download"></i>
                    <span>Ekspor CSV</span>
                </a>
            </li>
            <li>
                <a href="{{ route('landing') }}">
                    <i data-lucide="globe"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" style="color: #ef4444;">
                    <i data-lucide="log-out"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>@yield('page_title', 'Dashboard')</h1>
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=6366f1&color=fff&bold=true" alt="Admin" class="avatar">
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
        </header>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid var(--success); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: var(--success); font-weight: 500;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: var(--danger); font-weight: 500;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Initialize Lucide Icons & Global Functions -->
    <script>
        lucide.createIcons();
        
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#151c2c',
                color: '#f8fafc',
                iconColor: '#ef4444'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
    
    @yield('scripts')
</body>
</html>
