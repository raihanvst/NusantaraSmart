@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Katalog Produk')

@section('content')

{{-- Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Katalog Produk</h1>
    <p class="text-sm text-gray-500 mt-1">Temukan perangkat smart home terbaik untuk rumahmu</p>
</div>

<div class="flex flex-col lg:flex-row gap-8">

    {{-- SIDEBAR FILTER (kiri) --}}
    <aside class="w-full lg:w-56 flex-shrink-0">
        <form action="{{ route('shop.index') }}" method="GET" id="filterForm">

            {{-- Filter Kategori --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5 mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Kategori</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), [])) }}"
                           class="flex items-center text-sm {{ !request('category') ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }}">
                            <span class="mr-2">•</span> Semua Produk
                        </a>
                    </li>
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'), ['category' => $cat->id])) }}"
                           class="flex items-center text-sm {{ request('category') == $cat->id ? 'text-green-600 font-semibold' : 'text-gray-600 hover:text-green-600' }}">
                            <span class="mr-2">•</span> {{ $cat->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Filter Harga --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Rentang Harga</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Harga Minimum</label>
                        <input type="number" name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="0"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-300">
                    </div>
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Harga Maksimum</label>
                        <input type="number" name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="9999999"
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-300">
                    </div>
                    <button type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['min_price', 'max_price', 'category', 'search']))
                        <a href="{{ route('shop.index') }}"
                           class="block text-center text-xs text-gray-400 hover:text-red-500 hover:underline">
                            Reset filter
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </aside>

    {{-- PRODUK GRID (kanan) --}}
    <div class="flex-1">

        {{-- Info hasil pencarian --}}
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">
                Menampilkan
                <span class="font-semibold text-gray-700">{{ $products->total() }}</span>
                produk
                @if(request('search'))
                    untuk "<span class="font-semibold">{{ request('search') }}</span>"
                @endif
            </p>
        </div>

        @if($products->count() > 0)

        {{-- Grid 3 Kolom --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($products as $product)

            {{-- ============================================================
                 PRODUCT CARD
                 Sumber: https://flowbite.com/docs/components/card/
                 ============================================================ --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">

                {{-- Gambar --}}
                <a href="{{ route('shop.show', $product) }}">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </a>

                {{-- Info Produk --}}
                <div class="p-4">
                    <span class="text-xs text-green-600 font-medium">{{ $product->category->name }}</span>
                    <a href="{{ route('shop.show', $product) }}">
                        <h3 class="text-sm font-semibold text-gray-800 mt-1 mb-2 hover:text-green-600 transition-colors line-clamp-2">
                            {{ $product->name }}
                        </h3>
                    </a>
                    <div class="flex items-center justify-between mt-3">
                        <div>
                            <p class="text-base font-bold text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            @if($product->stock <= 0)
                                <p class="text-xs text-red-500 font-medium">Stok habis</p>
                            @else
                                <p class="text-xs text-gray-400">Stok: {{ $product->stock }}</p>
                            @endif
                        </div>
                        {{-- Tombol Tambah ke Cart --}}
                        @if($product->stock > 0)
                            @auth
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit"
                                            class="p-2.5 text-white bg-green-600 hover:bg-green-700 rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="p-2.5 text-white bg-green-600 hover:bg-green-700 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </a>
                            @endauth
                        @else
                            <button disabled
                                    class="p-2.5 text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
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
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-base font-semibold text-gray-600 mb-1">Produk tidak ditemukan</h3>
            <p class="text-sm text-gray-400 mb-4">Coba ubah filter atau kata kunci pencarian</p>
            <a href="{{ route('shop.index') }}"
               class="text-sm text-green-600 hover:underline">Lihat semua produk</a>
        </div>
        @endif

    </div>
</div>

@endsection