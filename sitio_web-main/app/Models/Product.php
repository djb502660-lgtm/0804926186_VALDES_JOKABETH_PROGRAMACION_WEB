<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['nombre', 'precio', 'stock', 'estado', 'category_id', 'image_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
