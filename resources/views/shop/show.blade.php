@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', $product->name)

@section('content')

{{-- Breadcrumb --}}
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li>
            <a href="{{ route('shop.index') }}" class="text-sm text-gray-500 hover:text-green-600">Katalog</a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('shop.index', ['category' => $product->category_id]) }}"
                   class="text-sm text-gray-500 hover:text-green-600 ms-1">
                    {{ $product->category->name }}
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="text-sm text-gray-500 ms-1 truncate max-w-xs">{{ $product->name }}</span>
            </div>
        </li>
    </ol>
</nav>

{{-- Detail Produk --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-0">

        {{-- Gambar --}}
        <div class="bg-gray-50 flex items-center justify-center p-8 border-r border-gray-100">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="max-h-80 w-full object-contain rounded-xl">
            @else
                <div class="flex items-center justify-center w-full h-64 text-gray-200">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="p-8">
            <span class="text-xs font-medium text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                {{ $product->category->name }}
            </span>
            <h1 class="text-2xl font-bold text-gray-800 mt-3 mb-2">{{ $product->name }}</h1>
            <p class="text-3xl font-bold text-green-600 mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            @if($product->description)
                <p class="text-sm text-gray-600 leading-relaxed mb-6">{{ $product->description }}</p>
            @endif

            {{-- Stok --}}
            <div class="flex items-center gap-2 mb-6">
                @if($product->stock > 0)
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Tersedia
                    </span>
                    <span class="text-xs text-gray-400">{{ $product->stock }} unit tersisa</span>
                @else
                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        Stok Habis
                    </span>
                @endif
            </div>

            {{-- Form Tambah ke Cart --}}
            @if($product->stock > 0)
                @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="flex items-center gap-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button type="button" onclick="changeQty(-1)"
                                    class="px-3 py-2.5 text-gray-600 hover:bg-gray-100 transition-colors text-lg font-medium">−</button>
                            <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                                   class="w-14 py-2.5 text-center text-sm border-x border-gray-300 focus:outline-none">
                            <button type="button" onclick="changeQty(1)"
                                    class="px-3 py-2.5 text-gray-600 hover:bg-gray-100 transition-colors text-lg font-medium">+</button>
                        </div>
                        <button type="submit"
                                class="flex-1 flex items-center justify-center gap-2 text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="flex items-center justify-center gap-2 w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-5 py-2.5 transition-colors">
                        Login untuk membeli
                    </a>
                @endauth
            @else
                <button disabled
                        class="w-full text-gray-400 bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 cursor-not-allowed">
                    Stok Habis
                </button>
            @endif

        </div>
    </div>
</div>

{{-- Produk Terkait --}}
@if($related->count() > 0)
<div>
    <h2 class="text-lg font-bold text-gray-800 mb-5">Produk Terkait</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($related as $item)
        <a href="{{ route('shop.show', $item) }}"
           class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden group flex items-center gap-4 p-4">
            <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">{{ $item->name }}</p>
                <p class="text-sm font-bold text-green-600 mt-0.5">
                    Rp {{ number_format($item->price, 0, ',', '.') }}
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<script>
    function changeQty(delta) {
        const input = document.getElementById('qty');
        const max   = parseInt(input.getAttribute('max'));
        const val   = parseInt(input.value) + delta;
        if (val >= 1 && val <= max) input.value = val;
    }
</script>

@endsection