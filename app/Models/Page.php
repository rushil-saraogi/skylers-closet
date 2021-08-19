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
    protected $fillable = ['slug', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);  
    }

    /**
     * Page links
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
