<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Rental;
use App\Models\VehicleLocation;
use App\Models\TripHistory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
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

        // Statistics (based on start_date)
        $dailyRentals = Rental::whereDate('start_date', now()->toDateString())->count();
        $weeklyRentals = Rental::whereBetween('start_date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()])->count();
        $monthlyRentals = Rental::whereBetween('start_date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])->count();

        // Active Rentals List with User and Car
        $activeRentalsList = Rental::whereIn('status', ['on-going', 'approved'])
            ->with(['car', 'user'])
            ->get();

        // Get latest locations for cars with on-going rentals
        $onGoingCarIds = Rental::whereIn('status', ['on-going', 'approved'])->pluck('car_id');
        $locations = VehicleLocation::whereIn('car_id', $onGoingCarIds)->with('car')->get();

        // Get trip histories for those rentals to draw routes
        $onGoingRentalIds = Rental::whereIn('status', ['on-going', 'approved'])->pluck('id');
        $histories = TripHistory::whereIn('rental_id', $onGoingRentalIds)
            ->orderBy('timestamp', 'asc')
            ->get()
            ->groupBy('rental_id');

        return view('admin.dashboard', compact(
            'totalCars',
            'availableCars',
            'bookedCars',
            'rentedCars',
            'totalUsers',
            'totalTransactions',
            'totalIncome',
            'activeRentals',
            'locations',
            'histories',
            'dailyRentals',
            'weeklyRentals',
            'monthlyRentals',
            'activeRentalsList'
        ));
    }
}
