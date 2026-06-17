<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use App\Models\TripHistory;
use App\Models\Rental;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    /**
     * Update vehicle location and save to history if active.
     */
    public function update(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Update current location
        $location = VehicleLocation::updateOrCreate(
            ['car_id' => $request->car_id],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'timestamp' => now()
            ]
        );

        // Find on-going or approved rental for this car
        $rental = Rental::where('car_id', $request->car_id)
            ->whereIn('status', ['on-going', 'approved'])
            ->first();

        // If rental is on-going or approved, save to trip history
        if ($rental) {
            TripHistory::create([
                'rental_id' => $rental->id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'timestamp' => now()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Location updated successfully'
        ]);
    }
}
