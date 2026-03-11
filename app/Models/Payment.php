<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'amount',
        'status',
        'payment_method',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // Relasi: pembayaran ini milik 1 order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}