<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="glass-input px-4 py-2.5 @error('email') border-red-400/50 @enderror"
                placeholder="Masukkan email Anda">
            @error('email')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="glass-input px-4 py-2.5 @error('password') border-red-400/50 @enderror"
                placeholder="Masukkan password Anda">
            @error('password')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded-md bg-white/5 border-white/20 text-emerald-500 focus:ring-emerald-500/30 focus:ring-offset-0">
                <span class="text-sm text-gray-400">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
            Masuk
        </button>

        <p class="text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Biro Umum Setda Provinsi Banten
        </p>
    </form>
</x-guest-layout>
