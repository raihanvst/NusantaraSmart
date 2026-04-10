@extends('layouts.app')
@use('Illuminate\Support\Facades\Storage')

@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')

@php
    $badgeClass = [
        'pending'    => 'badge-pending',
        'paid'       => 'badge-paid',
        'processing' => 'badge-processing',
        'shipped'    => 'badge-shipped',
        'completed'  => 'badge-completed',
        'cancelled'  => 'badge-cancelled',
    ][$order->status] ?? 'badge-pending';

    $label = [
        'pending'    => 'Menunggu Pembayaran',
        'paid'       => 'Sudah Dibayar',
        'processing' => 'Sedang Diproses',
        'shipped'    => 'Sedang Dikirim',
        'completed'  => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ][$order->status] ?? $order->status;
@endphp

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Detail Pesanan</h1>
        <p class="text-sm font-mono text-slate-500 mt-1">{{ $order->order_number }}</p>
    </div>
    <span class="{{ $badgeClass }} text-sm px-3 py-1.5">{{ $label }}</span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KIRI --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Item Pesanan --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Produk Dipesan</h2>
            </div>
            <div class="divide-y divide-slate-50">
                @foreach($order->orderItems as $item)
                <div class="flex items-center gap-4 px-6 py-4">
                    <div class="w-14 h-14 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0">
                        @if($item->product->image)
                            <img src="{{ Storage::url($item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800">{{ $item->product->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}
                        </p>
                    </div>
                    <p class="text-sm font-bold text-slate-800 flex-shrink-0">
                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                    </p>
                </div>
                @endforeach
            </div>
            <div class="px-6 py-4 border-t border-slate-200 flex justify-between items-center bg-slate-50/60">
                <span class="text-sm font-bold text-slate-700">Total Pembayaran</span>
                <span class="text-lg font-bold text-[#0f1f5c]">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Info Pengiriman --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Informasi Pengiriman</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5 text-sm">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Penerima</p>
                    <p class="font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Tanggal Pesan</p>
                    <p class="font-medium text-slate-800">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs text-slate-400 mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-slate-800 leading-relaxed">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="sm:col-span-2">
                    <p class="text-xs text-slate-400 mb-1">Catatan</p>
                    <p class="text-slate-600">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="space-y-5">

        {{-- Status Timeline --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Status Pesanan</h2>
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
                <ol class="relative border-s border-slate-200 ms-3">
                    @foreach($steps as $key => $step)
                    @php
                        $stepIndex = array_search($key, array_keys($steps));
                        $isDone    = $currentIndex !== false && $stepIndex <= $currentIndex;
                        $isCurrent = $key === $order->status;
                    @endphp
                    <li class="mb-5 ms-6 last:mb-0">
                        <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -start-3.5 text-sm border-2
                                     {{ $isDone ? 'bg-[#0f1f5c] border-[#0f1f5c]' : 'bg-white border-slate-200' }}">
                            @if($isDone)
                                <span class="text-xs">{{ $step['icon'] }}</span>
                            @endif
                        </span>
                        <p class="text-xs font-medium {{ $isDone ? 'text-slate-800' : 'text-slate-400' }}">
                            {{ $step['label'] }}
                            @if($isCurrent)
                                <span class="text-[#0f1f5c] font-semibold ml-1">(sekarang)</span>
                            @endif
                        </p>
                    </li>
                    @endforeach
                    @if($order->status === 'cancelled')
                    <li class="ms-6">
                        <span class="absolute flex items-center justify-center w-7 h-7 rounded-full -start-3.5 text-sm bg-red-100 border-2 border-red-300">
                            <span class="text-xs">❌</span>
                        </span>
                        <p class="text-xs font-semibold text-red-600">Pesanan Dibatalkan</p>
                    </li>
                    @endif
                </ol>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Info Pembayaran</h2>
            </div>
            <div class="p-6 text-sm space-y-3">
                @if($order->payment)
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Status</p>
                        <span class="{{ $order->payment->status === 'paid' ? 'badge-completed' : 'badge-pending' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @if($order->payment->payment_method)
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Metode Bayar</p>
                        <p class="font-semibold text-slate-800">{{ strtoupper($order->payment->payment_method) }}</p>
                    </div>
                    @endif
                    @if($order->payment->paid_at)
                    <div>
                        <p class="text-xs text-slate-400 mb-1">Waktu Bayar</p>
                        <p class="font-semibold text-slate-800">{{ $order->payment->paid_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    @endif
                    @if($order->payment->status === 'pending' && $order->payment->xendit_invoice_url)
                        <a href="{{ $order->payment->xendit_invoice_url }}" target="_blank"
                           class="btn-secondary w-full flex items-center justify-center gap-2 text-sm mt-2">
                            💳 Bayar Sekarang
                        </a>
                    @endif
                @else
                    <div class="text-center py-4">
                        <p class="text-slate-400 text-xs">Belum ada data pembayaran</p>
                    </div>
                @endif
            </div>
        </div>

        <a href="{{ route('orders.index') }}"
           class="w-full flex items-center justify-center text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl px-5 py-3 transition-all">
            ← Kembali ke Pesanan Saya
        </a>

    </div>
</div>

@endsection