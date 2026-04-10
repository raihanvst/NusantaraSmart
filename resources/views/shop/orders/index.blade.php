@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Pesanan Saya</h1>
    <p class="text-sm text-slate-500 mt-1">Riwayat semua pesananmu di NusantaraSmart</p>
</div>

@if($orders->count() > 0)
<div class="space-y-4">
    @foreach($orders as $order)
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

    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/60">
            <div class="flex items-center gap-4 flex-wrap">
                <div>
                    <p class="text-xs text-slate-400">No. Pesanan</p>
                    <p class="text-sm font-mono font-semibold text-slate-800">{{ $order->order_number }}</p>
                </div>
                <div class="hidden sm:block">
                    <p class="text-xs text-slate-400">Tanggal</p>
                    <p class="text-sm font-medium text-slate-700">{{ $order->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <span class="{{ $badgeClass }}">{{ $label }}</span>
        </div>
        <div class="px-6 py-4 flex items-center justify-between flex-wrap gap-3">
            <div>
                <p class="text-xs text-slate-400 mb-1">Total Pembayaran</p>
                <p class="text-lg font-bold text-[#0f1f5c]">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                @if($order->status === 'pending' && $order->payment && $order->payment->xendit_invoice_url)
                    <a href="{{ $order->payment->xendit_invoice_url }}" target="_blank"
                       class="btn-secondary text-sm">
                        Bayar Sekarang
                    </a>
                @endif
                <a href="{{ route('orders.show', $order) }}"
                   class="text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl px-4 py-2 transition-all">
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($orders->hasPages())
    <div class="mt-6">{{ $orders->links() }}</div>
@endif

@else
<div class="flex flex-col items-center justify-center py-24 text-center">
    <div class="w-20 h-20 batik-pattern rounded-full flex items-center justify-center mb-5 shadow-lg">
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <h2 class="text-lg font-bold text-slate-700 mb-1">Belum ada pesanan</h2>
    <p class="text-sm text-slate-400 mb-6">Yuk mulai belanja produk smart home!</p>
    <a href="{{ route('shop.index') }}" class="btn-primary text-sm">Mulai Belanja</a>
</div>
@endif

@endsection