<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\PaymentUploadedNotification;

class PaymentController extends Controller
{
    /**
     * [POST] /api/payment/upload-proof
     * Upload bukti transfer manual dari aplikasi mobile
     */
    public function uploadProof(Request $request)
    {
        $request->validate([
            'rental_id'        => 'required|exists:rentals,id',
            'bank_name'        => 'required|string|max:255',
            'account_number'   => 'required|string|max:50',
            'account_name'     => 'required|string|max:255',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $rental = Rental::findOrFail($request->rental_id);

                // Pastikan hanya customer pemilik rental yang mengunggah
                if ((int)$request->user()->id !== (int)$rental->user_id) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Anda tidak memiliki otorisasi untuk melakukan pembayaran sewa ini.'
                    ], 403);
                }

                // Upload file bukti transfer ke public storage
                if ($request->hasFile('proof_of_payment')) {
                    $file = $request->file('proof_of_payment');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $filePath = $file->storeAs('payment_proofs', $filename, 'public');
                } else {
                    return response()->json([
                        'status'  => 'error',
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
                    Log::error('Gagal mengirim email notifikasi ke admin: ' . $mailEx->getMessage());
                }

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.',
                    'data'    => [
                        'payment' => $payment,
                        'rental'  => $rental->fresh(['car', 'user']),
                    ]
                ], 200);
            });
        } catch (\Exception $e) {
            Log::error('Payment uploadProof error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengunggah bukti pembayaran: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * [GET] /api/payment/status/{rentalId}
     * Cek status pembayaran dan ambil petunjuk transfer manual
     */
    public function status(Request $request, int $rentalId)
    {
        $rental = Rental::with(['car', 'user', 'payment'])->findOrFail($rentalId);

        // Pastikan hanya pemilik atau admin yang bisa mengakses
        if ($request->user()->role !== 'admin' && (int)$rental->user_id !== (int)$request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Akses ditolak.'], 403);
        }

        // Siapkan detail rekening tujuan transfer
        $bankDetails = [
            'bank_name'      => 'Bank Mandiri',
            'account_number' => '123-456-789-0',
            'account_name'   => 'PT Roamie Rent Car',
        ];

        return response()->json([
            'status' => 'success',
            'data'   => [
                'rental_id'       => $rental->id,
                'car'             => $rental->car->name ?? null,
                'car_image'       => $rental->car->image ?? null,
                'duration_days'   => $rental->duration_days,
                'total_price'     => $rental->total_price,
                'payment_status'  => $rental->payment_status,
                'payment_method'  => $rental->payment_method ?? 'manual_bank_transfer',
                'rental_status'   => $rental->status,
                'bank_details'    => $bankDetails,
                'payment_details' => $rental->payment ? [
                    'id'               => $rental->payment->id,
                    'bank_name'        => $rental->payment->bank_name,
                    'account_number'   => $rental->payment->account_number,
                    'account_name'     => $rental->payment->account_name,
                    'amount'           => $rental->payment->amount,
                    'status'           => $rental->payment->status,
                    'proof_of_payment' => asset('car-images/' . $rental->payment->proof_of_payment),
                    'created_at'       => $rental->payment->created_at->toDateTimeString(),
                ] : null,
            ],
        ]);
    }

    /**
     * [GET] /api/my-rentals
     * Daftar rental milik user dengan status pembayaran manual
     */
    public function myRentals(Request $request)
    {
        $rentals = Rental::with(['car', 'payment'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get()
            ->map(function ($rental) {
                return [
                    'rental_id'      => $rental->id,
                    'order_id'       => $rental->order_id ?? ('ROA-' . $rental->id),
                    'car'            => $rental->car ? [
                        'id'           => $rental->car->id,
                        'name'         => $rental->car->name,
                        'rental_price' => $rental->car->rental_price,
                        'image'        => $rental->car->image ? (filter_var($rental->car->image, FILTER_VALIDATE_URL) ? $rental->car->image : asset('car-images/' . $rental->car->image)) : null,
                    ] : null,
                    'start_date'     => $rental->start_date->format('Y-m-d'),
                    'duration_days'  => $rental->duration_days,
                    'total_price'    => $rental->total_price,
                    'payment_status' => $rental->payment_status,
                    'payment_method' => $rental->payment_method ?? 'manual_bank_transfer',
                    'rental_status'  => $rental->status,
                    'payment_details'=> $rental->payment ? [
                        'bank_name'        => $rental->payment->bank_name,
                        'account_number'   => $rental->payment->account_number,
                        'account_name'     => $rental->payment->account_name,
                        'status'           => $rental->payment->status,
                        'proof_of_payment' => asset('car-images/' . $rental->payment->proof_of_payment),
                    ] : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $rentals,
        ]);
    }

    /**
     * [POST] /api/payment/token
     * Generate Midtrans Snap Token untuk pembayaran online di aplikasi mobile
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'rentalId' => 'required',
        ]);

        try {
            // Bersihkan rentalId dari karakter '#' jika dikirimkan oleh Ionic
            $rentalId = $request->rentalId;
            if (str_starts_with($rentalId, '#')) {
                $rentalId = substr($rentalId, 1);
            }

            $rental = Rental::with(['car', 'user'])->findOrFail($rentalId);
            $user = $request->user();

            // Pastikan rental ini milik user yang sedang login
            if ((int)$rental->user_id !== (int)$user->id) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Anda tidak memiliki otorisasi untuk mengakses pembayaran sewa ini.'
                ], 403);
            }

            // Inisialisasi MidtransService
            $midtransService = new \App\Services\MidtransService();
            
            // Build parameters
            $params = $midtransService->buildTransactionParams($rental, $user, $rental->total_price);
            
            // Generate Snap Token
            $snapToken = $midtransService->createSnapToken($params);

            // Simpan order_id Midtrans ke rental
            $rental->update([
                'order_id'       => $params['transaction_details']['order_id'],
                'payment_method' => 'midtrans',
            ]);

            return response()->json([
                'token' => $snapToken
            ], 200);

        } catch (\Exception $e) {
            Log::error('API getSnapToken error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menginisialisasi pembayaran Midtrans: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * [POST] /api/payment/notification
     * Handle webhook notification dari Midtrans
     */
    public function notification(Request $request)
    {
        try {
            $midtransService = new \App\Services\MidtransService();
            $notification = $midtransService->handleNotification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;

            // Extract rental ID dari order_id (format: ROAMIE-{rental_id}-{timestamp})
            $rental = null;
            if (str_starts_with($orderId, 'ROAMIE-')) {
                $parts = explode('-', $orderId);
                if (isset($parts[1])) {
                    $rentalId = $parts[1];
                    $rental = Rental::find($rentalId);
                }
            } else {
                $rental = Rental::where('order_id', $orderId)->first();
            }

            if (!$rental) {
                Log::warning('Midtrans Webhook: Rental tidak ditemukan untuk order_id: ' . $orderId);
                return response()->json(['message' => 'Rental not found'], 404);
            }

            // Handle status transaksi
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($notification->fraud_status == 'challenge') {
                        $rental->update(['payment_status' => 'pending']);
                    } else {
                        $rental->update(['payment_status' => 'paid']);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $rental->update(['payment_status' => 'paid']);
            } elseif ($transactionStatus == 'pending') {
                $rental->update(['payment_status' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $rental->update(['payment_status' => 'unpaid']);
            }

            return response()->json(['message' => 'Notification handled successfully'], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
