<x-guest-layout>

    @section('title', 'Masuk — NusantaraSmart')

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang!</h2>
        <p class="text-sm text-slate-500 mt-1">Masuk ke akun NusantaraSmart kamu</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                Alamat Email
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="contoh@email.com"
                   required autofocus autocomplete="username"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="text-sm font-medium text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs text-[#0f1f5c] hover:underline font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password"
                   type="password"
                   name="password"
                   placeholder="••••••••"
                   required autocomplete="current-password"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 text-[#0f1f5c] bg-slate-100 border-slate-300 rounded focus:ring-[#0f1f5c]">
            <label for="remember_me" class="text-sm text-slate-600 cursor-pointer">
                Ingat saya
            </label>
        </div>

        {{-- Tombol Login --}}
        <button type="submit"
                class="btn-primary w-full flex items-center justify-center gap-2 text-sm py-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk ke Akun
        </button>

        {{-- Link Register --}}
        <p class="text-center text-sm text-slate-500">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-[#0f1f5c] font-semibold hover:underline">
                Daftar sekarang
            </a>
        </p>

    </form>

</x-guest-layout>