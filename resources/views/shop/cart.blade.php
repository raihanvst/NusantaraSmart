@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Keranjang Belanja')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Keranjang Belanja Anda</h1>
    <p class="text-sm text-slate-500 mt-1">{{ count($cart) }} produk di keranjangmu</p>
</div>

@if(count($cart) > 0)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KIRI: Item Cart --}}
    <div class="lg:col-span-2 space-y-4">

        <div class="flex justify-end">
            <form action="{{ route('cart.clear') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin mengosongkan keranjang?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs text-red-400 hover:text-red-600 hover:underline transition-colors">
                    Kosongkan keranjang
                </button>
            </form>
        </div>

        @foreach($cart as $productId => $item)
        <div class="card p-5">
            <div class="flex items-center gap-4">

                {{-- Gambar --}}
                <a href="{{ route('shop.show', $item['slug']) }}" class="flex-shrink-0">
                    <div class="w-20 h-20 bg-slate-100 rounded-xl overflow-hidden">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </a>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <a href="{{ route('shop.show', $item['slug']) }}">
                        <h3 class="text-sm font-semibold text-slate-800 hover:text-[#0f1f5c] transition-colors">
                            {{ $item['name'] }}
                        </h3>
                    </a>
                    <p class="text-sm font-bold text-[#0f1f5c] mt-1">
                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </p>
                </div>

                {{-- Qty & Hapus --}}
                <div class="flex flex-col items-end gap-3">
                    <form action="{{ route('cart.update', $productId) }}" method="POST"
                          class="flex items-center border border-slate-200 rounded-xl overflow-hidden">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="updateQty(this, -1)"
                                class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition-colors font-semibold">−</button>
                        <input type="number" name="quantity"
                               value="{{ $item['quantity'] }}" min="1"
                               onchange="this.form.submit()"
                               class="w-12 py-2 text-center text-sm border-x border-slate-200 focus:outline-none font-semibold">
                        <button type="button" onclick="updateQty(this, 1)"
                                class="px-3 py-2 text-slate-600 hover:bg-slate-100 transition-colors font-semibold">+</button>
                    </form>

                    <p class="text-sm font-bold text-slate-800">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </p>

                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-400 hover:text-red-600 hover:underline transition-colors">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </div>

    {{-- KANAN: Ringkasan --}}
    <div class="lg:col-span-1">
        <div class="card p-6 sticky top-24">

            <h2 class="text-base font-bold text-slate-800 mb-5">Ringkasan Pesanan</h2>

            <div class="space-y-3 mb-5">
                @foreach($cart as $item)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 truncate mr-2">
                        {{ $item['name'] }} <span class="text-slate-400">×{{ $item['quantity'] }}</span>
                    </span>
                    <span class="font-medium text-slate-700 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-slate-100 pt-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total</span>
                    <span class="text-lg font-bold text-[#0f1f5c]">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <a href="{{ route('checkout.index') }}" class="btn-primary w-full flex items-center justify-center gap-2 text-sm">
                Lanjut ke Checkout
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('shop.index') }}"
               class="mt-3 w-full flex items-center justify-center text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl px-5 py-2.5 transition-all">
                ← Lanjut Belanja
            </a>

        </div>
    </div>

</div>

@else

<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 batik-pattern rounded-full flex items-center justify-center mb-5 shadow-lg">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
    </div>
    <h2 class="text-lg font-bold text-slate-700 mb-1">Keranjangmu masih kosong</h2>
    <p class="text-sm text-slate-400 mb-6">Yuk mulai belanja produk smart home!</p>
    <a href="{{ route('shop.index') }}" class="btn-primary text-sm">Mulai Belanja</a>
</div>

@endif

<script>
    function updateQty(btn, delta) {
        const form  = btn.closest('form');
        const input = form.querySelector('input[name="quantity"]');
        const val   = parseInt(input.value) + delta;
        if (val >= 1) { input.value = val; form.submit(); }
    }
</script>

@endsection