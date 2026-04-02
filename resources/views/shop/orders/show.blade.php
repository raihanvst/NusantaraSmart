@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')

@php
    $badge = [
        'pending'    => 'bg-yellow-100 text-yellow-800',
        'paid'       => 'bg-blue-100 text-blue-800',
        'processing' => 'bg-purple-100 text-purple-800',
        'shipped'    => 'bg-indigo-100 text-indigo-800',
        'completed'  => 'bg-green-100 text-green-800',
        'cancelled'  => 'bg-red-100 text-red-800',
    ];
    $label = [
        'pending'    => 'Menunggu Pembayaran',
        'paid'       => 'Sudah Dibayar',
        'processing' => 'Sedang Diproses',
        'shipped'    => 'Sedang Dikirim',
        'completed'  => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ];
@endphp

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Detail Pesanan</h1>
        <p class="text-sm font-mono text-gray-500 mt-1">{{ $order->order_number }}</p>
    </div>
    <span class="text-sm font-semibold px-3 py-1.5 rounded-full {{ $badge[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
        {{ $label[$order->status] ?? $order->status }}
    </span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KIRI: Item & Info --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Item Pesanan --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Produk Dipesan</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($order->orderItems as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($item->product->image)
                            <img src="{{ Storage::url($item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800">{{ $item->product->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                        </p>
                    </div>
                    <p class="text-sm font-bold text-gray-800 flex-shrink-0">
                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>
            {{-- Total --}}
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <span class="text-sm font-bold text-gray-700">Total Pembayaran</span>
                <span class="text-lg font-bold text-green-600">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Info Pengiriman --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Informasi Pengiriman</h2>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Penerima</p>
                    <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-gray-800 leading-relaxed">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div>
                    <p class="text-xs text-gray-400 mb-1">Catatan</p>
                    <p class="text-gray-600">{{ $order->notes }}</p>
                </div>
                @endif
                <div>
                    <p class="text-xs text-gray-400 mb-1">Tanggal Pesan</p>
                    <p class="font-medium text-gray-800">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>

    </div>

    {{-- KANAN: Status & Pembayaran --}}
    <div class="space-y-5">

        {{-- Status Timeline --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Status Pesanan</h2>
            </div>
            <div class="p-6">
                @php
                    $steps = [
                        'pending'    => ['label' => 'Menunggu Pembayaran', 'icon' => '🕐'],
                        'paid'       => ['label' => 'Pembayaran Diterima', 'icon' => '✅'],
                        'processing' => ['label' => 'Sedang Diproses',     'icon' => '📦'],
                        'shipped'    => ['label' => 'Sedang Dikirim',      'icon' => '🚚'],
                        'completed'  => ['label' => 'Pesanan Selesai',     'icon' => '🎉'],
                    ];
                    $currentIndex = array_search($order->status, array_keys($steps));
                @endphp

                <ol class="relative border-s border-gray-200 ms-3">
                    @foreach($steps as $key => $step)
                    @php
                        $stepIndex = array_search($key, array_keys($steps));
                        $isDone    = $currentIndex !== false && $stepIndex <= $currentIndex;
                        $isCurrent = $key === $order->status;
                    @endphp
                    <li class="mb-6 ms-6 last:mb-0">
                        <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -start-3.5 text-sm
                                     {{ $isDone ? 'bg-green-100' : 'bg-gray-100' }}">
                            {{ $step['icon'] }}
                        </span>
                        <p class="text-sm font-medium {{ $isDone ? 'text-gray-800' : 'text-gray-400' }}">
                            {{ $step['label'] }}
                            @if($isCurrent)
                                <span class="text-xs text-green-600 font-semibold ml-1">(sekarang)</span>
                            @endif
                        </p>
                    </li>
                    @endforeach

                    {{-- Cancelled (special case) --}}
                    @if($order->status === 'cancelled')
                    <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -start-3.5 text-sm bg-red-100">
                            ❌
                        </span>
                        <p class="text-sm font-medium text-red-600">
                            Pesanan Dibatalkan
                            <span class="text-xs font-semibold ml-1">(sekarang)</span>
                        </p>
                    </li>
                    @endif
                </ol>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Info Pembayaran</h2>
            </div>
            <div class="p-6 text-sm space-y-3">
                @if($order->payment)
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Status</p>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full
                            {{ $order->payment->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @if($order->payment->payment_method)
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Metode Bayar</p>
                        <p class="font-medium text-gray-800">{{ strtoupper($order->payment->payment_method) }}</p>
                    </div>
                    @endif
                    @if($order->payment->paid_at)
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Waktu Bayar</p>
                        <p class="font-medium text-gray-800">
                            {{ $order->payment->paid_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                    @endif

                    {{-- Tombol Bayar kalau masih pending --}}
                    @if($order->payment->status === 'pending' && $order->payment->xendit_invoice_url)
                    <a href="{{ $order->payment->xendit_invoice_url }}"
                       target="_blank"
                       class="flex items-center justify-center gap-2 w-full text-white bg-green-600 hover:bg-green-700 font-medium rounded-xl text-sm px-5 py-2.5 transition-colors mt-4">
                        💳 Bayar Sekarang
                    </a>
                    @endif
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-400 text-xs">Belum ada data pembayaran</p>
                        <p class="text-xs text-gray-400 mt-1">
                            Akan muncul setelah kamu melakukan pembayaran
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <a href="{{ route('orders.index') }}"
           class="flex items-center justify-center gap-2 w-full text-gray-600 bg-gray-100 hover:bg-gray-200 font-medium rounded-xl text-sm px-5 py-3 transition-colors">
            ← Kembali ke Pesanan Saya
        </a>

    </div>
</div>

@endsection