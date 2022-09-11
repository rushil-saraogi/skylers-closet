<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_body',
        'closet_id',
        'user_id',
        'parent_message_id',
        'item_id'
    ];

    public function closet() {
        return $this->belongsTo(Closet::class);  
    }

    public function item() {
        return $this->belongsTo(Item::class);  
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
