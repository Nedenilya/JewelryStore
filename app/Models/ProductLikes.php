<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLikes extends Model
{
    protected $table = 'product_likes';

    protected $fillable = [
        'product_id', 'user_id'
    ];
}
