<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
    'user_id',
    'image_name',
    'image_path'
    ];

    public function user(){

        return $this->belongsTo(User::class, 'user_id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
