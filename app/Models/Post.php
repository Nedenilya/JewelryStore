<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'title', 'description', 'image', 'user_id', 'category_id'
    ];

    public function post_likes() {
        return $this->hasMany(PostLikes::class);
    }
}
