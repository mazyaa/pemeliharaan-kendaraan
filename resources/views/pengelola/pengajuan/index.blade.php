@extends('layouts.app')
@section('title', 'Pengajuan Servis')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="{ createModal: false, editModal: false, editId: null, editData: {} }">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Pengajuan Servis</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola pengajuan servis kendaraan dinas</p>
        </div>
        <button @click="createModal = true" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Pengajuan Baru
        </button>
    </div>

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor, keluhan..." class="glass-input px-4 py-2.5 text-sm">
            </div>
            <div>
                <select name="status" class="glass-select px-4 py-2.5 text-sm">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                    <option value="approved_kabag" {{ request('status') == 'approved_kabag' ? 'selected' : '' }}>Disetujui Kabag</option>
                    <option value="approved_pptk" {{ request('status') == 'approved_pptk' ? 'selected' : '' }}>Disetujui PPTK</option>
                    <option value="spk_generated" {{ request('status') == 'spk_generated' ? 'selected' : '' }}>SPK Diterbitkan</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-container">
        <table class="w-full">
            <thead class="table-header">
                <tr>
                    <th>No</th>
                    <th>Nomor</th>
                    <th>Kendaraan</th>
                    <th>Tanggal</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuan as $index => $item)
                <tr>
                    <td class="text-gray-400">{{ $pengajuan->firstItem() + $index }}</td>
                    <td class="font-medium text-white">{{ $item->nomor_pengajuan }}</td>
                    <td>{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }} ({{ $item->kendaraan->plat_nomor }})</td>
                    <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td class="text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('pengelola.pengajuan.show', $item) }}" class="btn-icon" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($item->status->value === 'draft')
                            <button @click="editId = {{ $item->id }}; editData = { kendaraan_id: {{ $item->kendaraan_id }}, tanggal_pengajuan: '{{ $item->tanggal_pengajuan->format('Y-m-d') }}', keluhan: '{{ $item->keluhan }}' }; editModal = true" class="btn-icon" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmAction('{{ route('pengelola.pengajuan.submit', $item) }}', 'Kirim Pengajuan', 'Pengajuan akan dikirim ke Kepala Bagian untuk disetujui.', 'Ya, Kirim!')" class="btn-icon" title="Kirim">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('pengelola.pengajuan.destroy', $item) }}')" class="btn-icon" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="empty-title">Belum Ada Pengajuan</div>
                            <div class="empty-text">Belum ada data pengajuan servis yang tersedia.</div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if($pengajuan->hasPages())
        <div class="px-4 py-3 border-t border-white/10">
            {{ $pengajuan->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-transition @click="createModal = false">
        <form method="POST" action="{{ route('pengelola.pengajuan.store') }}" enctype="multipart/form-data" class="modal-content" @click.stop>
            @csrf
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Buat Pengajuan Baru</h3>
                <button type="button" @click="createModal = false" class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="form-group">
                    <label class="form-label">Kendaraan *</label>
                    <select name="kendaraan_id" class="glass-select" required>
                        <option value="" class="text-black">Pilih Kendaraan</option>
                        @foreach($kendaraan as $k)
                        <option class="text-black" value="{{ $k->id }}">{{ $k->kode_kendaraan }} - {{ $k->merk }} {{ $k->tipe }} ({{ $k->plat_nomor }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pengajuan *</label>
                    <input type="date" name="tanggal_pengajuan" class="glass-input" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Keluhan *</label>
                    <textarea name="keluhan" class="glass-input" rows="4" required placeholder="Jelaskan keluhan kendaraan..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Lampiran (opsional, max 5 file)</label>
                    <input type="file" name="lampiran[]" class="glass-input" multiple accept=".jpg,.jpeg,.png,.pdf">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF. Maks: 5MB per file</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="createModal = false" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary">Simpan Draft</button>
            </div>
        </form>
    </div>

    {{-- Edit Modal --}}
    <div x-show="editModal" class="modal-backdrop" x-transition @click="editModal = false">
        <form method="POST" x-bind:action="'{{ route('pengelola.pengajuan.update', '_ID_') }}'.replace('_ID_', editId)" enctype="multipart/form-data" class="modal-content" @click.stop>
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Edit Pengajuan</h3>
                <button type="button" @click="editModal = false" class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="form-group">
                    <label class="form-label">Kendaraan *</label>
                    <select name="kendaraan_id" class="glass-select" required x-model.number="editData.kendaraan_id">
                        <option value="">Pilih Kendaraan</option>
                        @foreach($kendaraan as $k)
                        <option value="{{ $k->id }}">{{ $k->kode_kendaraan }} - {{ $k->merk }} {{ $k->tipe }} ({{ $k->plat_nomor }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pengajuan *</label>
                    <input type="date" name="tanggal_pengajuan" class="glass-input" required x-model="editData.tanggal_pengajuan">
                </div>
                <div class="form-group">
                    <label class="form-label">Keluhan *</label>
                    <textarea name="keluhan" class="glass-input" rows="4" required placeholder="Jelaskan keluhan kendaraan..." x-model="editData.keluhan"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Lampiran (opsional)</label>
                    <input type="file" name="lampiran[]" class="glass-input" multiple accept=".jpg,.jpeg,.png,.pdf">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, PDF. Maks: 5MB per file</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="editModal = false" class="btn-secondary">Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
