<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Rental;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Check if a car is available for a given date range.
     *
     * @param int $carId
     * @param string $startDate (Y-m-d)
     * @param int $durationDays
     * @return bool
     */
    public function isCarAvailable(int $carId, string $startDate, int $durationDays): bool
    {
        $start = Carbon::parse($startDate);
        $end = $start->copy()->addDays($durationDays);

        // Fetch active rentals for the car
        $activeRentals = Rental::where('car_id', $carId)
            ->whereIn('status', ['booked', 'on-going', 'approved'])
            ->get();

        foreach ($activeRentals as $rental) {
            $rentalStart = Carbon::parse($rental->start_date);
            $rentalEnd = $rentalStart->copy()->addDays((int) $rental->duration_days);

            // Check for overlap
            // (StartA < EndB) and (EndA > StartB)
            if ($start->lt($rentalEnd) && $end->gt($rentalStart)) {
                return false; // Overlap found
            }
        }

        return true; // No overlap
    }
}
