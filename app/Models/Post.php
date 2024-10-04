<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_private',
        'image',
        'rating',
    ];

    public function calculateAverageRating()
    {
        $this->rating = $this->ratings()->avg('value');
        $this->save();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
