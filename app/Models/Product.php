<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    // Relasi: 1 produk hanya punya 1 kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: 1 produk bisa ada di banyak order_items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}