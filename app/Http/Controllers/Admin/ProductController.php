<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan daftar semua produk
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    // Tampilkan form tambah produk
    public function create()
    {
    
    // Ambil semua kategori untuk dropdown pilihan
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    // Simpan produk baru ke database
    public function store(Request $request)
    {
    // Validasi semua input
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'   => 'boolean',
        ], [
            'category_id.required' => 'Pilih kategori produk.',
            'category_id.exists'   => 'Kategori tidak valid.',
            'name.required'        => 'Nama produk wajib diisi.',
            'name.unique'          => 'Nama produk sudah ada.',
            'price.required'       => 'Harga produk wajib diisi.',
            'price.numeric'        => 'Harga harus berupa angka.',
            'price.min'            => 'Harga tidak boleh negatif.',
            'stock.required'       => 'Stok produk wajib diisi.',
            'stock.integer'        => 'Stok harus berupa angka bulat.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Proses upload gambar
        $imageName = null; // default null kalau tidak ada gambar

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->store('products', 'public');
        }

        // Simpan produk ke database
        Product::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imageName,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    // Tampilkan form edit produk
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Simpan perubahan produk ke database
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'category_id.required' => 'Pilih kategori produk.',
            'name.required'        => 'Nama produk wajib diisi.',
            'name.unique'          => 'Nama produk sudah ada.',
            'price.required'       => 'Harga wajib diisi.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar: jpg, jpeg, png, webp.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Proses gambar baru kalau ada
        $imageName = $product->image; 

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imageName = $request->file('image')->store('products', 'public');
        }

        // Update data produk
        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imageName,
            'is_active'   => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk dari database
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Produk berhasil dihapus!');
    }
}