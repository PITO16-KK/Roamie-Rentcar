@extends('layouts.admin')

@section('title', 'Tambah Mobil')
@section('page_title', 'Tambah Mobil Baru')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid var(--glass-border);
        color: var(--text-primary);
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--accent);
        background: rgba(30, 41, 59, 0.8);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        font-size: 1rem;
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
        margin-right: 0.5rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 1.5rem;
    }

    .section-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--accent);
        margin: 1.5rem 0 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(99,102,241,0.15);
    }

    .error-text {
        color: #ef4444;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }
</style>
@endsection

@section('content')
<div class="card" style="max-width: 750px; margin: 0 auto;">
    <h2 style="margin-bottom: 1.5rem;">Input Data Mobil</h2>

    @if($errors->any())
        <div style="background: rgba(239,68,68,0.1); border: 1px solid #ef4444; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; color: #ef4444;">
            <strong>Terdapat kesalahan pada form:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <p class="section-label">Informasi Dasar</p>
        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nama Mobil *</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Contoh: Toyota Avanza" value="{{ old('name') }}" required>
                @error('name') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="type">Tipe / Kategori *</label>
                <input type="text" id="type" name="type" class="form-control" placeholder="Contoh: MPV, SUV, Sedan" value="{{ old('type') }}" required>
                @error('type') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="rental_price">Harga Sewa Per Hari (Rp) *</label>
                <input type="number" id="rental_price" name="rental_price" class="form-control" placeholder="Contoh: 350000" value="{{ old('rental_price') }}" required>
                @error('rental_price') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="status">Status Awal *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="booked" {{ old('status') == 'booked' ? 'selected' : '' }}>Di-Booking</option>
                    <option value="on-going" {{ old('status') == 'on-going' ? 'selected' : '' }}>Sedang Disewa</option>
                </select>
                @error('status') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <p class="section-label">Spesifikasi Kendaraan</p>
        <div class="form-grid">
            <div class="form-group">
                <label for="gearbox">Transmisi</label>
                <input type="text" id="gearbox" name="gearbox" class="form-control" placeholder="Contoh: Automatic / Manual" value="{{ old('gearbox') }}">
                @error('gearbox') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="seats">Jumlah Kursi</label>
                <input type="number" id="seats" name="seats" class="form-control" placeholder="Contoh: 7" min="1" value="{{ old('seats') }}">
                @error('seats') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="engine">Mesin / Bahan Bakar</label>
                <input type="text" id="engine" name="engine" class="form-control" placeholder="Contoh: 1500cc Bensin" value="{{ old('engine') }}">
                @error('engine') <div class="error-text">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="year">Tahun Produksi</label>
                <input type="number" id="year" name="year" class="form-control" placeholder="Contoh: 2022" min="1990" max="{{ date('Y') }}" value="{{ old('year') }}">
                @error('year') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi Mobil</label>
            <textarea id="description" name="description" class="form-control" placeholder="Tuliskan deskripsi singkat tentang mobil ini...">{{ old('description') }}</textarea>
            @error('description') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <p class="section-label">Foto Kendaraan</p>
        <div class="form-group">
            <label for="image">Upload Foto (JPG, PNG, max 2MB)</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
            @error('image') <div class="error-text">{{ $message }}</div> @enderror
            <img id="image-preview" src="" alt="Preview" style="margin-top: 1rem; max-width: 100%; max-height: 200px; border-radius: 0.5rem; display: none; object-fit: cover;">
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 2rem;">
            <a href="{{ route('admin.cars.index') }}" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Mobil</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
@endsection
