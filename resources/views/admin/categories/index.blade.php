@extends('layouts.admin')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')

<div class="flex items-center justify-between mb-5">
    <p class="text-sm text-slate-500">
        Total <span class="font-semibold text-slate-700">{{ $categories->count() }}</span> kategori
    </p>
    <a href="{{ route('admin.categories.create') }}"
       class="flex items-center gap-2 bg-[#0f1f5c] hover:bg-[#1e3a8a] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Kategori
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-200">
            <tr>
                <th class="px-6 py-3 font-medium">No</th>
                <th class="px-6 py-3 font-medium">Nama Kategori</th>
                <th class="px-6 py-3 font-medium">Slug</th>
                <th class="px-6 py-3 font-medium">Deskripsi</th>
                <th class="px-6 py-3 font-medium">Produk</th>
                <th class="px-6 py-3 font-medium text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($categories as $index => $category)
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-6 py-4 text-slate-400 text-xs">{{ $index + 1 }}</td>
                <td class="px-6 py-4 font-semibold text-slate-800">{{ $category->name }}</td>
                <td class="px-6 py-4">
                    <code class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-lg font-mono">
                        {{ $category->slug }}
                    </code>
                </td>
                <td class="px-6 py-4 text-xs text-slate-500 max-w-xs truncate">
                    {{ $category->description ?? '—' }}
                </td>
                <td class="px-6 py-4">
                    <span class="{{ $category->products_count > 0 ? 'badge-completed' : 'badge-cancelled' }}">
                        {{ $category->products_count }} produk
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                            Edit
                        </a>
                        <button type="button"
                                data-modal-target="modal-hapus-{{ $category->id }}"
                                data-modal-toggle="modal-hapus-{{ $category->id }}"
                                class="text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>

            {{-- Modal Hapus --}}
            <div id="modal-hapus-{{ $category->id }}" tabindex="-1"
                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-2xl shadow-xl">
                        <div class="flex items-center justify-between p-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-slate-800">Konfirmasi Hapus</h3>
                            </div>
                            <button data-modal-hide="modal-hapus-{{ $category->id }}"
                                    class="text-slate-400 hover:bg-slate-100 rounded-lg p-1.5 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-5">
                            <p class="text-sm text-slate-600">
                                Yakin hapus kategori <span class="font-semibold text-slate-800">"{{ $category->name }}"</span>?
                            </p>
                            <p class="text-xs text-slate-400 mt-1">Tindakan ini tidak bisa dibatalkan.</p>
                        </div>
                        <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100">
                            <button data-modal-hide="modal-hapus-{{ $category->id }}"
                                    class="text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl transition-colors">
                                Batal
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-sm font-semibold text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-xl transition-colors">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-slate-400">
                    <p class="text-sm mb-2">Belum ada kategori</p>
                    <a href="{{ route('admin.categories.create') }}" class="text-sm text-[#0f1f5c] hover:underline font-medium">
                        Tambah kategori pertama →
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection