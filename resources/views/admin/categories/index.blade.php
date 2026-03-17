@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')

{{-- ============================================================
     BREADCRUMB
     Sumber: https://flowbite.com/docs/components/breadcrumb/
     ============================================================ --}}
<nav class="flex mb-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-green-600">
                <svg class="w-3 h-3 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Dashboard
            </a>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">Kategori</span>
            </div>
        </li>
    </ol>
</nav>

{{-- Header & Tombol Tambah --}}
<div class="flex items-center justify-between mb-4">
    <div>
        <p class="text-sm text-gray-500">
            Total <span class="font-semibold text-gray-700">{{ $categories->count() }}</span> kategori
        </p>
    </div>
    {{-- BUTTON: https://flowbite.com/docs/components/buttons/ --}}
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kategori
    </a>
</div>

{{-- ============================================================
     TABLE
     Sumber: https://flowbite.com/docs/components/tables/
     Tipe: Table with striped rows
     ============================================================ --}}
<div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500">

        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
            <tr>
                <th scope="col" class="px-6 py-3">No</th>
                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                <th scope="col" class="px-6 py-3">Slug</th>
                <th scope="col" class="px-6 py-3">Deskripsi</th>
                <th scope="col" class="px-6 py-3">Produk</th>
                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($categories as $index => $category)
            <tr class="bg-white border-b hover:bg-gray-50">

                <td class="px-6 py-4 text-gray-400 text-xs">{{ $index + 1 }}</td>

                <th scope="row" class="px-6 py-4 font-semibold text-gray-800 whitespace-nowrap">
                    {{ $category->name }}
                </th>

                <td class="px-6 py-4">
                    <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded font-mono">
                        {{ $category->slug }}
                    </code>
                </td>

                <td class="px-6 py-4 text-xs text-gray-500 max-w-xs truncate">
                    {{ $category->description ?? '—' }}
                </td>

                <td class="px-6 py-4">
                    {{-- BADGE: https://flowbite.com/docs/components/badge/ --}}
                    @if($category->products_count > 0)
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $category->products_count }} produk
                        </span>
                    @else
                        <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            0 produk
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">

                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="font-medium text-blue-600 hover:text-blue-800 text-sm hover:underline">
                            Edit
                        </a>

                        {{-- Tombol Hapus — trigger Flowbite Modal --}}
                        <button type="button"
                                data-modal-target="modal-hapus-{{ $category->id }}"
                                data-modal-toggle="modal-hapus-{{ $category->id }}"
                                class="font-medium text-red-600 hover:text-red-800 text-sm hover:underline">
                            Hapus
                        </button>

                    </div>
                </td>

            </tr>

            {{-- ============================================================
                 MODAL KONFIRMASI HAPUS (per baris)
                 Sumber: https://flowbite.com/docs/components/modal/
                 Tipe: Default modal
                 ============================================================ --}}
            <div id="modal-hapus-{{ $category->id }}" tabindex="-1"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-2xl shadow">

                        {{-- Header Modal --}}
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-800">Konfirmasi Hapus</h3>
                            </div>
                            <button type="button"
                                    data-modal-hide="modal-hapus-{{ $category->id }}"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Body Modal --}}
                        <div class="p-4 md:p-5">
                            <p class="text-sm text-gray-600">
                                Apakah kamu yakin ingin menghapus kategori
                                <span class="font-semibold text-gray-800">"{{ $category->name }}"</span>?
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Tindakan ini tidak bisa dibatalkan.</p>
                        </div>

                        {{-- Footer Modal --}}
                        <div class="flex items-center justify-end gap-3 p-4 md:p-5 border-t border-gray-200">
                            <button type="button"
                                    data-modal-hide="modal-hapus-{{ $category->id }}"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                Batal
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
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
            {{-- END MODAL --}}

            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center bg-white">
                    <div class="flex flex-col items-center gap-2 text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <p class="text-sm font-medium">Belum ada kategori</p>
                        <a href="{{ route('admin.categories.create') }}" class="text-sm text-green-600 hover:underline">
                            Tambah kategori pertama →
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>
</div>

@endsection