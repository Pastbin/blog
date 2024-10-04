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

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function calculateAverageRating()
    {
        if ($this->ratings()->count() > 0) {
            $average = $this->ratings()->avg('value');
            $this->rating = round($average, 2);
            $this->save();
        }
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}