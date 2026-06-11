<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="text-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Pengaju Kendaraan</h2>
            <p class="text-gray-500 text-sm mt-1">Isi data diri untuk mendaftar</p>
        </div>

        <div class="form-group">
            <label class="form-label">NIP *</label>
            <input type="text" name="nip" value="{{ old('nip') }}" required
                class="glass-input px-4 py-2.5 @error('nip') border-red-400/50 @enderror"
                placeholder="Masukkan NIP">
            @error('nip')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="glass-input px-4 py-2.5 @error('name') border-red-400/50 @enderror"
                placeholder="Masukkan nama lengkap">
            @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="glass-input px-4 py-2.5 @error('email') border-red-400/50 @enderror"
                placeholder="Masukkan email">
            @error('email')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Jabatan *</label>
            <input type="text" name="position" value="{{ old('position') }}" required
                class="glass-input px-4 py-2.5 @error('position') border-red-400/50 @enderror"
                placeholder="Masukkan jabatan">
            @error('position')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Nomor Telepon *</label>
            <input type="text" name="phone" value="{{ old('phone') }}" required
                class="glass-input px-4 py-2.5 @error('phone') border-red-400/50 @enderror"
                placeholder="Masukkan nomor telepon">
            @error('phone')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password *</label>
            <input type="password" name="password" required
                class="glass-input px-4 py-2.5 @error('password') border-red-400/50 @enderror"
                placeholder="Minimal 8 karakter">
            @error('password')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password *</label>
            <input type="password" name="password_confirmation" required
                class="glass-input px-4 py-2.5"
                placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3 text-base">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Daftar
        </button>

        <p class="text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Masuk</a>
        </p>

        <p class="text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Biro Umum Setda Provinsi Banten
        </p>
    </form>
</x-guest-layout>