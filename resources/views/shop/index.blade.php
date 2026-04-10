@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Katalog Produk')

@section('content')

{{-- ===== HERO SECTION dengan Batik Pattern ===== --}}
<div class="batik-pattern rounded-3xl overflow-hidden mb-10 shadow-xl">
    <div class="px-8 py-14 md:py-20 text-center">
        <!-- <span class="inline-block bg-amber-500/20 text-amber-300 text-xs font-semibold px-3 py-1 rounded-full mb-4 border border-amber-500/30">
            Smart Home Indonesia
        </span> -->
        <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 leading-tight">
            Rumah Pintar,<br>
            <span class="text-amber-400">Hidup Lebih Mudah</span>
        </h1>
        <p class="text-blue-200 text-sm md:text-base max-w-md mx-auto mb-8">
            Temukan perangkat smart home terbaik untuk mewujudkan rumah impianmu yang modern dan efisien.
        </p>
        <a href="#katalog"
           class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg hover:shadow-xl">
            Lihat Katalog
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </a>
    </div>
</div>

{{-- ===== KATEGORI PILLS ===== --}}
<div class="flex items-center gap-2 overflow-x-auto pb-2 mb-8 scrollbar-hide">
    <a href="{{ route('shop.index') }}"
       class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all
              {{ !request('category') ? 'bg-[#0f1f5c] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-[#0f1f5c] hover:text-[#0f1f5c]' }}">
        Semua
    </a>
    @foreach($categories as $cat)
    <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $cat->id])) }}"
       class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all
              {{ request('category') == $cat->id ? 'bg-[#0f1f5c] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-[#0f1f5c] hover:text-[#0f1f5c]' }}">
        {{ $cat->name }}
    </a>
    @endforeach
</div>

{{-- ===== MAIN CONTENT ===== --}}
<div id="katalog" class="flex flex-col lg:flex-row gap-8">

    {{-- SIDEBAR FILTER --}}
    <aside class="w-full lg:w-56 flex-shrink-0">
        <form action="{{ route('shop.index') }}" method="GET">

            <div class="card p-5 mb-4">
                <h3 class="text-sm font-semibold text-slate-800 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#0f1f5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter Harga
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Harga Minimum</label>
                        <input type="number" name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="0"
                               class="input-field text-sm">
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Harga Maksimum</label>
                        <input type="number" name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="9999999"
                               class="input-field text-sm">
                    </div>
                    <button type="submit" class="btn-primary w-full text-sm text-center">
                        Terapkan
                    </button>
                    @if(request()->hasAny(['min_price', 'max_price', 'category', 'search']))
                        <a href="{{ route('shop.index') }}"
                           class="block text-center text-xs text-slate-400 hover:text-red-500 transition-colors">
                            Reset filter
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </aside>

    {{-- PRODUK GRID --}}
    <div class="flex-1">

        <div class="flex items-center justify-between mb-5">
            <p class="text-sm text-slate-500">
                Menampilkan <span class="font-semibold text-slate-700">{{ $products->total() }}</span> produk
                @if(request('search'))
                    untuk "<span class="font-semibold text-[#0f1f5c]">{{ request('search') }}</span>"
                @endif
            </p>
        </div>

        @if($products->count() > 0)

        {{-- Grid 3 Kolom --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($products as $product)
            <div class="card overflow-hidden group">

                {{-- Gambar --}}
                <a href="{{ route('shop.show', $product) }}">
                    <div class="aspect-square overflow-hidden bg-slate-100 relative">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                        {{-- Badge Kategori --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-[#0f1f5c]/80 backdrop-blur-sm text-white text-xs font-medium px-2.5 py-1 rounded-full">
                                {{ $product->category->name }}
                            </span>
                        </div>
                    </div>
                </a>

                {{-- Info --}}
                <div class="p-4">
                    <a href="{{ route('shop.show', $product) }}">
                        <h3 class="text-sm font-semibold text-slate-800 mb-1 hover:text-[#0f1f5c] transition-colors line-clamp-2 leading-snug">
                            {{ $product->name }}
                        </h3>
                    </a>
                    <p class="text-lg font-bold text-[#0f1f5c] mb-3">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    <div class="flex items-center justify-between">
                        @if($product->stock <= 0)
                            <span class="text-xs text-red-500 font-medium">Stok habis</span>
                        @else
                            <span class="text-xs text-slate-400">Stok: {{ $product->stock }}</span>
                        @endif

                        @if($product->stock > 0)
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                            class="flex items-center gap-1.5 bg-[#0f1f5c] hover:bg-[#1e3a8a] text-white text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        + Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex items-center gap-1.5 bg-[#0f1f5c] hover:bg-[#1e3a8a] text-white text-xs font-semibold px-3 py-2 rounded-xl transition-all">
                                    + Keranjang
                                </a>
                            @endauth
                        @else
                            <button disabled
                                    class="text-xs font-semibold px-3 py-2 rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed">
                                Habis
                            </button>
                        @endif
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->withQueryString()->links() }}
        </div>

        @else
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-5">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-600 mb-1">Produk tidak ditemukan</h3>
            <p class="text-sm text-slate-400 mb-4">Coba ubah filter atau kata kunci pencarian</p>
            <a href="{{ route('shop.index') }}" class="btn-primary text-sm">Lihat Semua Produk</a>
        </div>
        @endif

    </div>
</div>

@endsection