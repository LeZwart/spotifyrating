<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'popularity',
        'href',
        'uri',
        'followers',
        'external_url'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function genres()
    {
        return $this->hasMany(Genre::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

}
