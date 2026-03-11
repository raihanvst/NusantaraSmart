<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'total_amount',
        'shipping_address',
        'notes',
    ];

    // Relasi: order ini milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 order punya banyak item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: 1 order punya 1 pembayaran
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}