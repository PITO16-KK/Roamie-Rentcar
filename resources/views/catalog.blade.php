<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Mobil - ROAMIE</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

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

        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--text-primary);
        }

        /* Catalog Section */
        .catalog-container {
            padding: 3rem 0;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            letter-spacing: -1px;
        }

        .page-subtitle {
            color: var(--text-secondary);
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        /* Filter & Search Bar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            width: 18px;
            height: 18px;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 0.75rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(30, 41, 59, 0.5);
        }

        .filters {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.6rem 1.2rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 2rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            backdrop-filter: blur(10px);
        }

        .filter-btn:hover, .filter-btn.active {
            background: var(--accent-gradient);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Grid Layout */
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        /* Card Design */
        .car-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
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
            border-bottom: 1px solid var(--glass-border);
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
            border-top: 1px solid var(--glass-border);
        }

        .car-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: #a855f7; /* Neon purple */
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

        .empty-state{text-align:center;padding:4rem 0;color:var(--text-secondary);}
        .empty-state i{width:48px;height:48px;color:var(--accent);margin-bottom:1rem;opacity:.5;}

        /* Booking Modal */
        .modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:200;backdrop-filter:blur(4px);align-items:center;justify-content:center;}
        .modal-overlay.open{display:flex;}
        .modal{background:#0f172a;border:1px solid rgba(255,255,255,.08);border-radius:1.5rem;padding:2rem;width:100%;max-width:440px;position:relative;}
        .modal-title{font-size:1.2rem;font-weight:700;margin-bottom:.3rem;}
        .modal-sub{color:var(--text-secondary);font-size:.85rem;margin-bottom:1.5rem;}
        .modal-close{position:absolute;top:1rem;right:1rem;background:transparent;border:none;color:var(--text-secondary);cursor:pointer;font-size:1.2rem;}
        .modal-form-group{margin-bottom:1.1rem;}
        .modal-label{display:block;font-size:.8rem;color:var(--text-secondary);margin-bottom:.4rem;font-weight:500;}
        .modal-input{width:100%;padding:.7rem 1rem;background:rgba(30,41,59,.6);border:1px solid rgba(255,255,255,.07);border-radius:.75rem;color:var(--text-primary);font-size:.9rem;}
        .modal-input:focus{outline:none;border-color:var(--accent);}
        .modal-car-info{background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.15);border-radius:.875rem;padding:.9rem 1rem;margin-bottom:1.25rem;font-size:.85rem;}
        .modal-car-name{font-weight:700;font-size:1rem;margin-bottom:.2rem;}
        .btn-book-submit{width:100%;background:var(--accent-gradient);color:#fff;border:none;padding:.8rem;border-radius:.875rem;font-weight:700;font-size:.95rem;cursor:pointer;margin-top:.5rem;}
    </style>
</head>
<body>
    <div class="container">
        <header>
            <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
            <ul class="nav-links">
                <li><a href="{{ route('landing') }}">Home</a></li>
                <li><a href="{{ route('catalog.index') }}">Katalog</a></li>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                    @else
                        <li><a href="{{ route('profile') }}">Profil Saya</a></li>
                    @endif
                    <li><a href="{{ route('logout') }}" style="color:#ef4444;">Keluar</a></li>
                @else
                    <li><a href="{{ route('login') }}">Masuk</a></li>
                @endauth
            </ul>
        </header>

        <div class="catalog-container">
            <h1 class="page-title">Armada Premium <span>Kami</span></h1>
            <p class="page-subtitle">Pilih mobil terbaik untuk perjalanan Anda. Semua armada dalam kondisi prima dan siap jalan.</p>

            <!-- Toolbar: Search & Filter -->
            <div class="toolbar">
                <form action="{{ route('catalog.index') }}" method="GET" class="search-wrapper">
                    <i data-lucide="search"></i>
                    <input type="text" name="search" class="search-input" placeholder="Cari nama mobil..." value="{{ request('search') }}">
                    @if(request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif
                </form>

                <div class="filters">
                    <a href="{{ route('catalog.index', ['search' => request('search')]) }}" class="filter-btn {{ !request('type') ? 'active' : '' }}">Semua</a>
                    @foreach($types as $type)
                        <a href="{{ route('catalog.index', ['type' => $type, 'search' => request('search')]) }}" class="filter-btn {{ request('type') == $type ? 'active' : '' }}">{{ $type }}</a>
                    @endforeach
                </div>
            </div>

            <!-- Cars Grid -->
            @if($cars->count() > 0)
                <div class="cars-grid">
                    @foreach($cars as $car)
                        <div class="car-card">
                            {{-- Tampilkan gambar asli dari storage, fallback ke placeholder jika belum ada --}}
                            @if($car->image)
                                <img src="{{ asset('car-images/' . $car->image) }}" alt="{{ $car->name }}" class="car-image">
                            @else
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&w=600&q=80" alt="{{ $car->name }}" class="car-image">
                            @endif

                            <div class="car-content">
                                <div class="car-header">
                                    <h3 class="car-title">{{ $car->name }}</h3>
                                    @if($car->status === 'available')
                                        <span class="car-badge">Ready</span>
                                    @elseif($car->status === 'booked')
                                        <span class="car-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">Booked</span>
                                    @else
                                        <span class="car-badge" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">Sewa</span>
                                    @endif
                                </div>

                                <div class="car-specs">
                                    @if($car->engine)
                                    <div class="spec-item">
                                        <i data-lucide="fuel"></i>
                                        <span>{{ $car->engine }}</span>
                                    </div>
                                    @endif
                                    @if($car->gearbox)
                                    <div class="spec-item">
                                        <i data-lucide="settings"></i>
                                        <span>{{ $car->gearbox }}</span>
                                    </div>
                                    @endif
                                    <div class="spec-item">
                                        <i data-lucide="users"></i>
                                        <span>{{ $car->seats ? $car->seats . ' Kursi' : $car->type }}</span>
                                    </div>
                                    @if($car->year)
                                    <div class="spec-item">
                                        <i data-lucide="calendar"></i>
                                        <span>{{ $car->year }}</span>
                                    </div>
                                    @endif
                                </div>

                                @if($car->description)
                                <p style="font-size:0.82rem; color:var(--text-secondary); margin-bottom:1rem; line-height:1.5;">
                                    {{ Str::limit($car->description, 80) }}
                                </p>
                                @endif

                                <div class="car-footer">
                                    <div class="car-price">
                                        Rp {{ number_format($car->rental_price, 0, ',', '.') }}<span>/hari</span>
                                    </div>
                                    @if($car->status === 'available')
                                        <button class="rent-btn" onclick="openBookModal({{ $car->id }}, '{{ addslashes($car->name) }}', {{ $car->rental_price }})">
                                            Sewa Sekarang
                                            <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    @else
                                        <button class="rent-btn" style="background: rgba(255, 255, 255, 0.05); color: var(--text-secondary); cursor: not-allowed; box-shadow: none;" disabled>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @else
                <div class="empty-state">
                    <i data-lucide="car"></i>
                    <h3>Tidak ada mobil yang ditemukan</h3>
                    <p>Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal-overlay" id="bookModal">
      <div class="modal">
        <button class="modal-close" onclick="closeBookModal()">✕</button>
        <div class="modal-title">Pesan Mobil</div>
        <div class="modal-sub">Isi detail pemesanan Anda di bawah ini.</div>
        <div class="modal-car-info">
          <div class="modal-car-name" id="modal-car-name"></div>
          <div style="color:#94a3b8;font-size:.82rem;" id="modal-car-price"></div>
        </div>
        <form id="bookForm" method="POST">
          @csrf
          <div class="modal-form-group">
            <label class="modal-label">Tanggal Mulai Sewa</label>
            <input type="date" name="start_date" class="modal-input" id="modal-date" min="{{ date('Y-m-d') }}" required>
          </div>
          <div class="modal-form-group">
            <label class="modal-label">Durasi Sewa (Hari)</label>
            <input type="number" name="duration_days" class="modal-input" min="1" max="30" value="1" required>
          </div>
          <button type="submit" class="btn-book-submit">Lanjut ke Pembayaran →</button>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();
        const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
        const loginUrl = "{{ route('login') }}";

        // Tampilkan error dari session jika ada
        @if(session('error'))
            Swal.fire({
                title: 'Gagal',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#6366f1',
                background: '#1e293b',
                color: '#fff'
            });
        @endif

        // Tampilkan success dari session jika ada
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#6366f1',
                background: '#1e293b',
                color: '#fff'
            });
        @endif

        function openBookModal(carId, carName, price) {
            if (!isLoggedIn) {
                Swal.fire({ title:'Silakan Masuk', text:'Login dahulu untuk memesan mobil.', icon:'info', showCancelButton:true, confirmButtonText:'Ke Login', cancelButtonText:'Batal', confirmButtonColor:'#6366f1', background:'#1e293b', color:'#fff' })
                .then(r => { if (r.isConfirmed) window.location.href = loginUrl; });
                return;
            }
            document.getElementById('modal-car-name').textContent = carName;
            document.getElementById('modal-car-price').textContent = 'Rp ' + price.toLocaleString('id-ID') + ' / hari';
            document.getElementById('bookForm').action = '/cars/' + carId + '/book';
            document.getElementById('modal-date').value = '';
            document.getElementById('bookModal').classList.add('open');
        }
        function closeBookModal() { document.getElementById('bookModal').classList.remove('open'); }
        document.getElementById('bookModal').addEventListener('click', function(e) { if(e.target===this) closeBookModal(); });
    </script>
</body>
</html>
