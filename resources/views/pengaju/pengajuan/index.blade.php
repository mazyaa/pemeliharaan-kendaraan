@extends('layouts.app')
@section('title', 'Pengajuan Servis')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="{ createModal: false, editModal: false, editId: null, editData: {}, selectedJenis: [], selectedJenisEdit: [] }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Servis</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola pengajuan servis kendaraan dinas</p>
        </div>
        @if($kendaraan->count() > 0)
        <button @click="createModal = true" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Pengajuan Baru
        </button>
        @endif
    </div>

    @if($kendaraan->isEmpty())
    <div class="glass-card p-8 text-center">
        <div class="empty-icon">
            <svg class="w-16 h-16 mx-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
        </div>
        <h3 class="empty-title">Belum Ada Kendaraan</h3>
        <p class="empty-text">Anda belum memiliki kendaraan yang di-assign. Silakan hubungi admin untuk assign kendaraan.</p>
    </div>
    @endif

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                 <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor..." class="glass-input px-4 py-2.5 text-sm">
            </div>
            <div>
                <select name="status" class="glass-select px-4 py-2.5 text-sm">
                    <option class="text-black" value="">Semua Status</option>
                    <option class="text-black" value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option class="text-black" value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Diajukan</option>
                    <option class="text-black" value="approved_kabag" {{ request('status') == 'approved_kabag' ? 'selected' : '' }}>Disetujui Kabag</option>
                    <option class="text-black" value="spk_generated" {{ request('status') == 'spk_generated' ? 'selected' : '' }}>SPK Diterbitkan</option>
                    <option class="text-black" value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-container hidden md:block">
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
                    <td class="text-gray-500">{{ $pengajuan->firstItem() + $index }}</td>
                    <td class="font-medium text-gray-800">{{ $item->nomor_pengajuan }}</td>
                    <td>{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }} ({{ $item->kendaraan->plat_nomor }})</td>
                    <td>{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                    <td class="text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                    <td class="text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('pengaju.pengajuan.show', $item) }}" class="btn-icon" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            @if($item->status->value === 'draft')
                            <button @click="editId = {{ $item->id }}; editData = { kendaraan_id: {{ $item->kendaraan_id }}, tanggal_pengajuan: '{{ $item->tanggal_pengajuan->format('Y-m-d') }}' }; editModal = true" class="btn-icon" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmAction('{{ route('pengaju.pengajuan.submit', $item) }}', 'Kirim Pengajuan', 'Pengajuan akan dikirim ke Kepala Bagian untuk disetujui.', 'Ya, Kirim!')" class="btn-icon" title="Kirim">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('pengaju.pengajuan.destroy', $item) }}')" class="btn-icon" title="Hapus">
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
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $pengajuan->withQueryString()->links() }}
        </div>
        @endif
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
                    <span class="font-medium">{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }} ({{ $item->kendaraan->plat_nomor }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal:</span>
                    <span class="font-medium">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('pengaju.pengajuan.show', $item) }}" class="btn-icon" title="Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                @if($item->status->value === 'draft')
                <button @click="editId = {{ $item->id }}; editData = { kendaraan_id: {{ $item->kendaraan_id }}, tanggal_pengajuan: '{{ $item->tanggal_pengajuan->format('Y-m-d') }}' }; editModal = true" class="btn-icon" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </button>
                <button type="button" onclick="confirmAction('{{ route('pengaju.pengajuan.submit', $item) }}', 'Kirim Pengajuan', 'Pengajuan akan dikirim ke Kepala Bagian untuk disetujui.', 'Ya, Kirim!')" class="btn-icon" title="Kirim">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
                <button type="button" onclick="confirmDelete('{{ route('pengaju.pengajuan.destroy', $item) }}')" class="btn-icon" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada pengajuan
        </div>
        @endforelse
        @if($pengajuan->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $pengajuan->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-transition @click="createModal = false">
        <form method="POST" action="{{ route('pengaju.pengajuan.store') }}" enctype="multipart/form-data" class="modal-content" @click.stop>
            @csrf
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Buat Pengajuan Baru</h3>
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
                    <label class="form-label">Jenis Pemeliharaan *</label>
                    <div class="space-y-4">
                        @php
                            $grouped = $jenisPemeliharaan->groupBy('kategori');
                        @endphp
                        <div class="space-y-3">
                            @foreach($grouped as $kategori => $items)
                            <div class="glass-card p-4">
                                <h4 class="text-sm font-semibold text-emerald-600 mb-3 uppercase tracking-wider">{{ $kategori }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
                                    @foreach($items as $jp)
                                     <div @click="
                                         if(selectedJenis.includes({{ $jp->id }})) {
                                             selectedJenis = selectedJenis.filter(id => id !== {{ $jp->id }})
                                         } else {
                                             selectedJenis.push({{ $jp->id }})
                                         }
                                     "
                                     :class="{
                                         'border-emerald-500 bg-emerald-50 shadow-emerald-500/20 ring-2 ring-emerald-500 transform scale-105': selectedJenis.includes({{ $jp->id }}),
                                         'bg-gray-50 border-gray-200 hover:bg-gray-100 hover:scale-105 hover:shadow-lg transition-all duration-300': !selectedJenis.includes({{ $jp->id }})
                                     }"
                                     class="relative p-4 rounded-2xl border backdrop-blur-xl shadow-lg cursor-pointer transition-all duration-300 select-none flex flex-col items-center justify-between">
                                        <div class="flex items-start gap-2">
                                            <template x-if="selectedJenis.includes({{ $jp->id }})">
                                                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            </template>
                                            <template x-if="!selectedJenis.includes({{ $jp->id }})">
                                                <div class="w-5 h-5 shrink-0 mt-0.5 rounded border-2 border-gray-300"></div>
                                            </template>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $jp->nama }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Interval {{ $jp->interval_hari }} hari</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                     <template x-for="id in selectedJenis">
                         <input type="hidden" name="jenis_pemeliharaan_ids[]" :value="id">
                     </template>
                    <div x-show="selectedJenis.length === 0" class="text-xs text-red-600 mt-1">Pilih minimal satu jenis pemeliharaan</div>
                    <p class="text-xs text-gray-500 mt-1">Pilih jenis pemeliharaan yang diperlukan. Centang lebih dari satu jika perlu.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Lampiran (wajib, max 5 file)</label>
                    <input type="file" name="lampiran[]" class="glass-input" multiple required accept=".jpg,.jpeg,.png,.pdf">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF. Maks: 5MB per file</p>
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
        <form method="POST" x-bind:action="'{{ route('pengaju.pengajuan.update', '_ID_') }}'.replace('_ID_', editId)" enctype="multipart/form-data" class="modal-content" @click.stop>
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Edit Pengajuan</h3>
                <button type="button" @click="editModal = false" class="btn-icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="modal-body space-y-4">
                <div class="form-group">
                    <label class="form-label">Kendaraan *</label>
                    <select name="kendaraan_id" class="glass-select" required x-model.number="editData.kendaraan_id">
                        <option class="text-black" value="">Pilih Kendaraan</option>
                        @foreach($kendaraan as $k)
                        <option class="text-black" value="{{ $k->id }}">{{ $k->kode_kendaraan }} - {{ $k->merk }} {{ $k->tipe }} ({{ $k->plat_nomor }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Pengajuan *</label>
                    <input type="date" name="tanggal_pengajuan" class="glass-input" required x-model="editData.tanggal_pengajuan">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Pemeliharaan *</label>
                    <div class="space-y-4">
                        @php
                            $grouped = $jenisPemeliharaan->groupBy('kategori');
                        @endphp
                        <div class="space-y-3">
                            @foreach($grouped as $kategori => $items)
                            <div class="glass-card p-4">
                                <h4 class="text-sm font-semibold text-emerald-600 mb-3 uppercase tracking-wider">{{ $kategori }}</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3">
                                    @foreach($items as $jp)
                                     <div @click="
                                         if(selectedJenisEdit.includes({{ $jp->id }})) {
                                             selectedJenisEdit = selectedJenisEdit.filter(id => id !== {{ $jp->id }})
                                         } else {
                                             selectedJenisEdit.push({{ $jp->id }})
                                         }
                                     "
                                     :class="{
                                         'border-emerald-500 bg-emerald-50 shadow-emerald-500/20 ring-2 ring-emerald-500 transform scale-105': selectedJenisEdit.includes({{ $jp->id }}),
                                         'bg-gray-50 border-gray-200 hover:bg-gray-100 hover:scale-105 hover:shadow-lg transition-all duration-300': !selectedJenisEdit.includes({{ $jp->id }})
                                     }"
                                     class="relative p-4 rounded-2xl border backdrop-blur-xl shadow-lg cursor-pointer transition-all duration-300 select-none flex flex-col items-center justify-between">
                                        <div class="flex items-start gap-2">
                                            <template x-if="selectedJenisEdit.includes({{ $jp->id }})">
                                                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            </template>
                                            <template x-if="!selectedJenisEdit.includes({{ $jp->id }})">
                                                <div class="w-5 h-5 shrink-0 mt-0.5 rounded border-2 border-gray-300"></div>
                                            </template>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800">{{ $jp->nama }}</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Interval {{ $jp->interval_hari }} hari</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                     <template x-for="id in selectedJenisEdit">
                         <input type="hidden" name="jenis_pemeliharaan_ids[]" :value="id">
                     </template>
                    <div x-show="selectedJenisEdit.length === 0" class="text-xs text-red-600 mt-1">Pilih minimal satu jenis pemeliharaan</div>
                    <p class="text-xs text-gray-500 mt-1">Pilih jenis pemeliharaan yang diperlukan. Centang lebih dari satu jika perlu.</p>
                </div>
                <div class="form-group">
                    <label class="form-label">Lampiran (opsional, max 5 file)</label>
                    <input type="file" name="lampiran[]" class="glass-input" multiple accept=".jpg,.jpeg,.png,.pdf">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF. Maks: 5MB per file</p>
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
