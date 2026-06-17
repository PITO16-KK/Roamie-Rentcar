<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentVerificationController extends Controller
{
    /**
     * Tampilkan daftar verifikasi pembayaran
     */
    public function index()
    {
        $payments = Payment::with(['rental.user', 'rental.car'])
            ->orderByRaw("CASE WHEN status = 'pending' THEN 1 ELSE 2 END")
            ->latest()
            ->paginate(10);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Approve Pembayaran
     */
    public function approve(Payment $payment)
    {
        try {
            DB::transaction(function () use ($payment) {
                // 1. Update status pembayaran
                $payment->update(['status' => 'approved']);

                // 2. Update status rental
                $rental = $payment->rental;
                $rental->update([
                    'payment_status' => 'paid',
                    'status'         => 'approved',
                ]);

                // 3. Update status mobil
                if ($rental->car) {
                    $rental->car->update(['status' => 'booked']);
                }
            });

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil disetujui! Status booking dan mobil telah diperbarui.');
        } catch (\Exception $e) {
            Log::error('Admin Payment Approve Error: ' . $e->getMessage());
            return redirect()->route('admin.payments.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject Pembayaran
     */
    public function reject(Payment $payment)
    {
        try {
            DB::transaction(function () use ($payment) {
                // 1. Update status pembayaran
                $payment->update(['status' => 'rejected']);

                // 2. Update status rental
                $rental = $payment->rental;
                $rental->update([
                    'payment_status' => 'rejected',
                    'status'         => 'rejected',
                ]);

                // 3. Bebaskan status mobil kembali menjadi 'available'
                if ($rental->car) {
                    $rental->car->update(['status' => 'available']);
                }
            });

            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran ditolak. Status booking dibatalkan dan mobil tersedia kembali.');
        } catch (\Exception $e) {
            Log::error('Admin Payment Reject Error: ' . $e->getMessage());
            return redirect()->route('admin.payments.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
