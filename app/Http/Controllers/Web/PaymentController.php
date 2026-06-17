<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentUploadedNotification;

class PaymentController extends Controller
{
    /**
     * Halaman pembayaran — tampilkan detail rental + form transfer bank manual.
     */
    public function show($rental_id)
    {
        $rental = Rental::with(['car', 'user', 'payment'])
            ->where('user_id', Auth::id())
            ->findOrFail($rental_id);

        return view('payment', compact('rental'));
    }

    /**
     * Halaman finish — legacy dari Midtrans (tetap dipertahankan agar tidak error).
     */
    public function finish(Request $request)
    {
        $orderId           = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        $rental = null;
        if ($orderId) {
            $rental = Rental::with('car')
                ->where('order_id', $orderId)
                ->where('user_id', Auth::id())
                ->first();
        }

        $status  = 'pending';
        $message = 'Pembayaran Anda sedang diproses.';

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $status  = 'success';
            $message = 'Pembayaran berhasil! Selamat menikmati perjalanan Anda.';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'])) {
            $status  = 'failed';
            $message = 'Pembayaran gagal atau dibatalkan. Silakan coba lagi.';
        }

        return view('payment-finish', compact('rental', 'status', 'message', 'transactionStatus'));
    }

    /**
     * Konfirmasi pembayaran manual dengan unggah bukti transfer.
     */
    public function confirm(Request $request, $rental_id)
    {
        $request->validate([
            'bank_name'        => 'required|string|max:255',
            'account_number'   => 'required|string|max:50',
            'account_name'     => 'required|string|max:255',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $rental = Rental::where('user_id', Auth::id())->findOrFail($rental_id);

        try {
            return DB::transaction(function () use ($request, $rental) {
                // Upload file bukti transfer ke public storage
                if ($request->hasFile('proof_of_payment')) {
                    $file = $request->file('proof_of_payment');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('payment_proofs', $filename, 'public');
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'File bukti transfer wajib diunggah.'
                    ], 422);
                }

                // Cari atau buat Payment
                $payment = Payment::updateOrCreate(
                    ['rental_id' => $rental->id],
                    [
                        'bank_name'        => $request->bank_name,
                        'account_number'   => $request->account_number,
                        'account_name'     => $request->account_name,
                        'amount'           => $rental->total_price,
                        'proof_of_payment' => $filePath,
                        'status'           => 'pending',
                    ]
                );

                // Update status rental
                $rental->update([
                    'payment_status' => 'pending', // Menunggu Verifikasi
                    'payment_method' => 'manual_bank_transfer',
                ]);

                // Kirim notifikasi email ke Admin secara aman (try-catch)
                try {
                    Mail::to('zytraxo05@gmail.com')->send(new PaymentUploadedNotification($payment));
                } catch (\Exception $mailEx) {
                    Log::error('Web Payment confirm: Gagal mengirim email notifikasi ke admin: ' . $mailEx->getMessage());
                }

                return response()->json([
                    'success'  => true,
                    'message'  => 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.',
                    'redirect' => route('profile'),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Web Payment confirm error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan invoice pembayaran untuk customer yang sudah lunas.
     */
    public function invoice(Request $request, $rental_id)
    {
        $userId = Auth::id();

        if (!$userId && $request->has('token')) {
            $tokenStr = $request->query('token');
            $token = \Laravel\Sanctum\PersonalAccessToken::findToken($tokenStr);
            if ($token && $token->tokenable) {
                $userId = $token->tokenable->id;
            }
        }

        if (!$userId) {
            abort(401, 'Unauthorized.');
        }

        $rental = Rental::with(['car', 'user', 'payment'])
            ->where('user_id', $userId)
            ->findOrFail($rental_id);

        if (strtolower($rental->payment_status) !== 'paid') {
            abort(403, 'Invoice hanya tersedia untuk pembayaran yang telah lunas.');
        }

        return view('invoice', compact('rental'));
    }
}

