<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts'; 
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'status',
        'created_at',
        'updated_at'
    ];
}
