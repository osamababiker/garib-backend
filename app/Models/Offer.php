<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = [
        'offer',
        'customerId',
        'driverId',
        'orderId',
        'status',
        'isDeleted'
    ];

    public function customer(){
        return $this->belongsTo('App\Models\User','customerId');
    }

    public function driver(){
        return $this->belongsTo('App\Models\User','driverId');
    }

    public function order(){
        return $this->belongsTo('App\Models\Order','orderId');
    }
}
