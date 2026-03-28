@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Checkout')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Checkout</h1>
    <p class="text-sm text-gray-500 mt-1">Lengkapi informasi pengiriman untuk melanjutkan</p>
</div>

<form action="{{ route('checkout.store') }}" method="POST">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KIRI: Form Pengiriman --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Pengiriman --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Informasi Pengiriman</h2>
            </div>
            <div class="p-6 space-y-5">

                {{-- Nama (auto-filled, read only) --}}
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">
                        Nama Penerima
                    </label>
                    <input type="text"
                           value="{{ auth()->user()->name }}"
                           disabled
                           class="bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                </div>

                {{-- Alamat Pengiriman --}}
                <div>
                    <label for="shipping_address" class="block mb-2 text-sm font-medium text-gray-700">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="shipping_address"
                              name="shipping_address"
                              rows="4"
                              placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02, Kel. Dago, Kec. Coblong, Kota Bandung, Jawa Barat 40135"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:outline-none focus:ring-2 transition resize-none
                                     {{ $errors->has('shipping_address') ? 'border-red-400 focus:ring-red-300' : 'border-gray-300 focus:ring-green-300 focus:border-green-500' }}">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label for="notes" class="block mb-2 text-sm font-medium text-gray-700">
                        Catatan untuk Penjual
                        <span class="font-normal text-gray-400 text-xs">(opsional)</span>
                    </label>
                    <textarea id="notes"
                              name="notes"
                              rows="2"
                              placeholder="Contoh: Tolong dibungkus rapi, produk untuk hadiah"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-300 focus:border-green-500 focus:outline-none transition resize-none">{{ old('notes') }}</textarea>
                </div>

            </div>
        </div>

        {{-- Daftar Produk yang Dipesan --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">
                    Produk Dipesan
                    <span class="text-gray-400 font-normal">({{ count($cart) }} item)</span>
                </h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($cart as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $item['name'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Rp {{ number_format($item['price'], 0, ',', '.') }} × {{ $item['quantity'] }}
                        </p>
                    </div>
                    <p class="text-sm font-bold text-gray-800 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- KANAN: Ringkasan & Tombol --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 sticky top-24">

            <h2 class="text-base font-bold text-gray-800 mb-5">Ringkasan Pembayaran</h2>

            <div class="space-y-3 mb-5 text-sm">
                @foreach($cart as $item)
                <div class="flex justify-between">
                    <span class="text-gray-500 truncate mr-2">
                        {{ Str::limit($item['name'], 20) }}
                        <span class="text-gray-400">×{{ $item['quantity'] }}</span>
                    </span>
                    <span class="font-medium text-gray-700 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-gray-100 pt-4 mb-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Subtotal</span>
                    <span class="text-sm font-semibold text-gray-700">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm text-gray-500">Ongkir</span>
                    <span class="text-sm font-semibold text-green-600">Gratis</span>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-base font-bold text-gray-800">Total</span>
                    <span class="text-lg font-bold text-green-600">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Info Pembayaran --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-5 text-xs text-blue-700">
                <p class="font-semibold mb-1">💳 Metode Pembayaran</p>
                <p>Kamu akan diarahkan ke halaman pembayaran Xendit setelah menekan tombol di bawah.</p>
            </div>

            {{-- Tombol Buat Pesanan --}}
            <button type="submit"
                    class="flex items-center justify-center gap-2 w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-xl text-sm px-5 py-3 transition-colors">
                Buat Pesanan & Bayar
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <a href="{{ route('cart.index') }}"
               class="flex items-center justify-center w-full text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-xl text-sm px-5 py-3 transition-colors mt-3">
                ← Kembali ke Keranjang
            </a>

        </div>
    </div>

</div>

</form>

@endsection