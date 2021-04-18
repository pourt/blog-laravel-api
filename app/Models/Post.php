<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillables = [
        'id',
        'title',
        'content',
    ];

    protected $cast = [
        'created_at' => 'date:F d, Y'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
