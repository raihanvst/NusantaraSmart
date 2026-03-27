<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // Query produk yang aktif
        $query = Product::with('category')
                        ->where('is_active', true);

        // Filter berdasarkan kategori (kalau dipilih)
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter berdasarkan search (kalau ada)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products   = $query->latest()->paginate(9);
        $categories = Category::all();

        return view('shop.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        // Kalau produk tidak aktif, kembalikan 404
        abort_if(!$product->is_active, 404);

        // Ambil produk lain dari kategori yang sama (rekomendasi)
        $related = Product::where('category_id', $product->category_id)
                          ->where('id', '!=', $product->id)
                          ->where('is_active', true)
                          ->take(3)
                          ->get();

        return view('shop.show', compact('product', 'related'));
    }
}