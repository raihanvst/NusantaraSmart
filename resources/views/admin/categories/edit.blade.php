@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')

<div class="max-w-xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/60">
            <h2 class="text-sm font-semibold text-slate-700">Edit — {{ $category->name }}</h2>
        </div>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" autofocus
                       class="input-field {{ $errors->has('name') ? 'border-red-400' : '' }}">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="input-field resize-none">{{ old('description', $category->description) }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="btn-primary flex items-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 px-5 py-2.5 rounded-xl transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection