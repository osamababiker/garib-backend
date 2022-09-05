<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = "ratings";
    protected $fillable = [
        'review',
        'rating',
        'userId',
        'raterId'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User','userId');
    }

    public function rater(){
        return $this->belongsTo('App\Models\User','raterId');
    }
}
