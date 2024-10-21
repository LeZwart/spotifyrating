<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment',
        'user_id',
        'artist_id'
    ];

    function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

}
