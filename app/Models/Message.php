<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $fillable = [
        'senderId',
        'receiverId',
        'message',
        'image',
        'channelId',
        'isRead',
    ];


    public function channel(){
        return $this->belongsTo('App\Models\Channel','channelId');
    }
}
