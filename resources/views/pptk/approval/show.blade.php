@extends('layouts.app')
@section('title', 'Review PPTK')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center gap-3">
        <a href="{{ route('pptk.approval.index') }}" class="btn-icon" title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white">Review PPTK</h1>
            <p class="text-gray-400 text-sm">{{ $pengajuan->nomor_pengajuan }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card">
            <h3 class="text-lg font-bold text-white mb-4">Informasi Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-gray-400">Nomor</span><span class="font-medium text-gray-300">{{ $pengajuan->nomor_pengajuan }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Tanggal</span><span class="font-medium text-gray-300">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Status</span><span class="badge-{{ $pengajuan->status_color }}">{{ $pengajuan->label_status }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Pengaju</span><span class="font-medium text-gray-300">{{ $pengajuan->pengaju->name }}</span></div>
            </div>
        </div>
        <div class="glass-card">
            <h3 class="text-lg font-bold text-white mb-4">Data Kendaraan</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-gray-400">Kode</span><span class="font-medium text-gray-300">{{ $pengajuan->kendaraan->kode_kendaraan }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Plat</span><span class="font-medium text-gray-300">{{ $pengajuan->kendaraan->plat_nomor }}</span></div>
                <div class="flex justify-between"><span class="text-gray-400">Merk/Tipe</span><span class="font-medium text-gray-300">{{ $pengajuan->kendaraan->merk }} {{ $pengajuan->kendaraan->tipe }}</span></div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h3 class="text-lg font-bold text-white mb-4">Keluhan</h3>
        <p class="text-gray-300 whitespace-pre-line">{{ $pengajuan->keluhan }}</p>
    </div>

    @if($pengajuan->lampiran->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-white mb-4">Lampiran</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($pengajuan->lampiran as $lampiran)
            <a href="{{ Storage::disk('public')->url($lampiran->file_path) }}" target="_blank" class="block p-3 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-center transition-all group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-white mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-400 group-hover:text-gray-200 truncate transition-colors">{{ $lampiran->file_name }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($pengajuan->approvalHistories->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-white mb-4">Riwayat Approval</h3>
        <div class="space-y-4">
            @foreach($pengajuan->approvalHistories as $history)
            <div class="flex items-start gap-3 p-3 rounded-xl bg-white/5">
                <div class="w-9 h-9 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold shrink-0">{{ substr($history->approver->name, 0, 1) }}</div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-white">{{ $history->approver->name }}</p>
                    <p class="text-xs text-gray-400">{{ $history->status }} - {{ $history->approved_at?->format('d/m/Y H:i') }}</p>
                    @if($history->notes)<p class="text-sm text-gray-300 mt-1">{{ $history->notes }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($pengajuan->status->value === 'disposed_biro')
    <div class="glass-card">
        <h3 class="text-lg font-bold text-white mb-4">Keputusan PPTK</h3>
        <form id="pptkForm" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label class="form-label">Catatan (opsional)</label>
                <textarea name="notes" class="glass-input" rows="3" placeholder="Tambahkan catatan..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="submitAction('reject')" class="btn-danger">Tolak</button>
                <button type="button" onclick="submitAction('approve')" class="btn-success">Setujui & Generate SPK</button>
            </div>
        </form>
    </div>
    @else
    <div class="glass-card">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-white/5">
            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-gray-300">Pengajuan ini sudah diproses dan tidak dapat diubah.</p>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function submitAction(action) {
    const form = document.getElementById('pptkForm');
    if (action === 'reject') {
        form.action = '{{ route("pptk.approval.reject", $pengajuan) }}';
    } else {
        form.action = '{{ route("pptk.approval.approve", $pengajuan) }}';
    }
    form.submit();
}
</script>
@endpush
@endsection
