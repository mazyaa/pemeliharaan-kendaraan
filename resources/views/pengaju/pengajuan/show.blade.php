@extends('layouts.app')
@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center gap-3">
        <a href="{{ route('pengaju.pengajuan.index') }}" class="btn-icon">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7-7-7 7 7 7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $pengajuan->nomor_pengajuan }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Nomor</span>
                    <span class="font-medium text-gray-800 text-sm">{{ $pengajuan->nomor_pengajuan }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Tanggal</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Status</span>
                    <span class="badge-{{ $pengajuan->status_color }}">{{ $pengajuan->label_status }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-500 text-sm">Pengaju</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->pengaju->name }}</span>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Kendaraan</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Kode</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->kendaraan->kode_kendaraan }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Plat Nomor</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->kendaraan->plat_nomor }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-500 text-sm">Merk / Tipe</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->kendaraan->merk }} {{ $pengajuan->kendaraan->tipe }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-500 text-sm">Tahun</span>
                    <span class="font-medium text-gray-700 text-sm">{{ $pengajuan->kendaraan->tahun }}</span>
                </div>
            </div>
        </div>

        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Jenis Pemeliharaan</h3>
            <div class="space-y-3">
                @forelse($pengajuan->details as $detail)
                <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                    <div>
                        <span class="font-medium text-gray-800 text-sm">{{ $detail->jenisPemeliharaan->nama }}</span>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $detail->jenisPemeliharaan->kategori }} • {{ $detail->jenisPemeliharaan->interval_hari }} hari</p>
                    </div>
                    <span class="badge-{{ $detail->jenisPemeliharaan->is_active ? 'success' : 'danger' }} text-[10px] px-2 py-0.5">
                        {{ $detail->jenisPemeliharaan->kategori }}
                    </span>
                </div>
                @empty
                <p class="text-gray-500 text-sm">Tidak ada jenis pemeliharaan.</p>
                @endforelse
            </div>
        </div>
    </div>

    @if($pengajuan->lampiran->count())
    <div class="glass-card">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-800">Lampiran</h3>
            <span class="text-xs text-gray-500 bg-gray-50 px-2.5 py-1 rounded-full">{{ $pengajuan->lampiran->count() }} file</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($pengajuan->lampiran as $lampiran)
            <a href="{{ Storage::disk('public')->url($lampiran->file_path) }}" target="_blank" class="group flex flex-col items-center p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-emerald-500/30 transition-all duration-200">
                <svg class="w-10 h-10 text-gray-500 group-hover:text-emerald-400 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-500 group-hover:text-gray-200 truncate max-w-full text-center transition-colors">{{ $lampiran->file_name }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($pengajuan->approvalHistories->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Approval</h3>
        <div class="space-y-3">
            @foreach($pengajuan->approvalHistories as $history)
            <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-200 transition-all duration-200 hover:bg-gray-100">
                <div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center text-white text-sm font-bold shrink-0 shadow-lg shadow-emerald-500/20">
                    {{ substr($history->approver->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-semibold text-gray-800 text-sm">{{ $history->approver->name }}</p>
                        @php
                            $approvalBadge = match($history->status) {
                                'approved' => 'badge-success',
                                'rejected' => 'badge-danger',
                                default => 'badge-info'
                            };
                        @endphp
                        <span class="{{ $approvalBadge }} text-[10px] px-2 py-0.5">{{ $history->status }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $history->approved_at?->format('d/m/Y H:i') }}
                    </p>
                    @if($history->notes)
                    <p class="text-sm text-gray-700 mt-2.5 bg-gray-50 rounded-xl p-3 border border-gray-200">{{ $history->notes }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($pengajuan->status->value === 'draft')
    <div class="flex items-center justify-end gap-3 pt-2">
        <a href="{{ route('pengaju.pengajuan.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </a>
        <button type="button" onclick="confirmAction('{{ route('pengaju.pengajuan.submit', $pengajuan) }}', 'Kirim Pengajuan', 'Pengajuan akan dikirim ke Kepala Bagian untuk disetujui.', 'Ya, Kirim!')" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            Submit Pengajuan
        </button>
    </div>
    @endif
</div>
@endsection