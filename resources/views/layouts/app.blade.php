<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusantaraSmart') — Smart Home Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased flex flex-col min-h-screen">

{{-- ============================================================
     NAVBAR
     Sumber: https://flowbite.com/docs/components/navbar/
     ============================================================ --}}
<nav class="bg-[#0f1f5c] border-b border-[#1e3a8a] sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('shop.index') }}" class="flex items-center gap-2.5 flex-shrink-0">
                <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="hidden sm:block">
                    <p class="text-white font-bold text-sm leading-none">NusantaraSmart</p>
                    <p class="text-blue-300 text-xs">Smart Home Store</p>
                </div>
            </a>

            {{-- Search Bar --}}
            <div class="flex-1 max-w-md mx-4 lg:mx-8">
                <form action="{{ route('shop.index') }}" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari produk smart home..."
                               class="w-full pl-10 pr-4 py-2 text-sm bg-[#1e3a8a] border border-[#2d4fa3] rounded-xl text-white placeholder-blue-300 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:bg-[#152966] transition-all">
                    </div>
                </form>
            </div>

            {{-- Kanan: Cart + User --}}
            <div class="flex items-center gap-2">

                @auth
                {{-- Cart --}}
                <a href="{{ route('cart.index') }}"
                   class="relative flex items-center gap-1.5 px-3 py-2 text-blue-200 hover:text-white hover:bg-[#1e3a8a] rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="hidden sm:inline text-sm font-medium">Keranjang</span>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-amber-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- User Dropdown --}}
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                            class="flex items-center gap-2 px-3 py-2 text-blue-200 hover:text-white hover:bg-[#1e3a8a] rounded-xl transition-all">
                        <div class="w-7 h-7 bg-amber-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl border border-slate-200 shadow-xl z-50 overflow-hidden">
                        <div class="px-4 py-3 bg-[#0f1f5c]">
                            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-300 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <ul class="py-2 text-sm">
                            <li>
                                <a href="{{ route('orders.index') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-50 hover:text-[#0f1f5c] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    Pesanan Saya
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                   class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:bg-slate-50 hover:text-[#0f1f5c] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Admin Panel
                                </a>
                            </li>
                            @endif
                            <li class="border-t border-slate-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-2 w-full px-4 py-2 text-red-500 hover:bg-red-50 transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}"
                   class="text-sm font-medium text-blue-200 hover:text-white px-3 py-2 rounded-xl hover:bg-[#1e3a8a] transition-all">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="text-sm font-semibold text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-xl transition-all shadow-sm">
                    Daftar
                </a>
                @endauth

            </div>
        </div>
    </div>
</nav>

{{-- Konten Utama --}}
<main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
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

{{-- Footer --}}
<footer class="bg-[#0f1f5c] border-t border-[#1e3a8a] mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white font-bold text-sm">NusantaraSmart</p>
                        <p class="text-blue-300 text-xs">Smart Home Store</p>
                    </div>
                </div>
                <p class="text-blue-300 text-sm leading-relaxed">
                    Solusi smart home terpercaya untuk rumah modern Indonesia.
                </p>
            </div>

            {{-- Links --}}
            <div>
                <h3 class="text-white font-semibold text-sm mb-3">Menu</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('shop.index') }}" class="text-blue-300 hover:text-amber-400 text-sm transition-colors">Katalog Produk</a></li>
                    @auth
                    <li><a href="{{ route('cart.index') }}" class="text-blue-300 hover:text-amber-400 text-sm transition-colors">Keranjang</a></li>
                    <li><a href="{{ route('orders.index') }}" class="text-blue-300 hover:text-amber-400 text-sm transition-colors">Pesanan Saya</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Info --}}
<div>
    <h3 class="text-white font-semibold text-sm mb-3">Informasi</h3>
    <ul class="space-y-2.5">
        <li class="flex items-center gap-2 text-blue-300 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Bandung, Indonesia
        </li>
        <li class="flex items-center gap-2 text-blue-300 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            hello@nusantarasmart.com
        </li>
        <li class="flex items-center gap-2 text-blue-300 text-sm">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Senin–Jumat, 09.00–17.00 WIB
        </li>
    </ul>
</div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>



