<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'wallpaper',
        'active',
    ];

    public function user() {
        return $this->belongsTo(User::class);  
    }

    /**
     * Closet products
     */
    public function items()
    {
        return $this->hasMany(Item::class)->orderByDesc('item_order');
    }

    /**
     * Closet drawers
     */
    public function drawers()
    {
        return $this->hasMany(Drawer::class);
    }
}
