<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    protected AvailabilityService $availability;

    public function __construct(AvailabilityService $availability)
    {
        $this->availability = $availability;
    }

    public function book(Request $request, $id)
    {
        $request->validate([
            'start_date'    => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1|max:30',
        ]);

        $car = Car::findOrFail($id);

        if ($car->status !== 'available') {
            return back()->with('error', 'Mobil ini sudah tidak tersedia.');
        }

        // Cek ketersediaan tanggal
        $isAvailable = $this->availability->isCarAvailable(
            $car->id,
            $request->start_date,
            $request->duration_days
        );

        if (! $isAvailable) {
            return back()->with('error', 'Mobil tidak tersedia untuk tanggal yang dipilih.');
        }

        try {
            return DB::transaction(function () use ($request, $car) {
                $user       = Auth::user();
                $totalPrice = $car->rental_price * $request->duration_days;

                // Buat rental
                $rental = Rental::create([
                    'car_id'         => $car->id,
                    'user_id'        => $user->id,
                    'start_date'     => $request->start_date,
                    'duration_days'  => $request->duration_days,
                    'status'         => 'booked',
                    'payment_status' => 'unpaid',
                    'total_price'    => $totalPrice,
                ]);

                $orderId = 'ROAMIE-' . $rental->id . '-' . time();

                // Simpan order_id
                $rental->update([
                    'order_id'   => $orderId,
                ]);

                // Update status mobil
                $car->update(['status' => 'booked']);

                return redirect()->route('payment.show', $rental->id)
                    ->with('success', 'Booking berhasil! Silakan selesaikan pembayaran.');
            });
        } catch (\Exception $e) {
            Log::error('Booking database transaction error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat booking: ' . $e->getMessage());
        }
    }
}
