<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use App\Models\Rental;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    /**
     * Update real-time GPS location from browser device.
     */
    public function update(Request $request)
    {
        $request->validate([
            'car_id'    => 'required|exists:cars,id',
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Upsert location record
        $location = VehicleLocation::updateOrCreate(
            ['car_id' => $request->car_id],
            [
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'timestamp' => now(),
            ]
        );

        // Also store in trip history for the active rental of this car
        $rental = Rental::where('car_id', $request->car_id)
            ->whereIn('status', ['on-going', 'approved'])
            ->latest()
            ->first();

        if ($rental) {
            \App\Models\TripHistory::create([
                'rental_id' => $rental->id,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
                'timestamp' => now(),
            ]);
        }

        return response()->json(['success' => true, 'location' => $location]);
    }

    /**
     * Get all current live locations for map polling.
     */
    public function all()
    {
        $rentals = Rental::whereIn('status', ['on-going', 'approved'])
            ->with(['car.location', 'user'])
            ->get()
            ->map(function ($rental) {
                $loc = $rental->car->location;
                return [
                    'car_id'    => $rental->car_id,
                    'car_name'  => $rental->car->name,
                    'user_name' => $rental->user->name,
                    'latitude'  => $loc?->latitude,
                    'longitude' => $loc?->longitude,
                    'updated'   => $loc?->timestamp,
                ];
            })
            ->filter(fn($r) => $r['latitude'] && $r['longitude'])
            ->values();

        return response()->json($rentals);
    }
}
