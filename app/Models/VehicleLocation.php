<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['car_id', 'latitude', 'longitude', 'timestamp'])]
class VehicleLocation extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleLocationFactory> */
    use HasFactory;

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
