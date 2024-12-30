<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'price', 'category_id', 'image', 'is_best_offer'
    ];

    public function product_likes() {
        return $this->hasMany(ProductLikes::class);
    }
}
