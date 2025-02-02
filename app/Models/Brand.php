<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $fillable = [
        'name', 'description', 'link', 'is_active'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }
}
