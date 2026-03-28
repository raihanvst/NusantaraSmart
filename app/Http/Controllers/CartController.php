<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Tampilkan halaman cart
     */
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('shop.cart', compact('cart', 'total'));
    }

    /**
     * Tambah produk ke cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek stok cukup
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi!');
        }

        // Ambil cart dari session, kalau belum ada = array kosong
        $cart = session()->get('cart', []);

        // Kalau produk sudah ada di cart, tambah quantity-nya
        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['quantity'] + $request->quantity;

            // Pastikan total quantity tidak melebihi stok
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
            }

            $cart[$product->id]['quantity'] = $newQty;
        } else {
            // Kalau produk belum ada di cart, tambahkan sebagai item baru
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'price'      => $product->price,
                'quantity'   => $request->quantity,
                'image'      => $product->image,
                'slug'       => $product->slug,
            ];
        }

        // Simpan cart yang sudah diupdate ke session
        session()->put('cart', $cart);

        return back()->with('success', '"' . $product->name . '" berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update quantity item di cart
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Produk tidak ditemukan di keranjang!');
        }

        // Cek stok
        $product = Product::findOrFail($productId);
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia!');
        }

        $cart[$productId]['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Hapus 1 item dari cart
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    /**
     * Kosongkan seluruh cart
     */
    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang berhasil dikosongkan!');
    }
}