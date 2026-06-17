<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'bank_name',
        'account_number',
        'account_name',
        'amount',
        'proof_of_payment',
        'status',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
