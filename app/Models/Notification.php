<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $fillable = [
        'channelId',
        'receiverId',
        'title',
        'body',
        'isDeleted'
    ];

    public function channel(){
        return $this->belongsTo('App\Models\Channel','channelId');
    }
}
