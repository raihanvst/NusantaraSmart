<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relasi: item ini milik 1 order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: item ini merujuk ke 1 produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}