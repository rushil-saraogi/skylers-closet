<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'item_order',
        'price',
        'outlet_id'
    ];

    public function outlet() {
        return $this->belongsTo(Outlet::class);  
    }
}
