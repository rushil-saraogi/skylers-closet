<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_body',
        'guest_id',
        'user_id',
        'parent_message_id',
    ];

    public function guest() {
        return $this->belongsTo(Guest::class);  
    }

    public function user() {
        return $this->belongsTo(User::class);  
    }

    public function parent() {
        return $this->belongsTo(Message::class, 'parent_message_id');  
    }

    public function replies() {
        return $this->hasMany(Message::class, 'parent_message_id');  
    }
}
