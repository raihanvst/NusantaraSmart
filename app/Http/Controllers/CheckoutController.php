<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected XenditService $xenditService;

    public function __construct(XenditService $xenditService)
    {
        $this->xenditService = $xenditService;
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Keranjangmu masih kosong!');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('shop.checkout', compact('cart', 'total'));
    }

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

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if (!$product || $product->stock < $item['quantity']) {
                return redirect()->route('cart.index')
                                 ->with('error', "Stok '{$item['name']}' tidak mencukupi.");
            }
        }

        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
            'status'           => 'pending',
            'total_amount'     => $total,
            'shipping_address' => $request->shipping_address,
            'notes'            => $request->notes,
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);
            Product::where('id', $productId)->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');

        try {
            $invoice = $this->xenditService->createInvoice($order);

            Payment::create([
                'order_id'           => $order->id,
                'xendit_invoice_id'  => $invoice['invoice_id'],
                'xendit_invoice_url' => $invoice['invoice_url'],
                'amount'             => $total,
                'status'             => 'pending',
            ]);

            return redirect($invoice['invoice_url']);

        } catch (\Exception $e) {
            \Log::error('Xendit Error: ' . $e->getMessage());

            return redirect()->route('orders.show', $order)
                             ->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }
}