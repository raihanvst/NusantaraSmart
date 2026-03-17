@extends('layouts.admin')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-green-600">
                <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-green-600 ms-1 md:ms-2">Produk</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="text-sm text-gray-500 ms-1 md:ms-2">Edit — {{ $product->name }}</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
            <h2 class="text-sm font-semibold text-gray-700">Edit Informasi Produk</h2>
            <p class="text-xs text-gray-400 mt-0.5">Perubahan akan langsung tersimpan</p>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST"
              enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            {{-- SELECT --}}
            <div class="mb-5">
                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700">
                    Kategori <span class="text-red-500">*</span>
                </label>
                <select id="category_id" name="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-300 focus:border-green-500 focus:outline-none block w-full p-2.5">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- INPUT --}}
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $product->name) }}"
                       class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 transition
                              {{ $errors->has('name') ? 'border-red-500 focus:ring-red-300 bg-red-50' : 'border-gray-300 focus:ring-green-300 focus:border-green-500' }}">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- TEXTAREA --}}
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-300 focus:border-green-500 focus:outline-none resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Harga & Stok --}}
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-700">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price" name="price" min="0"
                           value="{{ old('price', $product->price) }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-green-300 focus:border-green-500 focus:outline-none">
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="stock" class="block mb-2 text-sm font-medium text-gray-700">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" min="0"
                           value="{{ old('stock', $product->stock) }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-green-300 focus:border-green-500 focus:outline-none">
                </div>
            </div>

            {{-- FILE INPUT --}}
            <div class="mb-5">
                <label for="image" class="block mb-2 text-sm font-medium text-gray-700">
                    Gambar Produk
                    <span class="font-normal text-gray-400 text-xs">(kosongkan jika tidak ingin mengubah)</span>
                </label>

                {{-- Gambar saat ini --}}
                @if($product->image)
                    <div class="mb-3">
                        <p class="text-xs text-gray-400 mb-1.5">Gambar saat ini:</p>
                        <img src="{{ Storage::url($product->image) }}"
                             alt="{{ $product->name }}"
                             id="currentImage"
                             class="w-28 h-28 object-cover rounded-xl border border-gray-200 transition-opacity">
                    </div>
                @endif

                <input type="file" id="image" name="image"
                       accept="image/jpg,image/jpeg,image/png,image/webp"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                @error('image')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div id="imagePreview" class="mt-3 hidden">
                    <p class="text-xs text-gray-400 mb-1.5">Preview gambar baru:</p>
                    <img id="previewImg" src="" alt="Preview"
                         class="w-28 h-28 object-cover rounded-xl border border-gray-200">
                </div>
            </div>

            {{-- CHECKBOX --}}
            <div class="mb-6">
                <div class="flex items-center">
                    <input id="is_active" type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                    <label for="is_active" class="ms-2 text-sm font-medium text-gray-700">
                        Produk aktif (tampil di katalog customer)
                    </label>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
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