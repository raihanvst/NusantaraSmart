@extends('layouts.admin')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
            <h2 class="text-sm font-semibold text-slate-700">Edit — {{ $product->name }}</h2>
        </div>
        <form action="{{ route('admin.products.update', $product) }}" method="POST"
              enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category_id" class="input-field">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="input-field {{ $errors->has('name') ? 'border-red-400' : '' }}">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="input-field resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Harga (Rp)</label>
                    <input type="number" name="price" min="0"
                           value="{{ old('price', $product->price) }}" class="input-field">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Stok</label>
                    <input type="number" name="stock" min="0"
                           value="{{ old('stock', $product->stock) }}" class="input-field">
                </div>
            </div>

            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Gambar <span class="text-slate-400 font-normal text-xs">(kosongkan jika tidak ingin mengubah)</span>
                </label>
                @if($product->image)
                    <div class="mb-3">
                        <p class="text-xs text-slate-400 mb-1.5">Gambar saat ini:</p>
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                             id="currentImage"
                             class="w-28 h-28 object-cover rounded-xl border border-slate-200 transition-opacity">
                    </div>
                @endif
                <input type="file" name="image" id="imageInput"
                       accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="block w-full text-sm text-slate-600 border border-slate-300 rounded-xl cursor-pointer bg-slate-50 focus:outline-none p-2">
                <div id="imagePreview" class="mt-3 hidden">
                    <p class="text-xs text-slate-400 mb-1.5">Preview gambar baru:</p>
                    <img id="previewImg" src="" alt="Preview"
                         class="w-28 h-28 object-cover rounded-xl border border-slate-200">
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-[#0f1f5c] bg-slate-100 border-slate-300 rounded focus:ring-[#0f1f5c]">
                    <span class="text-sm font-medium text-slate-700">Produk aktif (tampil di katalog)</span>
                </label>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="btn-primary flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 px-5 py-2.5 rounded-xl transition-all">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                const curr = document.getElementById('currentImage');
                if (curr) curr.style.opacity = '0.4';
            };
            reader.readAsDataURL(file);
        }
    });
</script>

@endsection