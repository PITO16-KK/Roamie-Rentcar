<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    /** @use HasFactory<\Database\Factories\RentalFactory> */
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'start_date',
        'duration_days',
        'status',
        'payment_status',
        'payment_method',
        'order_id',
        'snap_token',
        'total_price',
    ];

    protected $casts = [
        'car_id'        => 'integer',
        'user_id'       => 'integer',
        'start_date'    => 'date',
        'duration_days' => 'integer',
        'total_price'   => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tripHistories()
    {
        return $this->hasMany(TripHistory::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Synchronize rental and car statuses based on start_date and duration_days.
     */
    public static function syncStatuses(): void
    {
        $today = now()->toDateString();

        // 1. Approved rentals that have started: transition to 'on-going'
        $startingRentals = self::where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->get();

        foreach ($startingRentals as $rental) {
            $rental->update(['status' => 'on-going']);
            if ($rental->car && $rental->car->status !== 'on-going') {
                $rental->car->update(['status' => 'on-going']);
            }
        }

        // 2. Ongoing or approved rentals that have ended: transition to 'completed'
        $activeRentals = self::whereIn('status', ['on-going', 'approved'])->get();

        foreach ($activeRentals as $rental) {
            $endDate = \Carbon\Carbon::parse($rental->start_date)->addDays($rental->duration_days)->toDateString();
            if ($today >= $endDate) {
                $rental->update(['status' => 'completed']);
                if ($rental->car) {
                    $hasUpcomingRentals = self::where('car_id', $rental->car_id)
                        ->whereIn('status', ['booked', 'approved', 'on-going'])
                        ->where('id', '!=', $rental->id)
                        ->exists();

                    if (!$hasUpcomingRentals) {
                        $rental->car->update(['status' => 'available']);
                    } else {
                        $rental->car->update(['status' => 'booked']);
                    }
                }
            }
        }
    }
}
