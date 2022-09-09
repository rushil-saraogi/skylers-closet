<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'closet_id'
    ];

    public function Closet() {
        return $this->belongsTo(Closet::class);  
    }
}
