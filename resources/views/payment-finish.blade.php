<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status Pembayaran - ROAMIE</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
:root {
  --bg: #0b111e;
  --text: #f8fafc;
  --muted: #94a3b8;
  --accent: #6366f1;
  --grad: linear-gradient(135deg, #6366f1, #a855f7);
  --grad-success: linear-gradient(135deg, #10b981, #059669);
  --grad-pending: linear-gradient(135deg, #f59e0b, #d97706);
  --grad-failed: linear-gradient(135deg, #ef4444, #dc2626);
  --border: rgba(255,255,255,.06);
  --glass: rgba(30,41,59,.45);
}
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background-image:
    radial-gradient(circle at 20% 20%, rgba(99,102,241,.15), transparent 40%),
    radial-gradient(circle at 80% 80%, rgba(168,85,247,.1), transparent 40%);
}

/* Nav */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem 2.5rem;
  border-bottom: 1px solid var(--border);
  background: rgba(11,17,30,.85);
  backdrop-filter: blur(12px);
}
.logo {
  font-size: 1.3rem;
  font-weight: 800;
  background: var(--grad);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-decoration: none;
}

/* Main */
main {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem 1.5rem;
}

.card {
  background: var(--glass);
  border: 1px solid var(--border);
  border-radius: 1.75rem;
  padding: 3rem 2.5rem;
  max-width: 520px;
  width: 100%;
  backdrop-filter: blur(20px);
  text-align: center;
  position: relative;
  overflow: hidden;
}

.card::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle at center, rgba(99,102,241,.04), transparent 60%);
  pointer-events: none;
}

/* Icon circle */
.status-icon {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.75rem;
  position: relative;
}
.status-icon.success { background: linear-gradient(135deg, rgba(16,185,129,.2), rgba(5,150,105,.1)); border: 2px solid rgba(16,185,129,.3); }
.status-icon.pending { background: linear-gradient(135deg, rgba(245,158,11,.2), rgba(217,119,6,.1)); border: 2px solid rgba(245,158,11,.3); }
.status-icon.failed  { background: linear-gradient(135deg, rgba(239,68,68,.2), rgba(220,38,38,.1)); border: 2px solid rgba(239,68,68,.3); }

.pulse {
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  animation: pulse 2.5s ease-out infinite;
}
.success .pulse { border: 2px solid rgba(16,185,129,.25); }
.pending .pulse { border: 2px solid rgba(245,158,11,.25); }
.failed  .pulse { border: 2px solid rgba(239,68,68,.25); }
@keyframes pulse { 0%{transform:scale(1);opacity:1} 100%{transform:scale(1.5);opacity:0} }

.status-emoji { font-size: 2.5rem; line-height: 1; }

/* Text */
.status-title {
  font-size: 1.8rem;
  font-weight: 800;
  letter-spacing: -.5px;
  margin-bottom: .6rem;
}
.status-title.success { color: #10b981; }
.status-title.pending { color: #f59e0b; }
.status-title.failed  { color: #ef4444; }

.status-message {
  color: var(--muted);
  font-size: .95rem;
  line-height: 1.6;
  margin-bottom: 2rem;
}

/* Rental detail box */
.detail-box {
  background: rgba(15,23,42,.6);
  border: 1px solid var(--border);
  border-radius: 1rem;
  padding: 1.25rem;
  margin-bottom: 2rem;
  text-align: left;
}
.detail-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: .5rem 0;
  border-bottom: 1px solid var(--border);
  font-size: .875rem;
}
.detail-row:last-child { border: none; }
.detail-label { color: var(--muted); }
.detail-value { font-weight: 600; }

/* Badge */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  padding: .25rem .75rem;
  border-radius: 2rem;
  font-size: .75rem;
  font-weight: 700;
}
.badge-success { background: rgba(16,185,129,.15); color: #10b981; border: 1px solid rgba(16,185,129,.25); }
.badge-pending { background: rgba(245,158,11,.15); color: #f59e0b; border: 1px solid rgba(245,158,11,.25); }
.badge-failed  { background: rgba(239,68,68,.15); color: #ef4444; border: 1px solid rgba(239,68,68,.25); }

/* Buttons */
.btn-group { display: flex; gap: .85rem; justify-content: center; flex-wrap: wrap; }
.btn {
  padding: .8rem 1.75rem;
  border-radius: .875rem;
  font-weight: 700;
  font-size: .9rem;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: .45rem;
  transition: all .25s;
  border: none;
}
.btn-primary {
  background: var(--grad);
  color: #fff;
  box-shadow: 0 4px 15px rgba(99,102,241,.35);
}
.btn-primary:hover { opacity: .9; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99,102,241,.4); }
.btn-secondary {
  background: rgba(30,41,59,.8);
  color: var(--muted);
  border: 1px solid var(--border);
}
.btn-secondary:hover { color: var(--text); border-color: rgba(255,255,255,.15); }

/* Confetti dots (visual only) */
.confetti-area {
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  overflow: hidden;
  z-index: 0;
}
.confetti-dot {
  position: absolute;
  width: 6px; height: 6px;
  border-radius: 50%;
  animation: fall linear infinite;
}
@keyframes fall {
  0% { transform: translateY(-20px) rotate(0deg); opacity: 1; }
  100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}
</style>
</head>
<body>

{{-- Confetti hanya untuk success --}}
@if($status === 'success')
<div class="confetti-area" id="confetti"></div>
@endif

<nav>
  <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
  <a href="{{ route('profile') }}" style="display:inline-flex;align-items:center;gap:.4rem;color:var(--muted);font-size:.85rem;text-decoration:none;">
    <i data-lucide="user" style="width:15px;height:15px;"></i>
    Profil Saya
  </a>
</nav>

<main>
  <div class="card" style="position:relative;z-index:1;">

    {{-- Status Icon --}}
    <div class="status-icon {{ $status }}">
      <div class="pulse"></div>
      @if($status === 'success')
        <span class="status-emoji">✅</span>
      @elseif($status === 'pending')
        <span class="status-emoji">⏳</span>
      @else
        <span class="status-emoji">❌</span>
      @endif
    </div>

    {{-- Title & Message --}}
    <h1 class="status-title {{ $status }}">
      @if($status === 'success') Pembayaran Berhasil!
      @elseif($status === 'pending') Menunggu Pembayaran
      @else Pembayaran Gagal
      @endif
    </h1>
    <p class="status-message">{{ $message }}</p>

    {{-- Rental Detail Box --}}
    @if($rental)
    <div class="detail-box">
      <div class="detail-row">
        <span class="detail-label">Order ID</span>
        <span class="detail-value" style="font-size:.8rem;font-family:monospace;color:#a855f7;">{{ $rental->order_id }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Kendaraan</span>
        <span class="detail-value">{{ $rental->car->name ?? '-' }}</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Durasi</span>
        <span class="detail-value">{{ $rental->duration_days }} hari</span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Total Tagihan</span>
        <span class="detail-value" style="background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-size:1rem;">
          Rp {{ number_format($rental->total_price, 0, ',', '.') }}
        </span>
      </div>
      <div class="detail-row">
        <span class="detail-label">Status Pembayaran</span>
        <span class="status-badge badge-{{ $status === 'success' ? 'success' : ($status === 'pending' ? 'pending' : 'failed') }}">
          @if($status === 'success') ● Lunas
          @elseif($status === 'pending') ● Menunggu
          @else ● Gagal
          @endif
        </span>
      </div>
    </div>
    @else
    {{-- Tidak ada rental ditemukan --}}
    <div style="background:rgba(245,158,11,.05);border:1px solid rgba(245,158,11,.2);border-radius:.875rem;padding:1rem;margin-bottom:2rem;font-size:.85rem;color:var(--muted);text-align:center;">
      Data transaksi akan segera diperbarui setelah notifikasi diterima.
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="btn-group">
      @if($status === 'success')
        <a href="{{ route('profile') }}" class="btn btn-primary">
          <i data-lucide="user" style="width:16px;height:16px;"></i>
          Ke Profil Saya
        </a>
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary">
          <i data-lucide="car" style="width:16px;height:16px;"></i>
          Lihat Promo
        </a>
      @elseif($status === 'pending')
        <a href="{{ route('profile') }}" class="btn btn-primary">
          <i data-lucide="clock" style="width:16px;height:16px;"></i>
          Cek Status di Profil
        </a>
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary">
          <i data-lucide="home" style="width:16px;height:16px;"></i>
          Beranda
        </a>
      @else
        @if($rental)
        <a href="{{ route('payment.show', $rental->id) }}" class="btn btn-primary">
          <i data-lucide="refresh-cw" style="width:16px;height:16px;"></i>
          Coba Lagi
        </a>
        @endif
        <a href="{{ route('catalog.index') }}" class="btn btn-secondary">
          <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
          Kembali ke Promo
        </a>
      @endif
    </div>

  </div>
</main>

<script>
lucide.createIcons();

// Confetti animation for success
@if($status === 'success')
(function() {
  var colors = ['#6366f1','#a855f7','#10b981','#f59e0b','#ec4899','#00b4d8'];
  var container = document.getElementById('confetti');
  for (var i = 0; i < 60; i++) {
    var dot = document.createElement('div');
    dot.className = 'confetti-dot';
    dot.style.cssText = [
      'left:' + (Math.random() * 100) + '%',
      'top:' + (-(Math.random() * 200)) + 'px',
      'background:' + colors[Math.floor(Math.random() * colors.length)],
      'animation-duration:' + (2.5 + Math.random() * 3) + 's',
      'animation-delay:' + (Math.random() * 2) + 's',
      'width:' + (4 + Math.random() * 5) + 'px',
      'height:' + (4 + Math.random() * 5) + 'px',
      'border-radius:' + (Math.random() > 0.5 ? '50%' : '2px'),
    ].join(';');
    container.appendChild(dot);
  }
  // Remove confetti after 5s
  setTimeout(function() { if(container) container.style.display='none'; }, 5500);
})();
@endif
</script>
</body>
</html>
