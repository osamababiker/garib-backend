<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plaint extends Model
{
    use HasFactory;

    protected $table = "plaints";
    protected $fillable = [
        'userId',
        'plaint',
        'isClosed'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','userId');
    }

}
