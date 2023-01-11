<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'room_id',
        'starts_at',
        'ends_at',
    ];

    public function guest() {
        return $this->belongsTo(Guest::class);  
    }

    public function room() {
        return $this->belongsTo(Room::class);  
    }
}
