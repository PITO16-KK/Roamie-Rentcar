<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['rental_id', 'latitude', 'longitude', 'timestamp'])]
class TripHistory extends Model
{
    /** @use HasFactory<\Database\Factories\TripHistoryFactory> */
    use HasFactory;

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
