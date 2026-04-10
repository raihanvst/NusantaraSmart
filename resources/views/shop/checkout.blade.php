@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')

@section('title', 'Checkout')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Checkout</h1>
    <p class="text-sm text-slate-500 mt-1">Lengkapi informasi pengiriman untuk melanjutkan</p>
</div>

<form action="{{ route('checkout.store') }}" method="POST">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KIRI: Form --}}
    <div class="lg:col-span-2 space-y-5">

        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Informasi Pengiriman</h2>
            </div>
            <div class="p-6 space-y-5">

                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700">Nama Penerima</label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled
                           class="input-field bg-slate-100 cursor-not-allowed text-slate-500">
                </div>

                <div>
                    <label for="shipping_address" class="block mb-2 text-sm font-medium text-slate-700">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea id="shipping_address" name="shipping_address" rows="4"
                              placeholder="Contoh: Jl. Sudirman No. 123, RT 01/RW 02, Kel. Dago, Kec. Coblong, Kota Bandung 40135"
                              class="input-field resize-none placeholder:text-slate-400" {{ $errors->has('shipping_address') ? 'border-red-400 focus:ring-red-300' : '' }}">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block mb-2 text-sm font-medium text-slate-700">
                        Catatan <span class="text-slate-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="2"
                              placeholder="Contoh: Tolong dibungkus rapi"
                              class="input-field resize-none placeholder:text-slate-400">{{ old('notes') }}</textarea>
                </div>

            </div>
        </div>

        {{-- Daftar Produk --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">
                    Produk Dipesan <span class="text-slate-400 font-normal">({{ count($cart) }} item)</span>
                </h2>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($cart as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-14 h-14 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($item['image'])
                            <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $item['name'] }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Rp {{ number_format($item['price'], 0, ',', '.') }} × {{ $item['quantity'] }}
                        </p>
                    </div>
                    <p class="text-sm font-bold text-slate-800 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- KANAN: Ringkasan --}}
    <div class="lg:col-span-1">
        <div class="card p-6 sticky top-24">

            <h2 class="text-base font-bold text-slate-800 mb-5">Ringkasan Pembayaran</h2>

            <div class="space-y-3 mb-5 text-sm">
                @foreach($cart as $item)
                <div class="flex justify-between">
                    <span class="text-slate-500 truncate mr-2">
                        {{ Str::limit($item['name'], 20) }} ×{{ $item['quantity'] }}
                    </span>
                    <span class="font-medium text-slate-700 flex-shrink-0">
                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>

            <div class="border-t border-slate-100 pt-4 mb-2 space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Subtotal</span>
                    <span class="font-semibold text-slate-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500">Ongkir</span>
                    <span class="font-semibold text-green-600">Gratis</span>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4 mb-5">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-slate-800">Total</span>
                    <span class="text-lg font-bold text-[#0f1f5c]">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="bg-[#0f1f5c]/5 border border-[#0f1f5c]/10 rounded-xl p-3 mb-5">
                <p class="text-xs font-semibold text-[#0f1f5c] mb-1">💳 Pembayaran via Xendit</p>
                <p class="text-xs text-slate-500">Kamu akan diarahkan ke halaman pembayaran Xendit setelah menekan tombol di bawah.</p>
            </div>

            <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2 text-sm">
                Buat Pesanan & Bayar
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <a href="{{ route('cart.index') }}"
               class="mt-3 w-full flex items-center justify-center text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl px-5 py-2.5 transition-all">
                ← Kembali ke Keranjang
            </a>

        </div>
    </div>

</div>
</form>

@endsection