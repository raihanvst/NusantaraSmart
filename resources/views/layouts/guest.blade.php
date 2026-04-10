<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NusantaraSmart')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">

<div class="min-h-screen flex">

    {{-- ===== SISI KIRI — Batik Pattern ===== --}}
    <div class="hidden lg:flex lg:w-1/2 batik-pattern flex-col items-center justify-center p-12 relative">

        {{-- Logo & Brand --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">NusantaraSmart</h1>
            <p class="text-blue-200 text-sm">Solusi Smart Home untuk Rumah Modern Indonesia</p>
        </div>

        {{-- Feature Highlights --}}
        <div class="space-y-4 w-full max-w-sm">
            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/10">
                <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white text-sm font-semibold">Pembayaran Aman</p>
                    <p class="text-blue-300 text-xs">Terintegrasi dengan Xendit Payment Gateway</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/10">
                <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white text-sm font-semibold">Produk Terpercaya</p>
                    <p class="text-blue-300 text-xs">Smart home dari brand ternama dunia</p>
                </div>
            </div>

            <div class="flex items-center gap-4 bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-4 border border-white/10">
                <div class="w-10 h-10 bg-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white text-sm font-semibold">Belanja Mudah</p>
                    <p class="text-blue-300 text-xs">Checkout cepat dengan berbagai metode bayar</p>
                </div>
            </div>
        </div>

        {{-- Copyright di bawah --}}
        <p class="absolute bottom-6 text-blue-400 text-xs">
            © {{ date('Y') }} NusantaraSmart. All rights reserved.
        </p>

    </div>

    {{-- ===== SISI KANAN — Form ===== --}}
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center min-h-screen bg-slate-50 px-6 py-12">

        {{-- Logo Mobile (hanya muncul di HP) --}}
        <div class="lg:hidden text-center mb-8">
            <div class="w-14 h-14 bg-[#0f1f5c] rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-[#0f1f5c]">NusantaraSmart</h2>
        </div>

        {{-- Form Card --}}
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>

        {{-- Link ke toko --}}
        <p class="mt-6 text-xs text-slate-400">
            Mau lihat produk dulu?
            <a href="{{ route('shop.index') }}" class="text-[#0f1f5c] font-semibold hover:underline">
                Lihat Katalog →
            </a>
        </p>

    </div>

</div>

</body>
</html>