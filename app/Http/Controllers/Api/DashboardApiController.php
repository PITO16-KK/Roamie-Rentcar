<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    /**
     * Get statistics for the admin dashboard.
     */
    public function index()
    {
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $bookedCars = Car::where('status', 'booked')->count();
        $activeRentals = Rental::whereIn('status', ['on-going', 'approved'])->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_cars' => $totalCars,
                'available_cars' => $availableCars,
                'booked_cars' => $bookedCars,
                'active_rentals' => $activeRentals
            ]
        ]);
    }
}
