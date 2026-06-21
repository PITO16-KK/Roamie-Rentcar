<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    /**
     * Get statistics for the admin dashboard.
     */
    public function index()
    {
        // 1. Sync rental and vehicle statuses automatically
        Rental::syncStatuses();

        // 2. Fetch fresh statistics
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $bookedCars = Car::where('status', 'booked')->count();
        $rentedCars = Car::where('status', 'on-going')->count();

        $totalUsers = User::count();
        $totalTransactions = Rental::count();
        $totalIncome = Rental::where('payment_status', 'paid')->sum('total_price');

        $activeRentals = Rental::whereIn('status', ['on-going', 'approved'])->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_cars' => $totalCars,
                'available_cars' => $availableCars,
                'booked_cars' => $bookedCars,
                'rented_cars' => $rentedCars,
                'total_users' => $totalUsers,
                'total_transactions' => $totalTransactions,
                'total_income' => $totalIncome,
                'active_rentals' => $activeRentals
            ]
        ]);
    }
}
