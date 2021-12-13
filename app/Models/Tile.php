<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    use HasFactory;

    const TYPE_LINK = 'link';
    const TYPE_IMAGE = 'image';
    const TYPE_TEXT = 'text';
    const TYPE_MAP = 'map';

    protected $fillable = [
        'data',
        'type',
        'page_id'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function page() {
        return $this->belongsTo(Page::class);  
    }
}
