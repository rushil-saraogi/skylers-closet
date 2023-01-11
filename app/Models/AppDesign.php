<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppDesign extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'theme',
        'layout',
        'primary_color',
        'cover_image',
    ];

    public function hotel() {
        return $this->belongsTo(Hotel::class, 'draft_app_design_id');
    }
}
