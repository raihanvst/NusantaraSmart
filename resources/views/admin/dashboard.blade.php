@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Kartu Statistik --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-slate-500">Total Pesanan</p>
            <div class="w-9 h-9 bg-[#0f1f5c]/10 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-[#0f1f5c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalOrders }}</p>
        <p class="text-xs text-slate-400 mt-1">Semua pesanan masuk</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-slate-500">Menunggu Bayar</p>
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $pendingOrders }}</p>
        <p class="text-xs text-slate-400 mt-1">Belum dibayar</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-slate-500">Total Pendapatan</p>
            <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-xl font-bold text-slate-800">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </p>
        <p class="text-xs text-slate-400 mt-1">Dari pesanan terbayar</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs font-medium text-slate-500">Produk Aktif</p>
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalProducts }}</p>
        <p class="text-xs text-slate-400 mt-1">Tampil di katalog</p>
    </div>

</div>

{{-- Pesanan Terbaru + Stok Menipis --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- Pesanan Terbaru --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-700">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}"
               class="text-xs font-medium text-[#0f1f5c] hover:underline">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">No. Pesanan</th>
                        <th class="px-6 py-3 text-left font-medium">Customer</th>
                        <th class="px-6 py-3 text-left font-medium">Total</th>
                        <th class="px-6 py-3 text-left font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentOrders as $order)
                    @php
                        $badge = [
                            'pending'    => 'badge-pending',
                            'paid'       => 'badge-paid',
                            'processing' => 'badge-processing',
                            'shipped'    => 'badge-shipped',
                            'completed'  => 'badge-completed',
                            'cancelled'  => 'badge-cancelled',
                        ][$order->status] ?? 'badge-pending';
                        $label = [
                            'pending'    => 'Pending',
                            'paid'       => 'Dibayar',
                            'processing' => 'Diproses',
                            'shipped'    => 'Dikirim',
                            'completed'  => 'Selesai',
                            'cancelled'  => 'Dibatalkan',
                        ][$order->status] ?? $order->status;
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3.5 font-mono text-xs text-slate-600">{{ $order->order_number }}</td>
                        <td class="px-6 py-3.5">
                            <p class="text-xs font-semibold text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                        </td>
                        <td class="px-6 py-3.5 text-xs font-semibold text-slate-800">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="{{ $badge }}">{{ $label }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 text-sm">
                            Belum ada pesanan masuk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kanan: Stok + Customer --}}
    <div class="space-y-5">

        {{-- Stok Menipis --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-700">Stok Menipis</h2>
                <a href="{{ route('admin.products.index') }}"
                   class="text-xs font-medium text-[#0f1f5c] hover:underline">Kelola →</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between px-6 py-3.5">
                    <div class="flex-1 min-w-0 mr-3">
                        <p class="text-xs font-semibold text-slate-800 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $product->category->name }}</p>
                    </div>
                    @if($product->stock <= 0)
                        <span class="badge-cancelled">Habis</span>
                    @else
                        <span class="badge-pending">{{ $product->stock }} sisa</span>
                    @endif
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">
                    Semua stok aman! 🎉
                </div>
                @endforelse
            </div>
        </div>

        {{-- Total Customer --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center justify-between mb-1">
                <p class="text-xs font-medium text-slate-500">Total Customer</p>
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-slate-800">{{ $totalCustomers }}</p>
            <p class="text-xs text-slate-400 mt-1">Customer terdaftar</p>
        </div>

    </div>
</div>

@endsection