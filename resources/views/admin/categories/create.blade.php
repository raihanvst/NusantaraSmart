@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')

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
        <li>
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-500 hover:text-green-600 ms-1 md:ms-2">Kategori</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="text-sm text-gray-500 ms-1 md:ms-2">Tambah Baru</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-xl">

    {{-- Card Form --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
            <h2 class="text-sm font-semibold text-gray-700">Informasi Kategori</h2>
            <p class="text-xs text-gray-400 mt-0.5">Isi form di bawah untuk menambahkan kategori baru</p>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="p-6">
            @csrf

            {{-- ============================================================
                 INPUT FIELD
                 Sumber: https://flowbite.com/docs/forms/input-field/
                 Tipe: Input with validation error state
                 ============================================================ --}}
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="contoh: Smart Lighting"
                       autofocus
                       class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 transition
                              {{ $errors->has('name')
                                 ? 'border-red-500 focus:ring-red-300 bg-red-50'
                                 : 'border-gray-300 focus:ring-green-300 focus:border-green-500' }}">
                {{-- Error State --}}
                @error('name')
                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- ============================================================
                 TEXTAREA
                 Sumber: https://flowbite.com/docs/forms/textarea/
                 ============================================================ --}}
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-700">
                    Deskripsi
                    <span class="font-normal text-gray-400 text-xs">(opsional)</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          placeholder="Deskripsi singkat tentang kategori ini..."
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-green-300 focus:border-green-500 focus:outline-none transition resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit"
                        class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 transition-colors">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

@endsection