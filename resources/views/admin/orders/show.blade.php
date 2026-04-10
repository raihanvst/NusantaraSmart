@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

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

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <p class="text-sm font-mono text-slate-500">{{ $order->order_number }}</p>
    </div>
    <span class="{{ $badge }} text-sm px-3 py-1.5">{{ $label }}</span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- KIRI --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Pesanan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Informasi Pesanan</h2>
            </div>
            <div class="p-6 grid grid-cols-2 gap-5 text-sm">
                <div>
                    <p class="text-xs text-slate-400 mb-1">No. Pesanan</p>
                    <p class="font-mono font-semibold text-slate-800">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Tanggal</p>
                    <p class="font-medium text-slate-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Customer</p>
                    <p class="font-semibold text-slate-800">{{ $order->user->name }}</p>
                    <p class="text-xs text-slate-400">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-slate-800 leading-relaxed">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="col-span-2">
                    <p class="text-xs text-slate-400 mb-1">Catatan</p>
                    <p class="text-slate-600">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Item Pesanan</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Produk</th>
                        <th class="px-6 py-3 text-center font-medium">Qty</th>
                        <th class="px-6 py-3 text-right font-medium">Harga</th>
                        <th class="px-6 py-3 text-right font-medium">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($order->orderItems as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3.5 font-medium text-slate-800">{{ $item->product->name }}</td>
                        <td class="px-6 py-3.5 text-center text-slate-600">{{ $item->quantity }}</td>
                        <td class="px-6 py-3.5 text-right text-slate-600">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3.5 text-right font-semibold text-slate-800">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-slate-200">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold text-slate-700">Total</td>
                        <td class="px-6 py-4 text-right font-bold text-[#0f1f5c] text-base">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    {{-- KANAN --}}
    <div class="space-y-5">

        {{-- Update Status --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
                <h2 class="text-sm font-semibold text-slate-700">Update Status</h2>
            </div>
            <div class="p-6">
                <p class="text-xs text-slate-400 mb-3">Status saat ini:</p>
                <span class="{{ $badge }} text-sm px-3 py-1.5 mb-5 inline-block">{{ $label }}</span>
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ubah ke status:</label>
                    <select name="status" class="input-field mb-4">
                        <option value="pending"    {{ $order->status == 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="paid"       {{ $order->status == 'paid'       ? 'selected' : '' }}>Dibayar</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped"    {{ $order->status == 'shipped'    ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed"  {{ $order->status == 'completed'  ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn-primary w-full text-sm">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Pembayaran --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                        <p class="font-semibold text-slate-800">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                @else
                    <p class="text-slate-400 text-xs text-center py-4">Belum ada data pembayaran</p>
                @endif
            </div>
        </div>

        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center justify-center w-full text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl px-5 py-3 transition-all">
            ← Kembali ke Daftar Pesanan
        </a>

    </div>
</div>

@endsection