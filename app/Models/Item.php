<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'global_item_id',
        'category_id',
        'url',
        'title',
        'order',
        'asin',
        'model',
        'brand',
        'item_order',
        'price',
        'image',
        'video_url',
        'closet_id'
    ];

    public function closet() {
        return $this->belongsTo(Closet::class);  
    }

    public function globalItem() {
        return $this->belongsTo(GlobalItem::class);  
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);  
    }
}
