<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice - {{ $rental->order_id }}</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
:root {
    --primary: #6366f1;
    --primary-dark: #4f46e5;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --success: #10b981;
    --border: #e2e8f0;
    --bg-light: #f8fafc;
}
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
body {
    background-color: #f1f5f9;
    color: var(--text-main);
    line-height: 1.5;
    padding: 2rem 1.5rem;
}
.invoice-wrapper {
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    border: 1px solid var(--border);
    overflow: hidden;
    position: relative;
}
.action-bar {
    max-width: 800px;
    margin: 0 auto 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 0.75rem;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
}
.btn-back {
    background: transparent;
    color: var(--text-muted);
    border: 1px solid var(--border);
}
.btn-back:hover {
    color: var(--text-main);
    background: #e2e8f0;
}
.btn-print {
    background: var(--primary);
    color: #fff;
}
.btn-print:hover {
    background: var(--primary-dark);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25);
}

/* Header */
.invoice-header {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #fff;
    padding: 2.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.logo-area h1 {
    font-size: 1.75rem;
    font-weight: 800;
    letter-spacing: 2px;
    background: linear-gradient(135deg, #a5b4fc 0%, #818cf8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.logo-area p {
    font-size: 0.8rem;
    color: #94a3b8;
    margin-top: 0.25rem;
}
.invoice-title-area {
    text-align: right;
}
.invoice-title-area h2 {
    font-size: 1.5rem;
    font-weight: 800;
    letter-spacing: 1px;
    margin-bottom: 0.25rem;
}
.invoice-title-area p {
    font-size: 0.85rem;
    color: #94a3b8;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    padding: 2.5rem;
    border-bottom: 1px solid var(--border);
}
.info-col h3 {
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    margin-bottom: 0.75rem;
}
.info-col p {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}
.info-col strong {
    font-weight: 700;
    font-size: 1rem;
}
.badge-paid {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background-color: rgba(16, 185, 129, 0.1);
    color: var(--success);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 2rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.5rem;
}

/* Table */
.details-section {
    padding: 0 2.5rem 2.5rem;
}
.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}
.invoice-table th {
    background-color: var(--bg-light);
    color: var(--text-muted);
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 2px solid var(--border);
}
.invoice-table td {
    padding: 1.25rem 1rem;
    font-size: 0.9rem;
    border-bottom: 1px solid var(--border);
}
.text-right {
    text-align: right !important;
}

/* Pricing Summary */
.summary-wrapper {
    display: flex;
    justify-content: flex-end;
    padding: 0 2.5rem 2.5rem;
}
.summary-box {
    width: 320px;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    font-size: 0.9rem;
}
.summary-row.grand-total {
    border-top: 2px solid var(--border);
    margin-top: 0.5rem;
    padding-top: 0.75rem;
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--primary);
}

/* Footer decoration */
.invoice-footer {
    background-color: var(--bg-light);
    padding: 2rem 2.5rem;
    border-top: 1px solid var(--border);
    text-align: center;
}
.invoice-footer p {
    font-size: 0.8rem;
    color: var(--text-muted);
}
.invoice-footer .verified-text {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--success);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    margin-bottom: 0.5rem;
}

/* Stamp Watermark */
.paid-stamp {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-15deg);
    border: 4px dashed var(--success);
    color: var(--success);
    font-size: 2.5rem;
    font-weight: 900;
    padding: 0.5rem 1.5rem;
    border-radius: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 4px;
    opacity: 0.12;
    pointer-events: none;
}

/* Print Overrides */
@media print {
    body {
        background: #fff;
        padding: 0;
    }
    .action-bar {
        display: none;
    }
    .invoice-wrapper {
        border: none;
        box-shadow: none;
        max-width: 100%;
    }
    .invoice-header {
        background: #f8fafc !important;
        color: #000 !important;
        border-bottom: 2px solid #000;
    }
    .logo-area h1 {
        background: none;
        -webkit-text-fill-color: initial;
        color: #000 !important;
    }
    .logo-area p, .invoice-title-area p {
        color: #475569 !important;
    }
    .invoice-title-area h2 {
        color: #000 !important;
    }
    .summary-row.grand-total {
        color: #000 !important;
    }
}
</style>
</head>
<body>

<div class="action-bar">
    <a href="{{ route('profile') }}" class="btn btn-back">
        <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali ke Profil
    </a>
    <button onclick="window.print()" class="btn btn-print">
        <i data-lucide="printer" style="width: 16px; height: 16px;"></i> Cetak PDF / Invoice
    </button>
</div>

<div class="invoice-wrapper">
    <!-- Stamp Watermark -->
    <div class="paid-stamp">LUNAS - PAID</div>

    <!-- Header -->
    <div class="invoice-header">
        <div class="logo-area">
            <h1>ROAMIE</h1>
            <p>Sewa Mobil Pintar &amp; Premium</p>
        </div>
        <div class="invoice-title-area">
            <h2>INVOICE</h2>
            <p>No: {{ $rental->order_id }}</p>
            <p>Tanggal Terbit: {{ $rental->payment ? $rental->payment->updated_at->format('d M Y') : date('d M Y') }}</p>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div class="info-col">
            <h3>DIBAYAR OLEH</h3>
            <p><strong>{{ $rental->user->name }}</strong></p>
            <p>{{ $rental->user->email }}</p>
            <p>{{ $rental->user->phone ?? '-' }}</p>
            <p style="font-size: 0.82rem; color: var(--text-muted); margin-top: 0.25rem;">
                {{ $rental->user->address ?? 'Alamat belum diisi' }}
            </p>
        </div>
        <div class="info-col">
            <h3>DETAIL METODE PEMBAYARAN</h3>
            <p>Manual Bank Transfer</p>
            @if($rental->payment)
                <p>Pengirim: <strong>{{ $rental->payment->account_name }}</strong></p>
                <p>Bank: {{ strtoupper($rental->payment->bank_name) }}</p>
                <p>No. Rekening: {{ $rental->payment->account_number }}</p>
            @endif
            <div>
                <span class="badge-paid">
                    <i data-lucide="check" style="width:12px; height:12px;"></i> Lunas / Terverifikasi
                </span>
            </div>
        </div>
    </div>

    <!-- Details Table -->
    <div class="details-section">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Deskripsi Sewa</th>
                    <th>Periode Sewa</th>
                    <th class="text-right">Harga / Hari</th>
                    <th class="text-right">Durasi</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $rental->car->name }}</strong><br>
                        <span style="font-size: 0.78rem; color: var(--text-muted);">Tipe: {{ $rental->car->type }} &bull; Plat: {{ $rental->car->plate_number ?? '-' }}</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($rental->start_date)->addDays((int) $rental->duration_days)->format('d M Y') }}
                    </td>
                    <td class="text-right">Rp {{ number_format($rental->car->rental_price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $rental->duration_days }} Hari</td>
                    <td class="text-right">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Summary Box -->
    <div class="summary-wrapper">
        <div class="summary-box">
            <div class="summary-row">
                <span style="color: var(--text-muted);">Subtotal Sewa</span>
                <span>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span style="color: var(--text-muted);">Biaya Layanan &amp; Pajak</span>
                <span>Rp 0</span>
            </div>
            <div class="summary-row grand-total">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="invoice-footer">
        <div class="verified-text">
            <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
            Verified Payment &bull; ROAMIE RENTCAR
        </div>
        <p>Invoice ini diterbitkan secara sah dan diakui sebagai bukti pembayaran resmi yang sah di platform ROAMIE.</p>
        <p style="margin-top: 0.25rem;">Semoga perjalanan Anda aman dan menyenangkan!</p>
    </div>
</div>

<script>
lucide.createIcons();
</script>
</body>
</html>
