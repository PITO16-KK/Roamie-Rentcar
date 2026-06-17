<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - ROAMIE</title>
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
            overflow: hidden;
            background-image: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.1), transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 3rem;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            display: inline-block;
            text-decoration: none;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            width: 16px;
            height: 16px;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 0.75rem;
            color: var(--text-primary);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(30, 41, 59, 0.8);
        }

        .btn-login {
            width: 100%;
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .footer-links {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .footer-links a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 2rem;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <a href="{{ route('landing') }}" class="back-link">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            Kembali ke Beranda
        </a>
        <br>
        <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
        
        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; padding: 0.85rem 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: var(--text-primary); font-size: 0.85rem; text-align: left; backdrop-filter: blur(10px);">
                <ul style="list-style: none; padding-left: 0; display: flex; flex-direction: column; gap: 0.35rem;">
                    @foreach ($errors->all() as $error)
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <i data-lucide="alert-circle" style="width: 16px; height: 16px; color: #ef4444; flex-shrink: 0;"></i>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @elseif(session('message'))
            <div style="background: rgba(99, 102, 241, 0.15); border: 1px solid var(--accent); padding: 0.85rem 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: var(--text-primary); font-size: 0.85rem; backdrop-filter: blur(10px); display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="info" style="width: 16px; height: 16px; color: var(--accent); flex-shrink: 0;"></i>
                <span>{{ session('message') }}</span>
            </div>
        @elseif(session('success'))
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; padding: 0.85rem 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: var(--text-primary); font-size: 0.85rem; backdrop-filter: blur(10px); display: flex; align-items: center; gap: 0.5rem;">
                <i data-lucide="check-circle" style="width: 16px; height: 16px; color: #10b981; flex-shrink: 0;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @else
            <h2>Selamat Datang</h2>
            <p>Silakan masuk untuk melanjutkan.</p>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <div class="input-wrapper">
                    <i data-lucide="mail"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="customer@gmail.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrapper">
                    <i data-lucide="lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <div class="footer-links">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>
