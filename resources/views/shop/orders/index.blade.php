@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pesanan Saya</h1>
    <p class="text-sm text-gray-500 mt-1">Riwayat semua pesananmu di NusantaraSmart</p>
</div>

@if($orders->count() > 0)

<div class="space-y-4">
    @foreach($orders as $order)

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

    {{-- Order Card --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        {{-- Header Card --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/60">
            <div class="flex items-center gap-4">
                <div>
                    <p class="text-xs text-gray-400">No. Pesanan</p>
                    <p class="text-sm font-mono font-semibold text-gray-800">
                        {{ $order->order_number }}
                    </p>
                </div>
                <div class="hidden sm:block">
                    <p class="text-xs text-gray-400">Tanggal</p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>
            {{-- BADGE: https://flowbite.com/docs/components/badge/ --}}
            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $badge[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ $label[$order->status] ?? $order->status }}
            </span>
        </div>

        {{-- Body Card --}}
        <div class="px-6 py-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400 mb-1">Total Pembayaran</p>
                <p class="text-lg font-bold text-green-600">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Tombol Bayar (kalau masih pending) --}}
                @if($order->status === 'pending' && $order->payment && $order->payment->xendit_invoice_url)
                    <a href="{{ $order->payment->xendit_invoice_url }}"
                       target="_blank"
                       class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                        Bayar Sekarang
                    </a>
                @endif
                {{-- Tombol Detail --}}
                <a href="{{ route('orders.show', $order) }}"
                   class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                    Lihat Detail
                </a>
            </div>
        </div>

    </div>

    @endforeach
</div>

{{-- Pagination --}}
@if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endif

@else

{{-- Empty State --}}
<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-5">
        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <h2 class="text-lg font-bold text-gray-700 mb-1">Belum ada pesanan</h2>
    <p class="text-sm text-gray-400 mb-6">Yuk mulai belanja produk smart home!</p>
    <a href="{{ route('shop.index') }}"
       class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-xl text-sm px-6 py-3 transition-colors">
        Mulai Belanja
    </a>
</div>

@endif

@endsection