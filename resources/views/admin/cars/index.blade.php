@extends('layouts.admin')

@section('title', 'Daftar Mobil')
@section('page_title', 'Manajemen Mobil')

@section('styles')
<style>
    .cars-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .cars-table th, .cars-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }

    .cars-table th {
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }

    .cars-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 0.9rem;
    }

    .btn-primary {
        background: var(--accent-gradient);
        color: white;
    }

    .btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: rgba(148, 163, 184, 0.1);
        color: var(--text-primary);
        border: 1px solid var(--border);
    }

    .btn-danger {
        background: rgba(239, 68, 68, 0.2);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        background: var(--danger);
        color: white;
    }

    .action-links {
        display: flex;
        gap: 0.5rem;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }
    .status-available { background: rgba(16, 185, 129, 0.2); color: var(--success); }
    .status-booked { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
    .status-ongoing { background: rgba(99, 102, 241, 0.2); color: var(--accent); }
</style>
@endsection

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2>Armada Mobil</h2>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">+ Tambah Mobil</a>
    </div>

    <table class="cars-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Mobil</th>
                <th>Plat Nomor</th>
                <th>Tipe</th>
                <th>Harga Sewa / Hari</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cars as $car)
                <tr>
                    <td>#{{ $car->id }}</td>
                    <td style="font-weight: 600;">{{ $car->name }}</td>
                    <td>
                        <code style="font-family: monospace; font-weight: 700; background: rgba(255, 255, 255, 0.05); padding: 0.25rem 0.6rem; border-radius: 0.35rem; border: 1px solid rgba(255, 255, 255, 0.05); font-size: 0.85rem; color: var(--accent);">
                            {{ $car->plate_number ?? '-' }}
                        </code>
                    </td>
                    <td>{{ $car->type }}</td>
                    <td>Rp {{ number_format($car->rental_price, 0, ',', '.') }}</td>
                    <td>
                        @if($car->status == 'available')
                            <span class="status-badge status-available">Tersedia</span>
                        @elseif($car->status == 'booked')
                            <span class="status-badge status-booked">Di-Booking</span>
                        @else
                            <span class="status-badge status-ongoing">Sedang Disewa</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-links">
                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-secondary">Edit</a>
                            <button class="btn btn-danger" onclick="confirmDelete({{ $car->id }})">Hapus</button>
                            <form id="delete-form-{{ $car->id }}" action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                        Belum ada mobil yang terdaftar.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
