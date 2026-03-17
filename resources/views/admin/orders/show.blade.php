@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('content')

<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-green-600">
                <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/></svg>
                Dashboard
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-green-600 ms-1">Pesanan</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                <span class="text-sm text-gray-500 ms-1">{{ $order->order_number }}</span>
            </div>
        </li>
    </ol>
</nav>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- KIRI: Detail Order --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Info Pesanan --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Informasi Pesanan</h2>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs mb-1">No. Pesanan</p>
                    <p class="font-mono font-semibold text-gray-800">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Tanggal</p>
                    <p class="font-medium text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Customer</p>
                    <p class="font-medium text-gray-800">{{ $order->user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Alamat Pengiriman</p>
                    <p class="font-medium text-gray-800">{{ $order->shipping_address }}</p>
                </div>
                @if($order->notes)
                <div class="col-span-2">
                    <p class="text-gray-400 text-xs mb-1">Catatan</p>
                    <p class="text-gray-600">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Item Pesanan</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Produk</th>
                        <th class="px-6 py-3 text-center">Qty</th>
                        <th class="px-6 py-3 text-right">Harga Satuan</th>
                        <th class="px-6 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($order->orderItems as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3.5 font-medium text-gray-800">
                            {{ $item->product->name }}
                        </td>
                        <td class="px-6 py-3.5 text-center text-gray-600">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-3.5 text-right text-gray-600">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3.5 text-right font-semibold text-gray-800">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t-2 border-gray-200">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-semibold text-gray-700">
                            Total Pembayaran
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-green-700 text-base">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    {{-- KANAN: Status & Payment --}}
    <div class="space-y-5">

        {{-- Update Status --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h2 class="text-sm font-semibold text-gray-700">Update Status</h2>
            </div>
            <div class="p-6">
                <p class="text-xs text-gray-400 mb-3">Status saat ini:</p>
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
                <span class="text-sm font-semibold px-3 py-1.5 rounded-full {{ $badge[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                    {{ $label[$order->status] ?? $order->status }}
                </span>

                <form action="{{ route('admin.orders.updateStatus', $order) }}"
                      method="POST" class="mt-5">
                    @csrf
                    @method('PATCH')
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ubah ke status:
                    </label>
                    <select name="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-300 focus:border-green-500 focus:outline-none block w-full p-2.5 mb-4">
                        <option value="pending"    {{ $order->status == 'pending'    ? 'selected' : '' }}>Pending</option>
                        <option value="paid"       {{ $order->status == 'paid'       ? 'selected' : '' }}>Dibayar</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped"    {{ $order->status == 'shipped'    ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed"  {{ $order->status == 'completed'  ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        Simpan Perubahan
                    </button>
                </form>
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
                        <p class="text-xs text-gray-400 mb-1">Status Pembayaran</p>
                        <span class="text-xs font-medium px-2.5 py-0.5 rounded-full
                            {{ $order->payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
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
                        <p class="font-medium text-gray-800">{{ $order->payment->paid_at->format('d M Y, H:i') }}</p>
                    </div>
                    @endif
                @else
                    <p class="text-gray-400 text-xs text-center py-4">
                        Belum ada data pembayaran
                    </p>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection