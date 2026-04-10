@extends('layouts.admin')

@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')

@section('content')

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-3 font-medium">No. Pesanan</th>
                <th class="px-6 py-3 font-medium">Customer</th>
                <th class="px-6 py-3 font-medium">Total</th>
                <th class="px-6 py-3 font-medium">Tanggal</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($orders as $order)
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
                <td class="px-6 py-4 font-mono text-xs text-slate-600">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-slate-800 text-xs">{{ $order->user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-xs text-slate-500">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-6 py-4">
                    <span class="{{ $badge }}">{{ $label }}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.orders.show', $order) }}"
                       class="text-xs font-semibold text-[#0f1f5c] hover:underline">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-slate-400 text-sm">
                    Belum ada pesanan masukx`x
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection