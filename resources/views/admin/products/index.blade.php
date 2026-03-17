@extends('layouts.admin')
@use('Illuminate\Support\Facades\Storage')
@use('Illuminate\Support\Str')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-green-600">
                <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="text-sm text-gray-500 ms-1 md:ms-2">Produk</span>
            </div>
        </li>
    </ol>
</nav>

<div class="flex items-center justify-between mb-4">
    <p class="text-sm text-gray-500">
        Total <span class="font-semibold text-gray-700">{{ $products->count() }}</span> produk
    </p>
    <a href="{{ route('admin.products.create') }}"
       class="flex items-center gap-2 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </a>
</div>

{{-- TABLE: https://flowbite.com/docs/components/tables/ --}}
<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">

        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">Produk</th>
                <th scope="col" class="px-6 py-3">Kategori</th>
                <th scope="col" class="px-6 py-3">Harga</th>
                <th scope="col" class="px-6 py-3">Stok</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
            <tr class="bg-white border-b hover:bg-gray-50 transition-colors">

                {{-- Produk --}}
                <th scope="row" class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-10 h-10 rounded-lg object-cover border border-gray-200 flex-shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-800 text-sm truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit($product->description, 40) }}</p>
                        </div>
                    </div>
                </th>

                {{-- Kategori --}}
                <td class="px-6 py-4">
                    {{-- BADGE: https://flowbite.com/docs/components/badge/ --}}
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $product->category->name }}
                    </span>
                </td>

                {{-- Harga --}}
                <td class="px-6 py-4 font-semibold text-gray-800">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </td>

                {{-- Stok --}}
                <td class="px-6 py-4">
                    @if($product->stock <= 0)
                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Habis</span>
                    @elseif($product->stock <= 5)
                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $product->stock }} — Menipis</span>
                    @else
                        <span class="text-gray-700 font-medium text-sm">{{ $product->stock }}</span>
                    @endif
                </td>

                {{-- Status --}}
                <td class="px-6 py-4">
                    @if($product->is_active)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Aktif</span>
                    @else
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">Nonaktif</span>
                    @endif
                </td>

                {{-- Aksi --}}
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-3">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="font-medium text-blue-600 hover:underline text-sm">Edit</a>
                        <button type="button"
                                data-modal-target="modal-hapus-produk-{{ $product->id }}"
                                data-modal-toggle="modal-hapus-produk-{{ $product->id }}"
                                class="font-medium text-red-600 hover:underline text-sm">
                            Hapus
                        </button>
                    </div>
                </td>

            </tr>

            {{-- MODAL HAPUS PRODUK: https://flowbite.com/docs/components/modal/ --}}
            <div id="modal-hapus-produk-{{ $product->id }}" tabindex="-1"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-2xl shadow">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-800">Konfirmasi Hapus</h3>
                            </div>
                            <button data-modal-hide="modal-hapus-produk-{{ $product->id }}"
                                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-4 md:p-5">
                            <p class="text-sm text-gray-600">
                                Yakin ingin menghapus produk
                                <span class="font-semibold text-gray-800">"{{ $product->name }}"</span>?
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Gambar produk juga akan ikut terhapus permanen.</p>
                        </div>
                        <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200">
                            <button data-modal-hide="modal-hapus-produk-{{ $product->id }}"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                                Batal
                            </button>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center bg-white">
                    <div class="flex flex-col items-center gap-2 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <p class="text-sm font-medium">Belum ada produk</p>
                        <a href="{{ route('admin.products.create') }}" class="text-sm text-green-600 hover:underline">
                            Tambah produk pertama →
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>

@endsection