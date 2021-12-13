<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'user_id',
        'layout',
        'title',
        'wallpaper',
        'active'
    ];

    protected $casts = [
        'layout' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);  
    }

    /**
     * Page tiles
     */
    public function tiles()
    {
        return $this->hasMany(Tile::class);
    }
}
