@extends('layouts.app')
@section('title', 'Daftar SPK')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Surat Perintah Kerja</h1>
            <p class="text-gray-400 text-sm mt-1">Daftar SPK yang telah diterbitkan</p>
        </div>
    </div>

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor SPK..." class="glass-input flex-1 min-w-[200px]">
            <button type="submit" class="btn-primary">Cari</button>
        </form>
    </div>

    <div class="table-container">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Nomor SPK</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Pengajuan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Tanggal</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($spk as $index => $item)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-3 px-4 text-gray-300">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-medium text-white">{{ $item->nomor_spk }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->pengajuanServis->nomor_pengajuan }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->pengajuanServis->kendaraan->merk }} {{ $item->pengajuanServis->kendaraan->tipe }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->tanggal_spk->format('d/m/Y') }}</td>
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
        <div class="p-4 border-t border-white/5">{{ $spk->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
