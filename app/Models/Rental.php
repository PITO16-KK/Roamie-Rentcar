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
}
