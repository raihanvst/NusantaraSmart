<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Checkout Page
    public function index()
    {
        $cart = session()->get('cart', []);

        // Kembali ke halaman cart, kalo cartnya masih kosong
        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Keranjangmu masih kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('shop.checkout', compact('cart', 'total'));
    }

    // Checkout Page
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|min:10',
            'notes'            => 'nullable|string|max:500',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.min'      => 'Alamat terlalu singkat, minimal 10 karakter.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Keranjangmu masih kosong!');
        }

        // Hitung total
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Cek stok semua produk sebelum membuat order
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);

            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                                 ->with('error', "Stok '{$item['name']}' tidak mencukupi. Silakan update keranjangmu.");
            }
        }

        // Buat nomor order 
        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(8));

        // Buat record order di database
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => $orderNumber,
            'status'           => 'pending',
            'total_amount'     => $total,
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        // Buat order items + kurangi stok
        foreach ($cart as $productId => $item) {
            // Simpan item ke tabel order_items
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // Kurangi stok produk
            Product::where('id', $productId)
                   ->decrement('stock', $item['quantity']);
        }

        // Kosongkan cart setelah order berhasil dibuat
        session()->forget('cart');

        return redirect()->route('orders.show', $order)
                         ->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
    }
}