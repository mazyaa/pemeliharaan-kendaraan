@extends('layouts.app')
@section('title', 'Detail SPK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center gap-3">
        <a href="{{ route('pptk.spk.index') }}" class="btn-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">Detail SPK</h1>
            <p class="text-gray-500 text-sm">{{ $spk->nomor_spk }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('pptk.spk.preview', $spk) }}" target="_blank" class="btn-icon" title="Preview">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </a>
            <a href="{{ route('pptk.spk.download', $spk) }}" class="btn-icon" title="Download">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi SPK</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Nomor SPK</span>
                    <span class="font-medium text-gray-800">{{ $spk->nomor_spk }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="font-medium text-gray-800">{{ $spk->tanggal_spk->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Dibuat Oleh</span>
                    <span class="font-medium text-gray-800">{{ $spk->creator->name }}</span>
                </div>
                @if($spk->keterangan)
                <div class="pt-2 border-t border-gray-200">
                    <span class="text-gray-500 block mb-1">Keterangan</span>
                    <p class="text-gray-700">{{ $spk->keterangan }}</p>
                </div>
                @endif
            </div>
        </div>
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Nomor</span>
                    <span class="font-medium text-gray-800">{{ $spk->pengajuanServis->nomor_pengajuan }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Kendaraan</span>
                    <span class="font-medium text-gray-800">{{ $spk->pengajuanServis->kendaraan->merk }} {{ $spk->pengajuanServis->kendaraan->tipe }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Plat</span>
                    <span class="font-medium text-gray-800">{{ $spk->pengajuanServis->kendaraan->plat_nomor }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Pengaju</span>
                    <span class="font-medium text-gray-800">{{ $spk->pengajuanServis->pengaju->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengajuan Servis</h3>
        <div class="space-y-3">
            @forelse($spk->pengajuanServis->details as $detail)
            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                <div>
                    <span class="font-medium text-gray-800 text-sm">{{ $detail->jenisPemeliharaan->nama }}</span>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $detail->jenisPemeliharaan->kategori }} &bull; {{ $detail->jenisPemeliharaan->interval_hari }} hari</p>
                </div>
                <span class="badge-{{ $detail->jenisPemeliharaan->is_active ? 'success' : 'secondary' }} text-[10px] px-2 py-0.5">{{ $detail->jenisPemeliharaan->kategori }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">Tidak ada jenis pemeliharaan.</p>
            @endforelse
        </div>
    </div>

    @if($spk->riwayatPemeliharaan)
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pemeliharaan</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-500">Bengkel</span>
                <p class="font-medium text-gray-800">{{ $spk->riwayatPemeliharaan->nama_bengkel }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-500">Status</span>
                <p><span class="badge-{{ $spk->riwayatPemeliharaan->status_color }}">{{ $spk->riwayatPemeliharaan->label_status }}</span></p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
