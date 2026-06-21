<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'type', 'plate_number', 'rental_price', 'status', 'image', 'description', 'gearbox', 'seats', 'engine', 'year'])]
class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory;

    protected $appends = ['harga_per_hari'];

    public function getHargaPerHariAttribute()
    {
        return $this->rental_price;
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function location()
    {
        return $this->hasOne(VehicleLocation::class);
    }
}
