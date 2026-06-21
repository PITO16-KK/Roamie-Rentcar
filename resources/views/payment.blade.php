<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran - ROAMIE</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
:root{--bg:#0b111e;--text:#f8fafc;--muted:#94a3b8;--accent:#6366f1;--grad:linear-gradient(135deg,#6366f1,#a855f7);--border:rgba(255,255,255,.06);--glass:rgba(30,41,59,.45);}
*{margin:0;padding:0;box-sizing:border-box;font-family:'Plus Jakarta Sans',sans-serif;}
body{background:var(--bg);color:var(--text);min-height:100vh;background-image:radial-gradient(circle at 70% 10%,rgba(99,102,241,.12),transparent 50%);}
.nav{display:flex;justify-content:space-between;align-items:center;padding:1.2rem 2.5rem;border-bottom:1px solid var(--border);background:rgba(11,17,30,.85);backdrop-filter:blur(12px);position:sticky;top:0;z-index:99;}
.logo{font-size:1.3rem;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;text-transform:uppercase;letter-spacing:2px;text-decoration:none;}
.back-btn{display:inline-flex;align-items:center;gap:.4rem;color:var(--muted);font-size:.85rem;text-decoration:none;transition:color .2s;}
.back-btn:hover{color:var(--text);}
.container{max-width:900px;margin:0 auto;padding:2.5rem 1.5rem;}
.page-title{font-size:1.75rem;font-weight:800;letter-spacing:-.5px;margin-bottom:.3rem;}
.page-sub{color:var(--muted);font-size:.9rem;margin-bottom:2rem;}
.grid{display:grid;grid-template-columns:1fr 340px;gap:1.75rem;align-items:start;}
@media(max-width:768px){.grid{grid-template-columns:1fr;}}
.card{background:var(--glass);border:1px solid var(--border);border-radius:1.25rem;padding:1.5rem;backdrop-filter:blur(12px);}
.section-label{font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--muted);margin-bottom:1rem;}

/* Order Summary */
.order-row{display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--border);font-size:.88rem;}
.order-row:last-child{border:none;}
.order-row.total{font-size:1rem;font-weight:700;margin-top:.5rem;}
.price-highlight{font-size:1.4rem;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}

/* Payment Methods */
.methods-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-bottom:1.5rem;}
.method-btn{background:rgba(15,23,42,.6);border:2px solid var(--border);border-radius:.875rem;padding:.9rem .5rem;cursor:pointer;transition:all .25s;text-align:center;position:relative;}
.method-btn:hover{border-color:rgba(99,102,241,.4);background:rgba(99,102,241,.06);}
.method-btn.active{border-color:var(--accent);background:rgba(99,102,241,.1);}
.method-btn.active::after{content:'✓';position:absolute;top:6px;right:8px;font-size:.7rem;color:var(--accent);font-weight:700;}
.method-logo{font-size:1rem;font-weight:800;display:block;margin-bottom:.2rem;}
.method-label{font-size:.7rem;color:var(--muted);}
.dana-color{color:#118EEA;}
.bca-color{color:#005BAC;}
.mandiri-color{color:#003D82;}
.bni-color{color:#F48024;}
.qris-color{background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}

/* Transfer Info Panel */
.transfer-panel{display:none;background:rgba(15,23,42,.6);border:1px solid var(--border);border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;}
.transfer-panel.visible{display:block;}
.bank-name{font-size:1.05rem;font-weight:700;margin-bottom:1rem;}
.account-box{background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.2);border-radius:.75rem;padding:1rem;display:flex;justify-content:space-between;align-items:center;margin-bottom:.85rem;}
.account-number{font-size:1.3rem;font-weight:800;letter-spacing:2px;}
.copy-btn{background:var(--grad);color:#fff;border:none;padding:.45rem .9rem;border-radius:.5rem;font-size:.78rem;font-weight:700;cursor:pointer;transition:opacity .2s;display:flex;align-items:center;gap:.35rem;}
.copy-btn:hover{opacity:.85;}
.account-name{color:var(--muted);font-size:.82rem;}
.steps{display:flex;flex-direction:column;gap:.6rem;margin-top:.75rem;}
.step{display:flex;gap:.75rem;align-items:flex-start;font-size:.83rem;color:var(--muted);}
.step-num{width:20px;height:20px;border-radius:50%;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:var(--accent);flex-shrink:0;margin-top:1px;}

/* QRIS */
.qris-box{text-align:center;padding:1rem;}
.qris-img{width:180px;height:180px;background:#fff;border-radius:.75rem;margin:0 auto .75rem;padding:12px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;}
.qris-merchant{font-weight:700;font-size:.88rem;margin-bottom:.25rem;}
.qris-amount{font-size:1.1rem;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;}

/* Inputs */
.form-input{width:100%;padding:.75rem 1rem;background:rgba(15,23,42,.6);border:1px solid var(--border);border-radius:.75rem;color:#fff;font-size:.9rem;outline:none;transition:border-color .3s;}
.form-input:focus{border-color:var(--accent);}

/* Confirm Button */
.btn-confirm{width:100%;background:var(--grad);color:#fff;border:none;padding:.9rem;border-radius:.875rem;font-size:1rem;font-weight:700;cursor:pointer;transition:all .3s;margin-top:.5rem;display:flex;align-items:center;justify-content:center;gap:.5rem;}
.btn-confirm:hover{opacity:.9;transform:translateY(-2px);box-shadow:0 6px 20px rgba(99,102,241,.35);}
.btn-confirm:disabled{opacity:.5;cursor:not-allowed;transform:none;box-shadow:none;}
.no-method-note{color:var(--muted);font-size:.8rem;text-align:center;margin-top:.75rem;}

/* Alert Cards */
.alert-card{border-radius:1rem;padding:1.25rem;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:.5rem;}
.alert-card.pending{background:rgba(245,158,11,.08);border:1px solid rgba(245,158,11,.25);color:#f59e0b;}
.alert-card.success{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.25);color:#10b981;}
.alert-card.danger{background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);color:#ef4444;}
.alert-title{font-weight:700;font-size:1.05rem;display:flex;align-items:center;gap:.5rem;}
.alert-desc{font-size:.85rem;color:var(--muted);line-height:1.45;}
</style>
</head>
<body>
<nav class="nav">
  <a href="{{ route('landing') }}" class="logo">ROAMIE</a>
  <a href="{{ route('profile') }}" class="back-btn"><i data-lucide="arrow-left" style="width:15px;height:15px;"></i> Kembali ke Profil</a>
</nav>

<div class="container">
  <h1 class="page-title">Status Pembayaran</h1>
  <p class="page-sub">Informasi lengkap transaksi pembayaran sewa mobil Anda.</p>

  <div class="grid">
    <!-- LEFT: Payment Details & Actions -->
    <div>
      @if($rental->payment_status === 'pending')
        <!-- PENDING STATUS -->
        <div class="card">
          <div class="alert-card pending">
            <div class="alert-title">
              <i data-lucide="clock" style="width:20px;height:20px;"></i>
              Menunggu Verifikasi Admin
            </div>
            <div class="alert-desc">
              Bukti transfer manual yang Anda unggah sedang dalam proses review oleh tim verifikator kami. Silakan cek kembali halaman ini atau menu profil Anda secara berkala.
            </div>
          </div>

          @if($rental->payment)
          <div style="background:rgba(15,23,42,.4);border:1px solid var(--border);border-radius:1rem;padding:1.25rem;margin-bottom:1.5rem;">
            <div class="section-label">Detail Transaksi Pengirim</div>
            <div class="order-row"><span style="color:var(--muted);">Bank Pengirim</span><span>{{ $rental->payment->bank_name }}</span></div>
            <div class="order-row"><span style="color:var(--muted);">No. Rekening</span><span>{{ $rental->payment->account_number }}</span></div>
            <div class="order-row"><span style="color:var(--muted);">Nama Pemilik</span><span>{{ $rental->payment->account_name }}</span></div>
            <div class="order-row" style="border:none;"><span style="color:var(--muted);">Bukti Upload</span><span><a href="/car-images/{{ $rental->payment->proof_of_payment }}" target="_blank" style="color:var(--accent);text-decoration:none;font-weight:600;">Lihat Bukti Transfer</a></span></div>
          </div>
          @endif

          <a href="{{ route('profile') }}" class="btn-confirm" style="text-decoration:none;background:var(--glass);border:1px solid var(--border);color:#fff;">
            Kembali ke Profil Saya
          </a>
        </div>

      @elseif($rental->payment_status === 'paid')
        <!-- SUCCESS STATUS -->
        <div class="card">
          <div class="alert-card success">
            <div class="alert-title">
              <i data-lucide="check-circle" style="width:20px;height:20px;"></i>
              Pembayaran Lunas
            </div>
            <div class="alert-desc">
              Terima kasih! Pembayaran Anda telah kami verifikasi. Mobil Anda siap diambil sesuai dengan tanggal mulai sewa yang telah Anda tentukan.
            </div>
          </div>

          @if($rental->payment)
          <div style="background:rgba(15,23,42,.4);border:1px solid var(--border);border-radius:1rem;padding:1.25rem;margin-bottom:1.5rem;">
            <div class="section-label">Rincian Pembayaran</div>
            <div class="order-row"><span style="color:var(--muted);">Metode Pembayaran</span><span>Transfer Bank Manual</span></div>
            <div class="order-row"><span style="color:var(--muted);">Asal Bank</span><span>{{ $rental->payment->bank_name }}</span></div>
            <div class="order-row" style="border:none;"><span style="color:var(--muted);">Waktu Verifikasi</span><span>{{ $rental->payment->updated_at->format('d M Y H:i') }} WIB</span></div>
          </div>
          @endif

          <a href="{{ route('profile') }}" class="btn-confirm" style="text-decoration:none;">
            Masuk ke Profil & Layanan GPS
          </a>
        </div>

      @else
        <!-- UNPAID / REJECTED STATUS -->
        <div class="card">
          @if($rental->payment_status === 'rejected')
            <div class="alert-card danger" style="margin-bottom: 1.5rem;">
              <div class="alert-title">
                <i data-lucide="x-circle" style="width:20px;height:20px;"></i>
                Pembayaran Ditolak Admin
              </div>
              <div class="alert-desc">
                Bukti pembayaran sebelumnya ditolak oleh admin karena ketidaksesuaian data transfer. Mohon lakukan transfer ulang atau kirimkan bukti transfer yang valid.
              </div>
            </div>
          @endif

          <div class="section-label">Pilih Metode Pembayaran</div>
          <div class="methods-grid">
            <div class="method-btn" onclick="selectMethod('dana',this)">
              <span class="method-logo dana-color">DANA</span>
              <span class="method-label">e-Wallet</span>
            </div>
            <div class="method-btn" onclick="selectMethod('bca',this)">
              <span class="method-logo bca-color">BCA</span>
              <span class="method-label">Transfer Bank</span>
            </div>
            <div class="method-btn" onclick="selectMethod('mandiri',this)">
              <span class="method-logo mandiri-color">Mandiri</span>
              <span class="method-label">Transfer Bank</span>
            </div>
            <div class="method-btn" onclick="selectMethod('bni',this)">
              <span class="method-logo bni-color">BNI</span>
              <span class="method-label">Transfer Bank</span>
            </div>
            <div class="method-btn" onclick="selectMethod('qris',this)" style="grid-column:span 2;">
              <span class="method-logo qris-color">⬛ QRIS</span>
              <span class="method-label">Scan QR Code</span>
            </div>
          </div>

          <!-- DANA Panel -->
          <div id="panel-dana" class="transfer-panel">
            <div class="bank-name dana-color" style="display:flex;justify-content:space-between;align-items:center;">
              <span>💙 DANA e-Wallet</span>
              <span style="font-size:.75rem;padding:.2rem .6rem;background:rgba(17,142,234,.1);border:1px solid rgba(17,142,234,.2);border-radius:2rem;">Konfirmasi Instan</span>
            </div>
            
            <div style="text-align:center;margin:1rem 0;background:rgba(15,23,42,.4);border:1px solid var(--border);border-radius:.75rem;padding:1rem;">
              <div class="qris-img" style="border: 2px solid #118EEA; width: 174px; height: 174px; background: #fff; border-radius: .75rem; margin: 0 auto; padding: 12px; display: flex; align-items: center; justify-content: center;">
                <svg width="150" height="150" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto;">
                  <path d="M0 0h7v7H0V0zm1 1v5h5V1H1zm1 1h3v3H2V2z" fill="#118EEA"/>
                  <path d="M22 0h7v7h-7V0zm1 1v5h5V1h-5zm1 1h3v3h-3V2z" fill="#118EEA"/>
                  <path d="M0 22h7v7H0v-7zm1 1v5h5v-5H1zm1 1h3v3H2v-3z" fill="#118EEA"/>
                  <path d="M9 1h1v1H9V1zm2 0h1v1h-1V1zm3 0h3v1h-3V1zm4 0h1v1h-1V1zm2 0h1v1h-1V1z" fill="#000"/>
                  <path d="M9 2h2v1H9V2zm3 0h1v2h-1V2zm2 0h1v1h-1V2zm3 0h1v1h-1V2zm2 0h2v1h-2V2z" fill="#000"/>
                  <path d="M10 4h2v1h-2V4zm3 0h3v1h-3V4zm5 0h1v1h-1V4z" fill="#000"/>
                  <path d="M9 5h1v2H9V5zm2 0h2v1h-2V5zm4 0h2v1h-2V5zm3 0h1v1h-1V5z" fill="#000"/>
                  <path d="M1 9h1v1H1V9zm3 0h2v1H4V9zm3 0h1v2H7V9zm2 0h3v1H9V9zm4 0h1v1h-1V9zm2 0h2v1h-2V9zm4 0h1v2h-1V9zm2 0h2v1h-2V9z" fill="#000"/>
                  <rect x="11" y="11" width="7" height="7" rx="1.5" fill="#fff" stroke="#118EEA" stroke-width="1"/>
                  <text x="14.5" y="15.5" font-family="'Plus Jakarta Sans',sans-serif" font-size="3.2" font-weight="900" text-anchor="middle" fill="#118EEA">DANA</text>
                </svg>
              </div>
              <div style="font-size:.75rem;color:var(--muted);margin-top:.5rem;">Scan QR di atas dengan aplikasi DANA Anda</div>
            </div>

            <div class="account-box">
              <div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.2rem;">Nomor HP DANA Penerima</div>
                <div class="account-number">0812-3456-7890</div>
              </div>
              <button class="copy-btn" onclick="copyText('081234567890')"><i data-lucide="copy" style="width:12px;height:12px;"></i> Salin</button>
            </div>
            <div class="account-name" style="margin-bottom:1.25rem;">a.n. <strong>PT ROAMIE SMART RENT</strong></div>

            <div class="steps">
              <div class="step"><div class="step-num">1</div><span>Scan QR atau kirim langsung ke nomor DANA penerima di atas</span></div>
              <div class="step"><div class="step-num">2</div><span>Masukkan nominal transfer sesuai total tagihan sewa</span></div>
              <div class="step"><div class="step-num">3</div><span>Unggah bukti transfer dan isi rincian rekening Anda di form bawah</span></div>
            </div>
          </div>

          <!-- BCA Panel -->
          <div id="panel-bca" class="transfer-panel">
            <div class="bank-name bca-color">🏦 Bank BCA</div>
            <div class="account-box">
              <div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.2rem;">Nomor Rekening</div>
                <div class="account-number">8720-1928-31</div>
              </div>
              <button class="copy-btn" onclick="copyText('8720192831')"><i data-lucide="copy" style="width:12px;height:12px;"></i> Salin</button>
            </div>
            <div class="account-name">a.n. <strong>PT ROAMIE SMART RENT</strong></div>
            <div class="steps">
              <div class="step"><div class="step-num">1</div><span>Buka m-BCA / ATM BCA</span></div>
              <div class="step"><div class="step-num">2</div><span>Pilih <strong>Transfer → ke Rekening BCA</strong></span></div>
              <div class="step"><div class="step-num">3</div><span>Transfer sesuai nominal Total di ringkasan pesanan</span></div>
              <div class="step"><div class="step-num">4</div><span>Unggah bukti bayar & isi data rekening Anda di bawah</span></div>
            </div>
          </div>

          <!-- Mandiri Panel -->
          <div id="panel-mandiri" class="transfer-panel">
            <div class="bank-name mandiri-color">🏦 Bank Mandiri</div>
            <div class="account-box">
              <div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.2rem;">Nomor Rekening</div>
                <div class="account-number">1370-0281-9283</div>
              </div>
              <button class="copy-btn" onclick="copyText('137002819283')"><i data-lucide="copy" style="width:12px;height:12px;"></i> Salin</button>
            </div>
            <div class="account-name">a.n. <strong>PT ROAMIE SMART RENT</strong></div>
            <div class="steps">
              <div class="step"><div class="step-num">1</div><span>Buka Livin by Mandiri / ATM Mandiri</span></div>
              <div class="step"><div class="step-num">2</div><span>Pilih <strong>Transfer → Mandiri</strong></span></div>
              <div class="step"><div class="step-num">3</div><span>Kirim uang pas sesuai nominal Tagihan</span></div>
              <div class="step"><div class="step-num">4</div><span>Isi rincian pengirim & upload struk transaksi di bawah</span></div>
            </div>
          </div>

          <!-- BNI Panel -->
          <div id="panel-bni" class="transfer-panel">
            <div class="bank-name bni-color">🏦 Bank BNI</div>
            <div class="account-box">
              <div>
                <div style="font-size:.72rem;color:var(--muted);margin-bottom:.2rem;">Nomor Rekening</div>
                <div class="account-number">0981-2938-12</div>
              </div>
              <button class="copy-btn" onclick="copyText('0981293812')"><i data-lucide="copy" style="width:12px;height:12px;"></i> Salin</button>
            </div>
            <div class="account-name">a.n. <strong>PT ROAMIE SMART RENT</strong></div>
            <div class="steps">
              <div class="step"><div class="step-num">1</div><span>Buka BNI Mobile / ATM BNI</span></div>
              <div class="step"><div class="step-num">2</div><span>Pilih <strong>Transfer → BNI</strong></span></div>
              <div class="step"><div class="step-num">3</div><span>Transfer nominal tagihan secara tepat</span></div>
              <div class="step"><div class="step-num">4</div><span>Isi detail pengirim & upload bukti bayar di bawah</span></div>
            </div>
          </div>

          <!-- QRIS Panel -->
          <div id="panel-qris" class="transfer-panel">
            <div class="bank-name qris-color" style="display:flex;justify-content:space-between;align-items:center;">
              <span>⬛ Scan QRIS Resmi</span>
              <span style="font-size:.75rem;padding:.2rem .6rem;background:rgba(255,255,255,.05);border:1px solid var(--border);border-radius:2rem;color:var(--muted);">QRIS GPN</span>
            </div>
            <div class="qris-box" style="background:rgba(15,23,42,.4);border:1px solid var(--border);border-radius:1rem;padding:1.5rem;margin-bottom:1rem;position:relative;">
              <div style="font-weight:800;font-size:1.1rem;margin-bottom:.25rem;letter-spacing:1px;color:#fff;">PT ROAMIE SMART RENT</div>
              <div style="font-size:.72rem;color:var(--muted);margin-bottom:1rem;text-transform:uppercase;letter-spacing:0.5px;">NMID: ID1020304050607</div>
              <div class="qris-img" style="width:180px;height:180px;background:#fff;border-radius:.75rem;margin:0 auto 1rem;padding:12px;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 25px rgba(0,0,0,0.4);border:1px solid rgba(255,255,255,0.1);">
                <svg width="160" height="160" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;margin:0 auto;">
                  <path d="M0 0h7v7H0V0zm1 1v5h5V1H1zm1 1h3v3H2V2z" fill="#000"/>
                  <path d="M22 0h7v7h-7V0zm1 1v5h5V1h-5zm1 1h3v3h-3V2z" fill="#000"/>
                  <path d="M0 22h7v7H0v-7zm1 1v5h5v-5H1zm1 1h3v3H2v-3z" fill="#000"/>
                  <path d="M9 1h1v1H9V1zm2 0h1v1h-1V1zm3 0h3v1h-3V1zm4 0h1v1h-1V1zm2 0h1v1h-1V1z" fill="#000"/>
                  <path d="M9 2h2v1H9V2zm3 0h1v2h-1V2zm2 0h1v1h-1V2zm3 0h1v1h-1V2zm2 0h2v1h-2V2z" fill="#000"/>
                  <path d="M10 4h2v1h-2V4zm3 0h3v1h-3V4zm5 0h1v1h-1V4z" fill="#000"/>
                  <path d="M9 5h1v2H9V5zm2 0h2v1h-2V5zm4 0h2v1h-2V5zm3 0h1v1h-1V5z" fill="#000"/>
                  <path d="M1 9h1v1H1V9zm3 0h2v1H4V9zm3 0h1v2H7V9zm2 0h3v1H9V9zm4 0h1v1h-1V9zm2 0h2v1h-2V9zm4 0h1v2h-1V9zm2 0h2v1h-2V9z" fill="#000"/>
                  <path d="M0 10h2v1H0v-1zm3 0h1v1H3v-1zm5 0h1v1H8v-1zm3 0h2v1h-2v-1zm4 0h2v1h-2v-1zm3 0h2v1h-2v-1zm4 0h2v1h-2v-1z" fill="#000"/>
                  <path d="M1 12h2v1H1v-1zm4 0h1v1H5v-1zm3 0h1v1H8v-1zm2 0h1v1h-1v-1zm3 0h3v1h-3v-1zm7 0h3v1h-3v-1z" fill="#000"/>
                  <path d="M0 13h1v1H0v-1zm2 0h2v1H2v-1zm5 0h1v1H7v-1zm2 0h2v1H9v-1zm3 0h1v1h-1v-1zm4 0h2v1h-2v-1zm4 0h1v1h-1v-1zm3 0h2v1h-2v-1z" fill="#000"/>
                  <path d="M1 15h1v1H1v-1zm4 0h2v1H5v-1zm3 0h1v1H8v-1zm2 0h3v1h-3v-1zm6 0h2v1h-2v-1zm3 0h1v1h-1v-1zm3 0h2v1h-2v-1z" fill="#000"/>
                  <path d="M0 16h2v1H0v-1zm3 0h1v1H3v-1zm5 0h1v1H8v-1zm3 0h2v1h-2v-1zm4 0h2v1h-2v-1zm3 0h2v1h-2v-1zm4 0h2v1h-2v-1z" fill="#000"/>
                  <path d="M9 18h2v1H9v-1zm3 0h1v2h-1v-2zm2 0h1v1h-1v-1zm3 0h1v1h-1v-1zm2 0h2v1h-2v-1z" fill="#000"/>
                  <path d="M10 20h2v1h-2v-1zm3 0h3v1h-3v-1zm5 0h1v1h-1v-1z" fill="#000"/>
                  <path d="M9 21h1v2H9v-2zm2 0h2v1h-2v-1zm4 0h2v1h-2v-1zm3 0h1v1h-1v-1z" fill="#000"/>
                  <rect x="11" y="11" width="7" height="7" rx="1.2" fill="#fff" stroke="#000" stroke-width="0.8"/>
                  <path d="M12.5 12.5h4v4h-4z" fill="#E51C24"/>
                  <circle cx="14.5" cy="14.5" r="1.2" fill="#fff"/>
                </svg>
              </div>
              <div style="font-size:.78rem;color:var(--muted);margin-top:.5rem;">Nominal Tagihan:</div>
              <div class="qris-amount" style="font-size:1.4rem;font-weight:800;background:var(--grad);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-top:0.1rem;">Rp {{ number_format($rental->total_price,0,',','.') }}</div>
            </div>
            <div class="steps">
              <div class="step"><div class="step-num">1</div><span>Scan QR Code di atas menggunakan aplikasi finansial Anda</span></div>
              <div class="step"><div class="step-num">2</div><span>Pastikan nominal pembayaran sama persis</span></div>
              <div class="step"><div class="step-num">3</div><span>Unggah bukti pembayaran sukses & isi data diri di bawah</span></div>
            </div>
          </div>

          <!-- Unified Sender Account Form -->
          <div id="sender-form" style="border-top:1px solid var(--border);padding-top:1.25rem;margin-bottom:1.25rem;display:none;">
            <div class="section-label">Detail Rekening Pengirim</div>
            
            <div style="margin-bottom: 1rem;">
              <label class="form-label" style="display:block;font-size:.8rem;color:var(--muted);margin-bottom:.4rem;text-align:left;font-weight:500;">Nama Bank Pengirim (Contoh: BCA, Mandiri, DANA)</label>
              <input type="text" id="sender-bank" class="form-input" placeholder="Masukkan nama bank asal atau e-wallet" oninput="validateForm()">
            </div>

            <div style="margin-bottom: 1rem;">
              <label class="form-label" style="display:block;font-size:.8rem;color:var(--muted);margin-bottom:.4rem;text-align:left;font-weight:500;">Nomor Rekening / No. HP Pengirim</label>
              <input type="text" id="sender-account-number" class="form-input" placeholder="Masukkan nomor rekening atau nomor telepon pengirim" oninput="validateForm()">
            </div>

            <div style="margin-bottom: 1rem;">
              <label class="form-label" style="display:block;font-size:.8rem;color:var(--muted);margin-bottom:.4rem;text-align:left;font-weight:500;">Nama Pemilik Rekening / Akun</label>
              <input type="text" id="sender-account-name" class="form-input" placeholder="Masukkan nama pemilik rekening asal" oninput="validateForm()">
            </div>
          </div>

          <!-- Drag and drop upload zone -->
          <div style="margin-top: 1.5rem; margin-bottom: 1.5rem;">
            <label class="form-label" style="display:block;font-size:.8rem;color:var(--muted);margin-bottom:.4rem;text-align:left;font-weight:500;">Unggah Bukti Transfer</label>
            <div id="upload-zone" style="border: 2px dashed rgba(99, 102, 241, 0.3); border-radius: 1rem; padding: 1.5rem; text-align: center; background: rgba(30, 41, 59, 0.2); backdrop-filter: blur(8px); cursor: pointer; transition: all 0.3s ease; position: relative;">
              <input type="file" id="proof-file" accept="image/*" style="position: absolute; inset: 0; opacity: 0; cursor: pointer; width:100%; height:100%;" onchange="handleFileSelect(event)">
              <div id="upload-idle">
                <i data-lucide="upload-cloud" style="width: 32px; height: 32px; color: var(--accent); margin: 0 auto .5rem; display: block;"></i>
                <p style="font-size: .85rem; font-weight: 600; margin-bottom: .25rem;">Tarik & Lepas Gambar di Sini</p>
                <p style="font-size: .75rem; color: var(--muted);">atau klik untuk mencari berkas (JPG, PNG, maks. 2MB)</p>
              </div>
              <div id="upload-preview" style="display: none; align-items: center; justify-content: center; gap: 1rem; text-align: left; position: relative; z-index: 5;">
                <div id="preview-img-container" style="width: 50px; height: 50px; border-radius: .5rem; border: 1px solid var(--border); overflow: hidden; background: #000;">
                  <img id="preview-img" src="" alt="Bukti Transfer" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div style="flex-grow: 1;">
                  <p id="preview-filename" style="font-size: .85rem; font-weight: 600; max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"></p>
                  <p id="preview-filesize" style="font-size: .75rem; color: var(--muted);"></p>
                </div>
                <button type="button" onclick="resetFile(event)" style="background: rgba(239, 68, 68, 0.15); border: none; color: #ef4444; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; outline: none; position: relative; z-index: 10;">
                  <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                </button>
              </div>
            </div>
          </div>

          <input type="hidden" id="selected-method" value="">

          <button class="btn-confirm" id="confirm-btn" onclick="confirmPayment()" disabled>
            <i data-lucide="check-circle" style="width:18px;height:18px;"></i>
            Konfirmasi Pembayaran
          </button>
          <p class="no-method-note" id="method-note">Pilih metode pembayaran terlebih dahulu</p>
        </div>
      @endif
    </div>

    <!-- RIGHT: Order Summary -->
    <div>
      <div class="card">
        <div class="section-label">Ringkasan Pesanan</div>
        <div style="background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.15);border-radius:.875rem;padding:1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:.85rem;">
          <div style="width:44px;height:44px;border-radius:.75rem;background:var(--grad);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i data-lucide="car" style="width:22px;height:22px;color:#fff;"></i>
          </div>
          <div>
            <div style="font-weight:700;font-size:.95rem;">{{ $rental->car->name }}</div>
            <div style="color:var(--muted);font-size:.78rem;">{{ $rental->car->type }}</div>
          </div>
        </div>

        <div class="order-row"><span style="color:var(--muted);">Harga per hari</span><span>Rp {{ number_format($rental->car->rental_price,0,',','.') }}</span></div>
        <div class="order-row"><span style="color:var(--muted);">Durasi sewa</span><span>{{ $rental->duration_days }} hari</span></div>
        <div class="order-row"><span style="color:var(--muted);">Tanggal mulai</span><span>{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</span></div>
        <div class="order-row"><span style="color:var(--muted);">Tanggal selesai</span><span>{{ \Carbon\Carbon::parse($rental->start_date)->addDays((int) $rental->duration_days)->format('d M Y') }}</span></div>
        <div class="order-row total">
          <span>Total Tagihan</span>
          <span class="price-highlight">Rp {{ number_format($rental->total_price,0,',','.') }}</span>
        </div>
      </div>

      <div class="card" style="margin-top:1rem;">
        <div class="section-label">Penyewa</div>
        <div style="display:flex;align-items:center;gap:.75rem;">
          @if($rental->user->avatar)
            <img src="{{ $rental->user->avatar }}" alt="Avatar" style="width:36px;height:36px;border-radius:50%;object-fit:cover;flex-shrink:0;">
          @else
            <div style="width:36px;height:36px;border-radius:50%;background:var(--grad);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:.9rem;color:#fff;flex-shrink:0;">{{ strtoupper(substr($rental->user->name,0,1)) }}</div>
          @endif
          <div>
            <div style="font-weight:600;font-size:.9rem;">{{ $rental->user->name }}</div>
            <div style="color:var(--muted);font-size:.78rem;">{{ $rental->user->email }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
lucide.createIcons();
var selectedMethod = null;
var hasFile = false;

function validateForm() {
  var confirmBtn = document.getElementById('confirm-btn');
  var methodNote = document.getElementById('method-note');
  if (!confirmBtn || !methodNote) return;
  
  if (!selectedMethod) {
    confirmBtn.disabled = true;
    methodNote.textContent = 'Pilih metode pembayaran terlebih dahulu';
    methodNote.style.display = 'block';
    return;
  }
  
  var bank = document.getElementById('sender-bank').value.trim();
  var accNum = document.getElementById('sender-account-number').value.trim();
  var accName = document.getElementById('sender-account-name').value.trim();

  if (bank.length < 2 || accNum.length < 3 || accName.length < 2) {
    confirmBtn.disabled = true;
    methodNote.textContent = 'Lengkapi detail rekening pengirim';
    methodNote.style.display = 'block';
    return;
  }
  
  if (!hasFile) {
    confirmBtn.disabled = true;
    methodNote.textContent = 'Silakan unggah bukti transfer terlebih dahulu';
    methodNote.style.display = 'block';
    return;
  }
  
  confirmBtn.disabled = false;
  methodNote.style.display = 'none';
}

function selectMethod(method, el) {
  document.querySelectorAll('.method-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.transfer-panel').forEach(p => p.classList.remove('visible'));
  el.classList.add('active');
  
  var targetPanel = document.getElementById('panel-' + method);
  if (targetPanel) targetPanel.classList.add('visible');
  
  selectedMethod = method;
  document.getElementById('selected-method').value = method;
  
  // Show sender form
  var senderForm = document.getElementById('sender-form');
  if (senderForm) senderForm.style.display = 'block';

  // Autopopulate sender bank input
  var bankInput = document.getElementById('sender-bank');
  if (bankInput) {
    if (method === 'dana') bankInput.value = 'DANA';
    else if (method === 'bca') bankInput.value = 'BCA';
    else if (method === 'mandiri') bankInput.value = 'MANDIRI';
    else if (method === 'bni') bankInput.value = 'BNI';
    else if (method === 'qris') bankInput.value = 'QRIS';
  }
  
  validateForm();
  lucide.createIcons();
}

function handleFileSelect(e) {
  var file = e.target.files[0];
  if (!file) return;
  
  hasFile = true;
  
  var reader = new FileReader();
  reader.onload = function(event) {
    document.getElementById('preview-img').src = event.target.result;
    document.getElementById('preview-filename').textContent = file.name;
    document.getElementById('preview-filesize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
    
    document.getElementById('upload-idle').style.display = 'none';
    document.getElementById('upload-preview').style.display = 'flex';
    document.getElementById('upload-zone').style.borderColor = '#10b981';
    document.getElementById('upload-zone').style.background = 'rgba(16, 185, 129, 0.05)';
    
    validateForm();
    lucide.createIcons();
  };
  reader.readAsDataURL(file);
}

function resetFile(e) {
  if (e) {
    e.preventDefault();
    e.stopPropagation();
  }
  
  document.getElementById('proof-file').value = '';
  hasFile = false;
  
  document.getElementById('upload-idle').style.display = 'block';
  document.getElementById('upload-preview').style.display = 'none';
  document.getElementById('upload-zone').style.borderColor = 'rgba(99, 102, 241, 0.3)';
  document.getElementById('upload-zone').style.background = 'rgba(30, 41, 59, 0.2)';
  
  validateForm();
}

// Drag & drop logic
var uploadZone = document.getElementById('upload-zone');
if (uploadZone) {
  ['dragenter', 'dragover'].forEach(eventName => {
    uploadZone.addEventListener(eventName, function(e) {
      e.preventDefault();
      e.stopPropagation();
      highlight();
    }, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    uploadZone.addEventListener(eventName, function(e) {
      e.preventDefault();
      e.stopPropagation();
      unhighlight();
    }, false);
  });

  uploadZone.addEventListener('drop', function(e) {
    var dt = e.dataTransfer;
    var files = dt.files;
    if (files.length) {
      document.getElementById('proof-file').files = files;
      handleFileSelect({ target: { files: files } });
    }
  }, false);
}

function highlight() {
  uploadZone.style.borderColor = '#6366f1';
  uploadZone.style.background = 'rgba(99, 102, 241, 0.1)';
}

function unhighlight() {
  if (hasFile) {
    uploadZone.style.borderColor = '#10b981';
    uploadZone.style.background = 'rgba(16, 185, 129, 0.05)';
  } else {
    uploadZone.style.borderColor = 'rgba(99, 102, 241, 0.3)';
    uploadZone.style.background = 'rgba(30, 41, 59, 0.2)';
  }
}

function copyText(text) {
  navigator.clipboard.writeText(text).then(() => {
    Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Disalin!', showConfirmButton:false, timer:1800, background:'#1e293b', color:'#fff' });
  });
}

function confirmPayment() {
  if (!selectedMethod) return;
  
  var bank = document.getElementById('sender-bank').value.trim();
  var accNum = document.getElementById('sender-account-number').value.trim();
  var accName = document.getElementById('sender-account-name').value.trim();
  var fileInput = document.getElementById('proof-file');
  
  if (!fileInput.files || fileInput.files.length === 0) {
    Swal.fire({ title: 'Error', text: 'Unggah bukti transfer terlebih dahulu!', icon: 'warning', background: '#1e293b', color: '#fff' });
    return;
  }

  Swal.fire({
    title: 'Konfirmasi Pembayaran?',
    html: 'Pastikan data transfer Anda sudah benar. Pengajuan akan segera diverifikasi oleh Admin.',
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Ya, Kirim!',
    cancelButtonText: 'Batal',
    confirmButtonColor: '#6366f1',
    background: '#1e293b',
    color: '#fff',
  }).then(result => {
    if (result.isConfirmed) {
      Swal.fire({
        title: 'Mengunggah Bukti Pembayaran...',
        html: 'Mohon tunggu sebentar.',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
      });

      var formData = new FormData();
      formData.append('bank_name', bank);
      formData.append('account_number', accNum);
      formData.append('account_name', accName);
      formData.append('proof_of_payment', fileInput.files[0]);

      fetch('{{ route("payment.confirm", $rental->id) }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
      })
      .then(r => r.json())
      .then(data => {
        Swal.close();
        if (data.success) {
          Swal.fire({
            title: '🎉 Bukti Terkirim!',
            text: data.message,
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#6366f1',
            background: '#1e293b',
            color: '#fff',
          }).then(() => { window.location.href = data.redirect; });
        } else {
          Swal.fire({
            title: '❌ Gagal',
            text: data.message || 'Terjadi kesalahan saat mengunggah bukti.',
            icon: 'error',
            confirmButtonColor: '#ef4444',
            background: '#1e293b',
            color: '#fff',
          });
        }
      })
      .catch(err => {
        Swal.close();
        Swal.fire({
          title: '❌ Error',
          text: 'Koneksi gagal atau ukuran berkas terlalu besar.',
          icon: 'error',
          confirmButtonColor: '#ef4444',
          background: '#1e293b',
          color: '#fff',
        });
      });
    }
  });
}
</script>
</body>
</html>
