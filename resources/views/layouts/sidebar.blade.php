<aside class="fixed inset-y-0 left-0 z-50 w-64 glass-sidebar transform transition-all duration-300 -translate-x-full lg:translate-x-0"
       :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">
    <div class="flex flex-col h-full">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center gap-3">
                <img src="{{ asset('logo-banten.svg') }}" alt="Logo Banten" class="w-10 h-10">
                <div>
                    <p class="text-sm font-bold text-gray-800">SKPD Banten</p>
                    <p class="text-xs text-gray-500">Pemeliharaan Kendaraan</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto overflow-x-hidden">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            @role('admin')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Master Data</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="sidebar-link {{ request()->routeIs('admin.roles.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Role
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Pengguna
            </a>
            <a href="{{ route('admin.kendaraan.index') }}" class="sidebar-link {{ request()->routeIs('admin.kendaraan.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                Kendaraan
            </a>
            <a href="{{ route('admin.jenis-pemeliharaan.index') }}" class="sidebar-link {{ request()->routeIs('admin.jenis-pemeliharaan.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 00.659 1.591L19 14.5m-4.75-11.396c.251.023.501.05.75.082M12 21a8.966 8.966 0 005.982-2.275M12 21a8.966 8.966 0 01-5.982-2.275M15.75 3.186a24.284 24.284 0 012.068.858M6.318 3.186a24.284 24.284 0 00-2.068.858M12 3c-2.485 0-4.847.49-7.043 1.386"/></svg>
                Jenis Pemeliharaan
            </a>
            <a href="{{ route('admin.assign.index') }}" class="sidebar-link {{ request()->routeIs('admin.assign.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Assign Pengaju
            </a>
            @endrole

            @role('pengaju_kendaraan')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengajuan</p>
            </div>
            <a href="{{ route('pengaju.pengajuan.index') }}" class="sidebar-link {{ request()->routeIs('pengaju.pengajuan.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Pengajuan Servis
            </a>
            @endrole

            @role('kepala_bagian')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Approval</p>
            </div>
            <a href="{{ route('kabag.approval.index') }}" class="sidebar-link {{ request()->routeIs('kabag.approval.*') && !request()->routeIs('kabag.approval.history') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Approval Kabag
            </a>
            <a href="{{ route('kabag.approval.history') }}" class="sidebar-link {{ request()->routeIs('kabag.approval.history') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Kabag
            </a>
            @endrole

            @role('kepala_biro')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Disposisi</p>
            </div>
            <a href="{{ route('kabiro.disposisi.index') }}" class="sidebar-link {{ request()->routeIs('kabiro.disposisi.*') && !request()->routeIs('kabiro.disposisi.history') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Disposisi Biro
            </a>
            <a href="{{ route('kabiro.disposisi.history') }}" class="sidebar-link {{ request()->routeIs('kabiro.disposisi.history') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Biro
            </a>
            @endrole

            @role('pptk')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">PPTK</p>
            </div>
            @php
                $pendingSpkCount = \App\Models\PengajuanServis::where('status', \App\Enums\PengajuanStatusEnum::DISPOSED_BIRO)
                    ->whereDoesntHave('spk')
                    ->count();
            @endphp
            <a href="{{ route('pptk.spk.index') }}" class="sidebar-link {{ request()->routeIs('pptk.spk.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                SPK
                @if($pendingSpkCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $pendingSpkCount }}</span>
                @endif
            </a>
            <a href="{{ route('pptk.riwayat.index') }}" class="sidebar-link {{ request()->routeIs('pptk.riwayat.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Riwayat Pemeliharaan
            </a>
            @endrole

            @role('admin')
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelaporan</p>
            </div>
            <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'sidebar-link-active' : 'sidebar-link-default' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Laporan
            </a>
            @endrole
        </nav>

        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-2xl gradient-primary flex items-center justify-center text-white text-sm font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->role?->label() }}</p>
                </div>
            </div>
        </div>
    </div>
</aside>
