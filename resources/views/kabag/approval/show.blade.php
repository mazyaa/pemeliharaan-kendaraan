@extends('layouts.app')
@section('title', 'Review Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in">
    <div class="flex items-center gap-3">
        <a href="{{ route('kabag.approval.index') }}" class="btn-icon" title="Kembali">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Review Pengajuan</h1>
            <p class="text-gray-500 text-sm">{{ $pengajuan->nomor_pengajuan }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pengajuan</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-gray-500">Nomor</span><span class="font-medium text-gray-800">{{ $pengajuan->nomor_pengajuan }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-medium text-gray-800">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="badge-{{ $pengajuan->status_color }}">{{ $pengajuan->label_status }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Pengaju</span><span class="font-medium text-gray-800">{{ $pengajuan->pengaju->name }}</span></div>
            </div>
        </div>
        <div class="glass-card">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Data Kendaraan</h3>
            <div class="space-y-3">
                <div class="flex justify-between"><span class="text-gray-500">Kode</span><span class="font-medium text-gray-800">{{ $pengajuan->kendaraan->kode_kendaraan }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Plat</span><span class="font-medium text-gray-800">{{ $pengajuan->kendaraan->plat_nomor }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Merk/Tipe</span><span class="font-medium text-gray-800">{{ $pengajuan->kendaraan->merk }} {{ $pengajuan->kendaraan->tipe }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span><span class="badge-{{ $pengajuan->kendaraan->status_color }}">{{ $pengajuan->kendaraan->label_status }}</span></div>
            </div>
        </div>
    </div>

    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Pengajuan Servis</h3>
        <div class="space-y-3">
            @forelse($pengajuan->details as $detail)
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

    @if($pengajuan->lampiran->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Lampiran</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @foreach($pengajuan->lampiran as $lampiran)
            <a href="{{ Storage::disk('public')->url($lampiran->file_path) }}" target="_blank" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 border border-gray-200 text-center transition-all group">
                <svg class="w-8 h-8 mx-auto text-gray-400 group-hover:text-gray-600 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <p class="text-xs text-gray-500 group-hover:text-gray-700 truncate transition-colors">{{ $lampiran->file_name }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @if($pengajuan->status->value === 'submitted')
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Keputusan</h3>
        <form id="approveForm" method="POST" class="space-y-4">
            @csrf
            <div class="form-group">
                <label class="form-label">Catatan (WAJIB DIISI!)</label>
                <textarea name="notes" class="glass-input" rows="3" placeholder="Tambahkan catatan..."></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="submitAction('reject')" class="btn-danger">Tolak</button>
                <button type="button" onclick="submitAction('approve')" class="btn-success">Setujui</button>
            </div>
        </form>
    </div>
    @else
    <div class="glass-card">
        <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50">
            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-sm text-gray-600">Pengajuan ini sudah diproses dan tidak dapat diubah.</p>
        </div>
    </div>
    @endif

    @if($pengajuan->approvalHistories->count())
    <div class="glass-card">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Approval</h3>
        <div class="space-y-4">
            @foreach($pengajuan->approvalHistories as $history)
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                <div class="w-9 h-9 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold shrink-0">{{ substr($history->approver->name, 0, 1) }}</div>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-800">{{ $history->approver->name }}</p>
                    <p class="text-xs text-gray-500">{{ $history->status }} - {{ $history->approved_at?->format('d/m/Y H:i') }}</p>
                    @if($history->notes)<p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>@endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
function submitAction(action) {
    const form = document.getElementById('approveForm');
    if (action === 'reject') {
        form.action = '{{ route("kabag.approval.reject", $pengajuan) }}';
    } else {
        form.action = '{{ route("kabag.approval.approve", $pengajuan) }}';
    }
    form.submit();
}
</script>
@endpush
@endsection
