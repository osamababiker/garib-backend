<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $table = "channels";
    protected $fillable = [
        'storeId',
        'orderId',
        'customerId',
        'driverId',
        'hasBill',
        'hasCompleted',
        'confirmCompleted',
        'isDeleted'
    ];

    public function messages(){
        return $this->hasMany('App\Models\Message','channelId');
    }


}
