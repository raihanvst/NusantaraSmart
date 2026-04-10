@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', $product->name)

@section('content')

{{-- Breadcrumb --}}
<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 text-sm">
        <li>
            <a href="{{ route('shop.index') }}" class="text-slate-400 hover:text-[#0f1f5c] transition-colors">Katalog</a>
        </li>
        <li><span class="text-slate-300 mx-2">/</span></li>
        <li>
            <a href="{{ route('shop.index', ['category' => $product->category_id]) }}"
               class="text-slate-400 hover:text-[#0f1f5c] transition-colors">
                {{ $product->category->name }}
            </a>
        </li>
        <li><span class="text-slate-300 mx-2">/</span></li>
        <li class="text-slate-600 font-medium truncate max-w-xs">{{ $product->name }}</li>
    </ol>
</nav>

{{-- Detail Produk --}}
<div class="card overflow-hidden mb-10">
    <div class="grid grid-cols-1 md:grid-cols-2">

        {{-- Gambar --}}
        <div class="bg-slate-50 flex items-center justify-center p-8 border-r border-slate-100 min-h-72">
            @if($product->image)
                <img src="{{ Storage::url($product->image) }}"
                     alt="{{ $product->name }}"
                     class="max-h-80 w-full object-contain rounded-xl">
            @else
                <div class="flex items-center justify-center w-full h-64 text-slate-200">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif
        </div>

        {{-- Info Produk --}}
        <div class="p-8">
            <span class="inline-block bg-[#0f1f5c]/10 text-[#0f1f5c] text-xs font-semibold px-3 py-1 rounded-full mb-3">
                {{ $product->category->name }}
            </span>

            <h1 class="text-2xl font-bold text-slate-800 mb-2 leading-tight">
                {{ $product->name }}
            </h1>

            <p class="text-3xl font-bold text-[#0f1f5c] mb-4">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>

            @if($product->description)
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    {{ $product->description }}
                </p>
            @endif

            {{-- Stok --}}
            <div class="flex items-center gap-2 mb-6 pb-6 border-b border-slate-100">
                @if($product->stock > 0)
                    <span class="badge-completed">Tersedia</span>
                    <span class="text-xs text-slate-400">{{ $product->stock }} unit tersisa</span>
                @else
                    <span class="badge-cancelled">Stok Habis</span>
                @endif
            </div>

            {{-- Form Tambah ke Cart --}}
            @if($product->stock > 0)
                @auth
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                                <button type="button" onclick="changeQty(-1)"
                                        class="px-4 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors font-semibold text-lg">−</button>
                                <input type="number" name="quantity" id="qty"
                                       value="1" min="1" max="{{ $product->stock }}"
                                       class="w-14 py-2.5 text-center text-sm border-x border-slate-200 focus:outline-none font-semibold">
                                <button type="button" onclick="changeQty(1)"
                                        class="px-4 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors font-semibold text-lg">+</button>
                            </div>
                            <button type="submit" class="btn-primary flex-1 flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-primary w-full flex items-center justify-center gap-2 text-sm">
                        Login untuk membeli
                    </a>
                @endauth
            @else
                <button disabled class="w-full bg-slate-100 text-slate-400 font-semibold rounded-xl px-5 py-2.5 cursor-not-allowed text-sm">
                    Stok Habis
                </button>
            @endif

        </div>
    </div>
</div>

{{-- Produk Terkait --}}
@if($related->count() > 0)
<div>
    <h2 class="text-lg font-bold text-slate-800 mb-5">Produk Terkait</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($related as $item)
        <a href="{{ route('shop.show', $item) }}"
           class="card p-4 flex items-center gap-4 group">
            <div class="w-16 h-16 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                @if($item->image)
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800 truncate group-hover:text-[#0f1f5c] transition-colors">
                    {{ $item->name }}
                </p>
                <p class="text-sm font-bold text-[#0f1f5c] mt-0.5">
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