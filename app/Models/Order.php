<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'userId',
        'storeId',
        'order',
        'storeLat',
        'storeLng',
        'customerLng',
        'customerLat',
        'max_price',
        'min_price',
        'status',
        'isDeleted'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','userId');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store','storeId');
    }

    public function offers(){
        return $this->hasMany('App\Models\Offer','orderId');
    }
}
