<x-guest-layout>

    @section('title', 'Daftar — NusantaraSmart')

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-1">Daftar dan mulai belanja smart home impianmu</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                Nama Lengkap
            </label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Nama lengkapmu"
                   required autofocus autocomplete="name"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : '' }}">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
                   required autocomplete="username"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                Password
            </label>
            <input id="password"
                   type="password"
                   name="password"
                   placeholder="Minimal 8 karakter"
                   required autocomplete="new-password"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                Konfirmasi Password
            </label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   placeholder="Ulangi password"
                   required autocomplete="new-password"
                   class="input-field placeholder:text-slate-400 {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50' : '' }}">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Daftar --}}
        <button type="submit"
                class="btn-primary w-full flex items-center justify-center gap-2 text-sm py-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Buat Akun Sekarang
        </button>

        {{-- Link Login --}}
        <p class="text-center text-sm text-slate-500">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="text-[#0f1f5c] font-semibold hover:underline">
                Masuk di sini
            </a>
        </p>

    </form>

</x-guest-layout>