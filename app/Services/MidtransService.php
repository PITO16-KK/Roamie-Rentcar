<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Buat transaksi Midtrans dan dapatkan Snap Token.
     *
     * @param  array  $params
     * @return string  snap_token
     */
    public function createSnapToken(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    /**
     * Handle notifikasi callback dari Midtrans.
     *
     * @return \Midtrans\Notification
     */
    public function handleNotification(): Notification
    {
        return new Notification();
    }

    /**
     * Build parameter transaksi untuk Midtrans.
     *
     * @param  \App\Models\Rental  $rental
     * @param  \App\Models\User    $user
     * @param  float               $totalPrice
     * @return array
     */
    public function buildTransactionParams($rental, $user, float $totalPrice): array
    {
        return [
            'transaction_details' => [
                'order_id'      => 'ROAMIE-' . $rental->id . '-' . time(),
                'gross_amount'  => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name'    => $user->name,
                'email'         => $user->email,
                'phone'         => $user->phone ?? '-',
            ],
            'item_details' => [
                [
                    'id'       => 'CAR-' . $rental->car_id,
                    'price'    => (int) $rental->car->rental_price,
                    'quantity' => $rental->duration_days,
                    'name'     => 'Sewa ' . $rental->car->name . ' (' . $rental->duration_days . ' hari)',
                ],
            ],
            'callbacks' => [
                'finish' => config('app.url') . '/payment/finish',
            ],
        ];
    }
}
