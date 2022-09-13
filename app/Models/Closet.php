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
        'category_id',
        'wallpaper',
        'active',
        'public'
    ];

    public function user() {
        return $this->belongsTo(User::class);  
    }

    /**
     * Closet items
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

    public function messages()
    {
        return $this->hasMany(Message::class)->orderByDesc('created_at');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);  
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'closet_followers', 'closet_id', 'follower_id');
    }
}
