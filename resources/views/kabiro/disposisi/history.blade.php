@extends('layouts.app')
@section('title', 'Riwayat Disposisi Kepala Biro')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Disposisi</h1>
        <p class="text-gray-500 text-sm mt-1">Pengajuan yang telah didisposisi atau ditolak</p>
    </div>

    <nav class="tab-nav">
        <a href="{{ route('kabiro.disposisi.index') }}"
            class="{{ request()->routeIs('kabiro.disposisi.index') ? 'tab-item-active' : 'tab-item-default' }}">
            Menunggu
        </a>
        <a href="{{ route('kabiro.disposisi.history') }}"
            class="{{ request()->routeIs('kabiro.disposisi.history') ? 'tab-item-active' : 'tab-item-default' }}">
            Riwayat
        </a>
    </nav>

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pengajuan..." class="glass-input w-full">
            </div>
            <div class="w-auto">
                <label class="form-label">Status</label>
                <select name="status" class="glass-select">
                    <option class="text-black" value="">Semua Status</option>
                    <option class="text-black" value="disposed_biro" {{ request('status') == 'disposed_biro' ? 'selected' : '' }}>Didisposisi Biro</option>
                    <option class="text-black" value="rejected_biro" {{ request('status') == 'rejected_biro' ? 'selected' : '' }}>Ditolak Biro</option>
                    <option class="text-black" value="spk_generated" {{ request('status') == 'spk_generated' ? 'selected' : '' }}>SPK Diterbitkan</option>
                    <option class="text-black" value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-container hidden md:block">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Nomor</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Pengaju</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Tanggal</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $pengajuan->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item->nomor_pengajuan }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->pengaju->name }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        <span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ route('kabiro.disposisi.show', $item) }}" class="btn-icon" title="Detail">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p class="empty-title">Belum Ada Riwayat</p>
                            <p class="empty-text">Tidak ada riwayat disposisi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200">{{ $pengajuan->withQueryString()->links() }}</div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($pengajuan as $index => $item)
        <div class="glass-card p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="font-semibold text-gray-800">{{ $pengajuan->firstItem() + $index }}</span>
                <span class="badge-{{ $item->status_color }} text-xs">{{ $item->label_status }}</span>
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor:</span>
                    <span class="font-medium">{{ $item->nomor_pengajuan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kendaraan:</span>
                    <span class="font-medium">{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pengaju:</span>
                    <span class="font-medium">{{ $item->pengaju->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-medium">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('kabiro.disposisi.show', $item) }}" class="btn-icon" title="Detail">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada riwayat
        </div>
        @endforelse
        <div class="p-4 border-t border-gray-200">{{ $pengajuan->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
