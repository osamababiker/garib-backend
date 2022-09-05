<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverPayment extends Model
{
    use HasFactory;

    protected $table = "driver_payments";
    protected $fillable = [
        'amount',
        'driverId'
    ];
}
