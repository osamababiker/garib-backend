<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $table = "drivers";
    protected $fillable = [
        'userId',
        'name',
        'phone',
        'address',
        'transportType',
        'licenseImage',
        'transportImage',
        'isAccepted'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','userId');
    }

    public function offers(){
        return $this->hasMany('App\Models\Offer','driverId');
    }
}
