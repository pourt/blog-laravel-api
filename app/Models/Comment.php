<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'name',
        'comment',
    ];
    
    public function comments()
    {
        return $this->belongsTo(self::class, 'comment_id');
    }

    public function replies()
    {
        return $this->hasMany(self::class, 'comment_id');
    }
    
}
