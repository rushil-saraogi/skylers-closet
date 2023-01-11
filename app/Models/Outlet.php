<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'hotel_id'
    ];

    public function items() {
        return $this->hasMany(Item::class);  
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class);  
    }
}
