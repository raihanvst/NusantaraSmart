@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-green-600">
                <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/></svg>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                <span class="text-sm text-gray-500 ms-1">Pesanan</span>
            </div>
        </li>
    </ol>
</nav>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3">No. Pesanan</th>
                <th class="px-6 py-3">Customer</th>
                <th class="px-6 py-3">Total</th>
                <th class="px-6 py-3">Tanggal</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-mono text-xs">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                </td>
                <td class="px-6 py-4 font-semibold text-gray-800">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-xs text-gray-500">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
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
                            'pending'    => 'Pending',
                            'paid'       => 'Dibayar',
                            'processing' => 'Diproses',
                            'shipped'    => 'Dikirim',
                            'completed'  => 'Selesai',
                            'cancelled'  => 'Dibatalkan',
                        ];
                    @endphp
                    <span class="text-xs font-medium px-2.5 py-0.5 rounded-full {{ $badge[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ $label[$order->status] ?? $order->status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="font-medium text-green-600 hover:underline text-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-gray-400">
                    Belum ada pesanan masuk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection