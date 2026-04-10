<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — NusantaraSmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 antialiased">

<aside id="sidebar"
       class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 flex flex-col bg-[#0f1f5c] shadow-xl">

    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-[#1e3a8a]">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold text-sm leading-none">NusantaraSmart</p>
                <p class="text-blue-300 text-xs mt-0.5">Admin Panel</p>
            </div>
        </a>
    </div>

    {{-- Navigasi --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        @php
            $navItems = [
                ['route' => 'admin.dashboard',        'label' => 'Dashboard', 'match' => 'admin/dashboard',
                 'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'admin.categories.index', 'label' => 'Kategori',  'match' => 'admin/categories*',
                 'icon'  => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z'],
                ['route' => 'admin.products.index',   'label' => 'Produk',    'match' => 'admin/products*',
                 'icon'  => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['route' => 'admin.orders.index',     'label' => 'Pesanan',   'match' => 'admin/orders*',
                 'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ];
        @endphp

        @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                  {{ request()->is($item['match'])
                     ? 'bg-amber-500 text-white shadow-sm'
                     : 'text-blue-200 hover:bg-[#1e3a8a] hover:text-white' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
            </svg>
            {{ $item['label'] }}
        </a>
        @endforeach
    </nav>

    {{-- User & Logout --}}
    <div class="px-3 py-4 border-t border-[#1e3a8a]">
        <div class="flex items-center gap-3 px-3 mb-2">
            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-300 truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="flex items-center w-full gap-3 px-3 py-2 rounded-xl text-sm text-red-300 hover:bg-red-500/10 hover:text-red-200 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>

{{-- Toggle Sidebar Mobile --}}
<div class="sm:hidden fixed top-4 left-4 z-50">
    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')"
            class="p-2 bg-[#0f1f5c] text-white rounded-xl shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>

{{-- Main Content --}}
<div class="sm:ml-64 min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 bg-white border-b border-slate-200 shadow-sm">
        <div class="px-6 py-4 flex items-center justify-between">
            <h1 class="text-base font-semibold text-slate-800 hidden sm:block">
                @yield('page-title', 'Dashboard')
            </h1>
            <div class="flex items-center gap-3 ms-auto">
                <a href="{{ route('shop.index') }}" target="_blank"
                   class="text-xs font-medium text-slate-500 hover:text-[#0f1f5c] flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Toko
                </a>
                <span class="text-xs text-slate-400 hidden md:block">
                    {{ now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </header>

    {{-- Konten --}}
    <main class="flex-1 p-5 md:p-6">

        @if(session('success'))
            <div id="alert-success" role="alert"
                 class="flex items-center p-4 mb-5 text-green-800 rounded-xl bg-green-50 border border-green-200">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button onclick="document.getElementById('alert-success').remove()"
                        class="ms-auto text-green-600 hover:text-green-800 p-1 rounded-lg hover:bg-green-100">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" role="alert"
                 class="flex items-center p-4 mb-5 text-red-800 rounded-xl bg-red-50 border border-red-200">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                <button onclick="document.getElementById('alert-error').remove()"
                        class="ms-auto text-red-600 hover:text-red-800 p-1 rounded-lg hover:bg-red-50">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>