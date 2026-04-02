<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    // Tampilkan semua pesanan milik customer yang sedang login
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->latest()
                       ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    // Tampilkan detail 1 pesanan
    public function show(Order $order)
    {
        // Pastikan order ini milik customer yang sedang login
        // Kalau bukan, lempar error 403 (Forbidden)
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('orderItems.product', 'payment');

        return view('shop.orders.show', compact('order'));
    }
}