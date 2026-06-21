@extends('layouts.admin')

@section('title', 'Pratinjau Ekspor CSV')
@section('page_title', 'Pratinjau Ekspor CSV')

@section('styles')
<style>
    .preview-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-bar {
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        padding: 1rem 1.25rem;
        border-radius: 0.75rem;
        color: var(--text-primary);
        font-size: 0.9rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 0.75rem;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-download {
        background: var(--accent-gradient);
        color: #fff;
        border: none;
    }

    .btn-download:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .btn-cancel {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: var(--danger);
    }

    .btn-cancel:hover {
        background: var(--danger);
        color: #fff;
        transform: translateY(-1px);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 0.75rem;
        border: 1px solid var(--border);
        background: rgba(30, 41, 59, 0.2);
    }

    .preview-table {
        width: 100%;
        border-collapse: collapse;
        white-space: nowrap;
    }

    .preview-table th, .preview-table td {
        padding: 1rem 1.25rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
        font-size: 0.88rem;
    }

    .preview-table th {
        background: rgba(15, 23, 42, 0.3);
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.75px;
    }

    .preview-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .status-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-ongoing { background: rgba(99, 102, 241, 0.15); color: var(--accent); }
    .status-completed { background: rgba(16, 185, 129, 0.15); color: var(--success); }
    .status-pending { background: rgba(245, 158, 11, 0.15); color: var(--warning); }
</style>
@endsection

@section('content')
<div class="preview-container">
    <div class="info-bar">
        <div>
            <span style="font-weight: 700; color: var(--accent);">📊 Pratinjau Sampel Data:</span>
            <span>Menampilkan {{ $previewRentals->count() }} data sewa pertama dari total {{ $totalCount }} data yang siap diekspor.</span>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">
                <i data-lucide="x-circle" style="width: 16px; height: 16px;"></i> Batal
            </a>
            <a href="{{ route('admin.export.rentals', ['download' => 1]) }}" class="btn btn-download">
                <i data-lucide="download" style="width: 16px; height: 16px;"></i> Unduh CSV
            </a>
        </div>
    </div>

    <div class="card" style="border-color: rgba(255,255,255,0.03);">
        <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;">
            <i data-lucide="table" style="color:var(--accent); width:20px; height:20px;"></i>
            Tampilan Tabel Preview
        </h3>
        
        <div class="table-wrapper">
            <table class="preview-table">
                <thead>
                    <tr>
                        <th>ID Rental</th>
                        <th>Nama Pelanggan</th>
                        <th>Email Pelanggan</th>
                        <th>Nama Mobil</th>
                        <th>Tipe Mobil</th>
                        <th>Harga/Hari (Rp)</th>
                        <th>Tanggal Mulai</th>
                        <th>Durasi (Hari)</th>
                        <th>Total Harga (Rp)</th>
                        <th>Status Sewa</th>
                        <th>Status Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($previewRentals as $rental)
                        @php
                            $totalPrice = ($rental->car->rental_price ?? 0) * $rental->duration_days;
                        @endphp
                        <tr>
                            <td style="font-weight: 700; color: var(--accent);">#{{ $rental->id }}</td>
                            <td>{{ $rental->user->name ?? '-' }}</td>
                            <td style="color: var(--text-secondary);">{{ $rental->user->email ?? '-' }}</td>
                            <td style="font-weight: 600;">{{ $rental->car->name ?? '-' }}</td>
                            <td>{{ $rental->car->type ?? '-' }}</td>
                            <td>Rp {{ number_format($rental->car->rental_price ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $rental->start_date }}</td>
                            <td>{{ $rental->duration_days }} Hari</td>
                            <td style="font-weight: 700; color: var(--success);">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = 'status-pending';
                                    if (in_array(strtolower($rental->status), ['on-going', 'approved', 'active'])) {
                                        $statusClass = 'status-ongoing';
                                    } elseif (strtolower($rental->status) === 'completed' || strtolower($rental->status) === 'done') {
                                        $statusClass = 'status-completed';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ $rental->status }}</span>
                            </td>
                            <td>
                                @if(($rental->payment_status ?? 'unpaid') === 'paid')
                                    <span style="color:#10b981; font-weight:700; font-size:.82rem;">✓ Lunas</span>
                                @else
                                    <span style="color:#f59e0b; font-weight:700; font-size:.82rem;">⏳ Belum Lunas</span>
                                @endif
                            </td>
                            <td style="text-transform: uppercase; font-size: 0.8rem; font-weight: 600;">{{ $rental->payment_method ?? '-' }}</td>
                            <td style="color: var(--text-secondary);">{{ $rental->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" style="text-align:center; color:var(--text-secondary); padding:3rem;">
                                Tidak ada data sewa untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
