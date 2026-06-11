@extends('layouts.app')
@section('title', 'Detail Riwayat Pemeliharaan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center gap-3">
        <a href="{{ route('pptk.riwayat.index') }}" class="btn-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">Detail Riwayat Pemeliharaan</h1>
        </div>
        <a href="{{ route('pptk.riwayat.index') }}" class="btn-primary">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Pemeliharaan</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">SPK</span>
                    <span class="font-medium text-gray-800">{{ $riwayat->spk->nomor_spk }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Kendaraan</span>
                    <span class="font-medium text-gray-800">{{ $riwayat->spk->pengajuanServis->kendaraan->merk }} {{ $riwayat->spk->pengajuanServis->kendaraan->tipe }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Bengkel</span>
                    <span class="font-medium text-gray-800">{{ $riwayat->nama_bengkel }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Status</span>
                    <span class="badge-{{ $riwayat->status_color }}">{{ $riwayat->label_status }}</span>
                </div>
            </div>
        </div>
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Tanggal</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Tanggal Masuk</span>
                    <span class="font-medium text-gray-800">{{ $riwayat->tanggal_masuk->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Tanggal Selesai</span>
                    <span class="font-medium text-gray-800">{{ $riwayat->tanggal_selesai?->format('d/m/Y') ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($riwayat->hasil_pemeliharaan)
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Hasil Pemeliharaan</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ $riwayat->hasil_pemeliharaan }}</p>
    </div>
    @endif

    @if($riwayat->catatan)
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Catatan</h3>
        <p class="text-gray-700 whitespace-pre-line">{{ $riwayat->catatan }}</p>
    </div>
    @endif

    @if($riwayat->lampiran->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Lampiran</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($riwayat->lampiran as $lampiran)
            <a href="{{ asset('storage/' . ltrim($lampiran->file_path, '/')) }}" target="_blank" class="block p-3 rounded-xl bg-gray-50 border border-gray-200 hover:bg-gray-100 transition-colors text-center group">
                <svg class="w-8 h-8 mx-auto text-gray-500 group-hover:text-emerald-600 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-500 group-hover:text-gray-800 truncate transition-colors">{{ $lampiran->file_name }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
