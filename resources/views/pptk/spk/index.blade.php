@extends('layouts.app')
@section('title', 'Daftar SPK')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Surat Perintah Kerja</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar SPK yang telah diterbitkan</p>
        </div>
    </div>

    @if($pendingPengajuan->count())
    <div class="glass-card p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Siap Terbitkan SPK</h3>
        <div class="space-y-3">
            @foreach($pendingPengajuan as $p)
            <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 border border-yellow-500/30 hover:bg-gray-100 transition-all duration-200">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800">{{ $p->nomor_pengajuan }}</p>
                    <p class="text-sm text-gray-500">{{ $p->kendaraan->merk }} {{ $p->kendaraan->tipe }} ({{ $p->kendaraan->plat_nomor }})</p>
                    <p class="text-xs text-gray-500">Pengaju: {{ $p->pengaju->name }}</p>
                </div>
                <form method="POST" action="{{ route('pptk.spk.generate', $p->id) }}" class="shrink-0 ml-4">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Terbitkan SPK
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor SPK..." class="glass-input flex-1 min-w-[200px]">
            <button type="submit" class="btn-primary">Cari</button>
        </form>
    </div>

    <div class="table-container hidden md:block">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Nomor SPK</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Pengajuan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Tanggal</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spk as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $spk->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item->nomor_spk }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->pengajuanServis->nomor_pengajuan }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->pengajuanServis->kendaraan->merk }} {{ $item->pengajuanServis->kendaraan->tipe }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tanggal_spk->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('pptk.spk.show', $item) }}" class="btn-icon" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('pptk.spk.preview', $item) }}" target="_blank" class="btn-icon" title="Preview">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </a>
                            <a href="{{ route('pptk.spk.download', $item) }}" class="btn-icon" title="Download">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada SPK</h3>
                            <p class="empty-text">Belum ada surat perintah kerja yang diterbitkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200">{{ $spk->withQueryString()->links() }}</div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($spk as $index => $item)
        <div class="glass-card p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="font-semibold text-gray-800">{{ $spk->firstItem() + $index }}</span>
                <span class="text-xs text-gray-500">{{ $item->tanggal_spk->format('d/m/Y') }}</span>
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor SPK:</span>
                    <span class="font-medium">{{ $item->nomor_spk }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pengajuan:</span>
                    <span class="font-medium">{{ $item->pengajuanServis->nomor_pengajuan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kendaraan:</span>
                    <span class="font-medium">{{ $item->pengajuanServis->kendaraan->merk }} {{ $item->pengajuanServis->kendaraan->tipe }}</span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('pptk.spk.show', $item) }}" class="btn-icon" title="Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <a href="{{ route('pptk.spk.preview', $item) }}" target="_blank" class="btn-icon" title="Preview">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </a>
                <a href="{{ route('pptk.spk.download', $item) }}" class="btn-icon" title="Download">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada SPK
        </div>
        @endforelse
        <div class="p-4 border-t border-gray-200">{{ $spk->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
