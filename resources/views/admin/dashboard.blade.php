@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ============================================================
     KARTU STATISTIK
     Sumber: https://flowbite.com/docs/components/card/
     ============================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-7">

    {{-- Card: Total Pesanan --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
        <p class="text-xs text-gray-400 mt-1">Semua pesanan masuk</p>
    </div>

    {{-- Card: Pesanan Pending --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Menunggu Bayar</p>
            <div class="w-10 h-10 bg-yellow-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $pendingOrders }}</p>
        <p class="text-xs text-gray-400 mt-1">Pesanan belum dibayar</p>
    </div>

    {{-- Card: Total Pendapatan --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-800">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </p>
        <p class="text-xs text-gray-400 mt-1">Dari pesanan yang dibayar</p>
    </div>

    {{-- Card: Produk Aktif --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm font-medium text-gray-500">Produk Aktif</p>
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</p>
        <p class="text-xs text-gray-400 mt-1">Produk tampil di katalog</p>
    </div>

</div>

{{-- ============================================================
     2 KOLOM: Pesanan Terbaru + Stok Menipis
     ============================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- KIRI: Pesanan Terbaru (2/3 lebar) --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-xs text-green-600 hover:underline font-medium">
                    Lihat semua →
                </a>
            </div>

            {{-- TABLE: https://flowbite.com/docs/components/tables/ --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-medium">No. Pesanan</th>
                            <th class="px-6 py-3 font-medium">Customer</th>
                            <th class="px-6 py-3 font-medium">Total</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentOrders as $order)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-3.5">
                                <span class="font-mono text-xs text-gray-600">
                                    {{ $order->order_number }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                <div>
                                    <p class="font-medium text-gray-800 text-xs">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-3.5 font-semibold text-gray-800 text-xs">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-3.5">
                                {{-- BADGE: https://flowbite.com/docs/components/badge/ --}}
                                @php
                                    $statusConfig = [
                                        'pending'    => ['bg-yellow-100 text-yellow-800', 'Pending'],
                                        'paid'       => ['bg-blue-100 text-blue-800', 'Dibayar'],
                                        'processing' => ['bg-purple-100 text-purple-800', 'Diproses'],
                                        'shipped'    => ['bg-indigo-100 text-indigo-800', 'Dikirim'],
                                        'completed'  => ['bg-green-100 text-green-800', 'Selesai'],
                                        'cancelled'  => ['bg-red-100 text-red-800', 'Dibatalkan'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-600', $order->status];
                                @endphp
                                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $config[0] }}">
                                    {{ $config[1] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                                Belum ada pesanan masuk
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- KANAN: Stok Menipis (1/3 lebar) --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-700">Stok Menipis</h2>
                <a href="{{ route('admin.products.index') }}"
                   class="text-xs text-green-600 hover:underline font-medium">
                    Kelola →
                </a>
            </div>

            {{-- Daftar Produk --}}
            <div class="divide-y divide-gray-50">
                @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between px-6 py-3.5 hover:bg-gray-50 transition-colors">
                    <div class="flex-1 min-w-0 mr-3">
                        <p class="text-xs font-semibold text-gray-800 truncate">
                            {{ $product->name }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $product->category->name }}
                        </p>
                    </div>
                    {{-- Badge warna sesuai level stok --}}
                    @if($product->stock <= 0)
                        <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded-full flex-shrink-0">
                            Habis
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded-full flex-shrink-0">
                            {{ $product->stock }} sisa
                        </span>
                    @endif
                </div>
                @empty
                <div class="px-6 py-10 text-center text-gray-400 text-sm">
                    <p>🎉 Semua stok aman!</p>
                </div>
                @endforelse
            </div>

        </div>

        {{-- Card Info Customer --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 mt-5">
            <div class="flex items-center justify-between mb-1">
                <p class="text-sm font-medium text-gray-500">Total Customer</p>
                <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</p>
            <p class="text-xs text-gray-400 mt-1">Customer terdaftar</p>
        </div>

    </div>

</div>

@endsection