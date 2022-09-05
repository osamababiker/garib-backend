<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'appName',
        'appVersion',
        'phone',
        'email',
        'address',
        'policy',
        'max_price_for_k',
        'min_price_for_k'
    ];
}
