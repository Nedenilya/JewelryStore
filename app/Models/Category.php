<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name', 'link', 'is_active'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
