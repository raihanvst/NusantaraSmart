<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — NusantaraSmart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

{{-- ============================================================
     SIDEBAR
     Sumber: https://flowbite.com/docs/components/sidebar/
     Tipe: Sidebar with multi-level dropdown
     ============================================================ --}}
<aside id="default-sidebar"
       class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
       aria-label="Sidebar">

    <div class="h-full flex flex-col bg-white border-r border-gray-200 overflow-y-auto">

        {{-- Logo --}}
        <div class="px-5 py-4 border-b border-gray-100">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-green-600 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 leading-none">NusantaraSmart</p>
                    <p class="text-xs text-gray-400 mt-0.5">Admin Panel</p>
                </div>
            </a>
        </div>

        {{-- Menu Items (Flowbite Sidebar style) --}}
        <ul class="flex-1 px-3 py-4 space-y-1 font-medium">

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center p-2 rounded-lg group transition-colors
                          {{ request()->is('admin/dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="ms-3 text-sm">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center p-2 rounded-lg group transition-colors
                          {{ request()->is('admin/categories*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="ms-3 text-sm">Kategori</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center p-2 rounded-lg group transition-colors
                          {{ request()->is('admin/products*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="ms-3 text-sm">Produk</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center p-2 rounded-lg group transition-colors
                          {{ request()->is('admin/orders*') ? 'bg-green-50 text-green-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="ms-3 text-sm">Pesanan</span>
                </a>
            </li>

        </ul>

        {{-- User Info & Logout --}}
        <div class="px-3 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3 p-2 mb-1">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center
                            text-green-700 text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center w-full p-2 rounded-lg text-sm text-red-600 hover:bg-red-50 transition-colors gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </div>
</aside>

{{-- ===== MAIN CONTENT ===== --}}
<div class="sm:ml-64 min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="sticky top-0 z-30 bg-white border-b border-gray-200">
        <div class="px-6 py-4 flex items-center justify-between">
            <h1 class="text-base font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <span class="text-xs text-gray-400 hidden sm:block">
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </header>

    {{-- Konten --}}
    <main class="flex-1 p-6">

        {{-- ============================================================
             ALERT — Flash Messages
             Sumber: https://flowbite.com/docs/components/alerts/
             Tipe: Alerts with icon & dismiss button
             ============================================================ --}}
        @if(session('success'))
            <div id="alert-success" role="alert"
                 class="flex items-center p-4 mb-5 text-green-800 rounded-lg bg-green-50 border border-green-200">
                <svg class="flex-shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
                <button type="button"
                        onclick="document.getElementById('alert-success').remove()"
                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8">
                    <span class="sr-only">Tutup</span>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" role="alert"
                 class="flex items-center p-4 mb-5 text-red-800 rounded-lg bg-red-50 border border-red-200">
                <svg class="flex-shrink-0 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"/>
                </svg>
                <span class="sr-only">Error</span>
                <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
                <button type="button"
                        onclick="document.getElementById('alert-error').remove()"
                        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        @yield('content')

    </main>
</div>

{{-- Flowbite JS — WAJIB untuk Modal, Dropdown, dll --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>