<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'logo',
        'layout',
        'theme',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function draftDesign()
    {
        return $this->hasOne(AppDesign::class, 'id', 'draft_app_design_id');
    }

    public function publishedDesign()
    {
        return $this->hasOne(AppDesign::class, 'id', 'published_app_design_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }
}
