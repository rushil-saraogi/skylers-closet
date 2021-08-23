<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'title',
        'og_title',
        'description',
        'og_description',
        'og_image',
        'color',
        'icon'
    ];

    public function page() {
        return $this->belongsTo(Page::class);  
    }
}
