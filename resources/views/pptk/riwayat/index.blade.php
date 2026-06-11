@extends('layouts.app')
@section('title', 'Riwayat Pemeliharaan')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="{ createModal: false, editModal: false, editId: null, editData: {} }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pemeliharaan</h1>
            <p class="text-gray-500 text-sm mt-1">Data pemeliharaan kendaraan dinas</p>
        </div>
        <button @click="createModal = true" class="btn-primary">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Riwayat Baru
        </button>
    </div>

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bengkel, hasil..." class="glass-input flex-1 min-w-[200px]">
            <select name="status" class="glass-select w-auto">
                <option class="text-black" value="">Semua Status</option>
                <option class="text-black" value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option class="text-black" value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option class="text-black" value="ditunda" {{ request('status') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="glass-input w-auto">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="glass-input w-auto">
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    <div class="table-responsive hidden md:block">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">SPK</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Bengkel</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $riwayat->firstItem() + $index }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->spk->nomor_spk }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->spk->pengajuanServis->kendaraan->merk }} {{ $item->spk->pengajuanServis->kendaraan->tipe }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->nama_bengkel }}</td>
                    <td class="py-3 px-4 text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('pptk.riwayat.show', $item) }}" class="btn-icon" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button @click="editId = '{{ $item->id }}'; editData = { spk_id: '{{ $item->spk_id }}', tanggal_masuk: '{{ $item->tanggal_masuk->format('Y-m-d') }}', tanggal_selesai: '{{ $item->tanggal_selesai?->format('Y-m-d') ?? '' }}', nama_bengkel: '{{ $item->nama_bengkel }}', hasil_pemeliharaan: '{{ $item->hasil_pemeliharaan }}', catatan: '{{ $item->catatan }}', status: '{{ $item->status->value }}' }; editModal = true" class="btn-icon" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('pptk.riwayat.destroy', $item) }}')" class="btn-icon" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
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
                            <h3 class="empty-title">Tidak Ada Data</h3>
                            <p class="empty-text">Belum ada riwayat pemeliharaan kendaraan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200">{{ $riwayat->withQueryString()->links() }}</div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($riwayat as $index => $item)
        <div class="glass-card p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="font-semibold text-gray-800">{{ $riwayat->firstItem() + $index }}</span>
                <span class="badge-{{ $item->status_color }} text-xs">{{ $item->label_status }}</span>
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">SPK:</span>
                    <span class="font-medium">{{ $item->spk->nomor_spk }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kendaraan:</span>
                    <span class="font-medium">{{ $item->spk->pengajuanServis->kendaraan->merk }} {{ $item->spk->pengajuanServis->kendaraan->tipe }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Bengkel:</span>
                    <span class="font-medium">{{ $item->nama_bengkel }}</span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                <a href="{{ route('pptk.riwayat.show', $item) }}" class="btn-icon" title="Detail">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <button @click="editId = '{{ $item->id }}'; editData = { spk_id: '{{ $item->spk_id }}', tanggal_masuk: '{{ $item->tanggal_masuk->format('Y-m-d') }}', tanggal_selesai: '{{ $item->tanggal_selesai?->format('Y-m-d') ?? '' }}', nama_bengkel: '{{ $item->nama_bengkel }}', hasil_pemeliharaan: '{{ $item->hasil_pemeliharaan }}', catatan: '{{ $item->catatan }}', status: '{{ $item->status->value }}' }; editModal = true" class="btn-icon" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </button>
                <button type="button" onclick="confirmDelete('{{ route('pptk.riwayat.destroy', $item) }}')" class="btn-icon" title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Tidak ada data
        </div>
        @endforelse
        <div class="p-4 border-t border-gray-200">{{ $riwayat->withQueryString()->links() }}</div>
    </div>

    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Tambah Riwayat Pemeliharaan</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('pptk.riwayat.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">SPK</label>
                            <select name="spk_id" class="glass-select w-full" required>
                                <option value="" class="text-black">Pilih SPK</option>
                                @foreach($spkList as $spk)
                                    <option class="text-black" value="{{ $spk->id }}">{{ $spk->nomor_spk }} - {{ $spk->pengajuanServis->kendaraan->merk }} {{ $spk->pengajuanServis->kendaraan->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" class="glass-input w-full" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" class="glass-input w-full" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">Nama Bengkel</label>
                                <input type="text" name="nama_bengkel" class="glass-input w-full" required placeholder="Nama bengkel">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" class="glass-select w-full" required>
                                <option class="text-black" value="diproses">Diproses</option>
                                <option class="text-black" value="selesai">Selesai</option>
                                <option class="text-black" value="ditunda">Ditunda</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hasil Pemeliharaan</label>
                            <textarea name="hasil_pemeliharaan" class="glass-input w-full" rows="3" placeholder="Deskripsi hasil pemeliharaan..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="glass-input w-full" rows="2" placeholder="Catatan tambahan..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lampiran</label>
                            <input type="file" name="lampiran[]" class="glass-input w-full" multiple accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="createModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="editModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="editModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Edit Riwayat Pemeliharaan</h3>
                <button @click="editModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" x-bind:action="`/pptk/riwayat/${editId}`" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="form-label">SPK</label>
                            <select name="spk_id" x-model="editData.spk_id" class="glass-select w-full" required>
                                <option class="text-black" value="">Pilih SPK</option>
                                @foreach($spkList as $spk)
                                    <option class="text-black" value="{{ $spk->id }}">{{ $spk->nomor_spk }} - {{ $spk->pengajuanServis->kendaraan->merk }} {{ $spk->pengajuanServis->kendaraan->tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">Tanggal Masuk</label>
                                <input type="date" name="tanggal_masuk" x-model="editData.tanggal_masuk" class="glass-input w-full" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" x-model="editData.tanggal_selesai" class="glass-input w-full">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-group">
                                <label class="form-label">Nama Bengkel</label>
                                <input type="text" name="nama_bengkel" x-model="editData.nama_bengkel" class="glass-input w-full" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select name="status" x-model="editData.status" class="glass-select w-full" required>
                                <option class="text-black" value="diproses">Diproses</option>
                                <option class="text-black" value="selesai">Selesai</option>
                                <option class="text-black" value="ditunda">Ditunda</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Hasil Pemeliharaan</label>
                            <textarea name="hasil_pemeliharaan" x-model="editData.hasil_pemeliharaan" class="glass-input w-full" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" x-model="editData.catatan" class="glass-input w-full" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tambah Lampiran</label>
                            <input type="file" name="lampiran[]" class="glass-input w-full" multiple accept=".jpg,.jpeg,.png,.pdf">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="editModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
