@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page_title', 'Verifikasi Pembayaran')

@section('styles')
<style>
    .payments-table-container {
        margin-top: 1.5rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        color: var(--text-primary);
        text-align: left;
    }

    th {
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-secondary);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--border);
    }

    td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        font-size: 0.95rem;
        vertical-align: middle;
    }

    tr:hover td {
        background: rgba(255, 255, 255, 0.01);
    }

    /* Status Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .badge-approved {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-rejected {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Action Buttons */
    .btn-action-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        padding: 0.5rem 0.85rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-approve {
        background: var(--success);
        color: #fff;
    }

    .btn-approve:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-reject {
        background: var(--danger);
        color: #fff;
    }

    .btn-reject:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    /* Thumbnail Proof */
    .proof-thumbnail {
        width: 80px;
        height: 60px;
        border-radius: 0.375rem;
        object-fit: cover;
        cursor: pointer;
        border: 1px solid var(--border);
        transition: all 0.2s ease;
    }

    .proof-thumbnail:hover {
        transform: scale(1.05);
        border-color: var(--accent);
    }

    /* Modal Styling */
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(11, 17, 30, 0.9);
        backdrop-filter: blur(8px);
    }

    .modal-content {
        margin: auto;
        display: block;
        max-width: 80%;
        max-height: 80vh;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .close-modal {
        position: absolute;
        top: 20px;
        right: 35px;
        color: var(--text-secondary);
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close-modal:hover,
    .close-modal:focus {
        color: var(--text-primary);
        text-decoration: none;
    }

    /* Info Styles */
    .sub-info {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    .empty-row {
        text-align: center;
        padding: 3rem !important;
        color: var(--text-secondary);
    }
</style>
@endsection

@section('content')
<div class="card payments-table-container">
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Detail Sewa</th>
                    <th>Rekening Pengirim</th>
                    <th>Total Pembayaran</th>
                    <th>Bukti Transfer</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>
                            <strong>{{ $payment->rental->user->name }}</strong>
                            <div class="sub-info">{{ $payment->rental->user->email }}</div>
                            <div class="sub-info">{{ $payment->rental->user->phone ?? '-' }}</div>
                        </td>
                        <td>
                            <strong>{{ $payment->rental->car->name ?? 'Mobil Terhapus' }}</strong>
                            <div class="sub-info">Mulai: {{ $payment->rental->start_date->format('d M Y') }}</div>
                            <div class="sub-info">Durasi: {{ $payment->rental->duration_days }} Hari</div>
                        </td>
                        <td>
                            <strong>{{ $payment->bank_name }}</strong>
                            <div class="sub-info">No. Rek: {{ $payment->account_number }}</div>
                            <div class="sub-info">A.n.: {{ $payment->account_name }}</div>
                        </td>
                        <td>
                            <strong style="color: var(--accent);">Rp {{ number_format($payment->amount) }}</strong>
                        </td>
                        <td>
                            @if($payment->proof_of_payment)
                                <img src="{{ asset('car-images/' . $payment->proof_of_payment) }}" 
                                     alt="Bukti Transfer" 
                                     class="proof-thumbnail" 
                                     onclick="openImageModal(this.src)">
                            @else
                                <span class="sub-info">Tidak ada file</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->status === 'pending')
                                <span class="badge badge-pending">
                                    <i data-lucide="clock" style="width: 14px; height: 14px;"></i> Menunggu Verifikasi
                                </span>
                            @elseif($payment->status === 'approved')
                                <span class="badge badge-approved">
                                    <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i> Lunas
                                </span>
                            @else
                                <span class="badge badge-rejected">
                                    <i data-lucide="x-circle" style="width: 14px; height: 14px;"></i> Ditolak
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($payment->status === 'pending')
                                <div class="btn-action-group">
                                    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" id="approve-form-{{ $payment->id }}">
                                        @csrf
                                        <button type="button" class="btn-action btn-approve" onclick="confirmAction('approve', {{ $payment->id }})">
                                            <i data-lucide="check" style="width: 16px; height: 16px;"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" id="reject-form-{{ $payment->id }}">
                                        @csrf
                                        <button type="button" class="btn-action btn-reject" onclick="confirmAction('reject', {{ $payment->id }})">
                                            <i data-lucide="x" style="width: 16px; height: 16px;"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="sub-info">Selesai diverifikasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">
                            <i data-lucide="inbox" style="width: 48px; height: 48px; stroke-width: 1px; margin-bottom: 0.5rem; color: var(--text-secondary);"></i>
                            <p>Tidak ada data verifikasi pembayaran ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
        {{ $payments->links() }}
    </div>
</div>

<!-- Image Modal Overlay -->
<div id="proofModal" class="image-modal" onclick="closeImageModal()">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="modalImg" onclick="event.stopPropagation()">
</div>
@endsection

@section('scripts')
<script>
    function openImageModal(src) {
        var modal = document.getElementById("proofModal");
        var modalImg = document.getElementById("modalImg");
        modal.style.display = "block";
        modalImg.src = src;
    }

    function closeImageModal() {
        var modal = document.getElementById("proofModal");
        modal.style.display = "none";
    }

    // Close on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            closeImageModal();
        }
    });

    function confirmAction(type, id) {
        const title = type === 'approve' ? 'Setujui Pembayaran?' : 'Tolak Pembayaran?';
        const text = type === 'approve' 
            ? 'Pembayaran akan diverifikasi, booking status disetujui, dan mobil ditandai booked.' 
            : 'Pembayaran akan dibatalkan, booking status ditolak, dan status mobil dibebaskan.';
        const confirmColor = type === 'approve' ? '#10b981' : '#ef4444';

        Swal.fire({
            title: title,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6366f1',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            background: '#151c2c',
            color: '#f8fafc',
            iconColor: confirmColor
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(type + '-form-' + id).submit();
            }
        });
    }
</script>
@endsection
