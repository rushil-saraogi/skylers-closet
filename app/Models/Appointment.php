<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'trip_id',
    ];

    public function item() {
        return $this->belongsTo(Item::class);  
    }

    public function trip() {
        return $this->belongsTo(Trip::class);  
    }
}
