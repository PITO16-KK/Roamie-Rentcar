<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Car;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class RentalApiController extends Controller
{
    protected $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Create a new rental booking.
     */
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'duration_days' => 'required|integer|min:1',
        ]);

        // Check availability
        $isAvailable = $this->availabilityService->isCarAvailable(
            $request->car_id,
            $request->start_date,
            $request->duration_days
        );

        if (!$isAvailable) {
            return response()->json([
                'status' => 'error',
                'message' => 'Car is not available for the selected dates.'
            ], 422);
        }

        $car = Car::findOrFail($request->car_id);
        $totalPrice = $car->rental_price * $request->duration_days;

        // Create rental
        $rental = Rental::create([
            'car_id' => $car->id,
            'user_id' => $request->user()->id,
            'start_date' => $request->start_date,
            'duration_days' => $request->duration_days,
            'status' => 'booked',
            'payment_status' => 'unpaid',
            'total_price' => $totalPrice,
        ]);

        // Update car status to booked
        $car->update(['status' => 'booked']);

        return response()->json([
            'status' => 'success',
            'message' => 'Rental created successfully',
            'data' => $rental
        ], 201);
    }
}
