<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusantaraSmart') — Smart Home Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased">

{{-- ============================================================
     NAVBAR
     Sumber: https://flowbite.com/docs/components/navbar/
     ============================================================ --}}
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('shop.index') }}" class="flex items-center gap-2.5">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-base font-bold text-gray-800">NusantaraSmart</span>
            </a>

            {{-- Search Bar (tengah) --}}
            <div class="flex-1 max-w-md mx-8 hidden md:block">
                <form action="{{ route('shop.index') }}" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk smart home..."
                               class="w-full pl-10 pr-4 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-green-300 focus:bg-white transition">
                    </div>
                </form>
            </div>

            {{-- Kanan: Cart + User --}}
            <div class="flex items-center gap-3">

                {{-- Tombol Cart --}}
                @auth
                <a href="{{ route('cart.index') }}"
                   class="relative flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="hidden sm:inline">Keranjang</span>
                    {{-- Badge jumlah item di cart --}}
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-green-600 text-white text-xs rounded-full flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                @endauth

                {{-- User Menu --}}
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                                class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:text-green-600 transition-colors">
                            <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center text-green-700 text-xs font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        {{-- Dropdown --}}
                        <div class="hidden absolute right-0 mt-1 w-48 bg-white rounded-xl border border-gray-200 shadow-lg z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <ul class="py-1 text-sm">
                                <li>
                                    <a href="{{ route('orders.index') }}"
                                       class="block px-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-green-600">
                                        📋 Pesanan Saya
                                    </a>
                                </li>
                                @if(auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="block px-4 py-2 text-gray-600 hover:bg-gray-50 hover:text-green-600">
                                        ⚙️ Admin Panel
                                    </a>
                                </li>
                                @endif
                                <li class="border-t border-gray-100 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                            🚪 Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-green-600 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2 transition-colors">
                        Daftar
                    </a>
                @endauth

            </div>
        </div>
    </div>
</nav>

{{-- Konten Utama --}}
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="alert-success" role="alert"
             class="flex items-center p-4 mb-5 text-green-800 rounded-lg bg-green-50 border border-green-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div class="ms-3 text-sm font-medium">{{ session('success') }}</div>
            <button onclick="document.getElementById('alert-success').remove()"
                    class="ms-auto text-green-600 hover:text-green-800 p-1.5 rounded-lg hover:bg-green-100">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="alert-error" role="alert"
             class="flex items-center p-4 mb-5 text-red-800 rounded-lg bg-red-50 border border-red-200">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="ms-3 text-sm font-medium">{{ session('error') }}</div>
            <button onclick="document.getElementById('alert-error').remove()"
                    class="ms-auto text-red-600 hover:text-red-800 p-1.5 rounded-lg hover:bg-red-50">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @yield('content')

</main>

{{-- Footer --}}
<footer class="bg-white border-t border-gray-200 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-700">NusantaraSmart</span>
            </div>
            <p class="text-xs text-gray-400">© {{ date('Y') }} NusantaraSmart. Solusi smart home terpercaya.</p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>