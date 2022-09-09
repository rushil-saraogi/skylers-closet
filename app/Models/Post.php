<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_body',
        'closet_id',
        'user_id',
        'parent_post_id'
    ];

    public function closet() {
        return $this->belongsTo(Closet::class);  
    }

    public function author() {
        return $this->belongsTo(User::class);  
    }

    public function parent() {
        return $this->belongsTo(Post::class);  
    }
}
