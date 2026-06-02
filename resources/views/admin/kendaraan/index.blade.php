@extends('layouts.app')
@section('title', 'Manajemen Kendaraan')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="kendaraanManager()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Kendaraan</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola data kendaraan dinas</p>
        </div>
        <button @click="openCreate()" class="btn-primary">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kendaraan
        </button>
    </div>

    {{-- Search & Filter --}}
    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, plat, merk, tipe..." class="glass-input flex-1 min-w-[200px]">
            <select name="status" class="glass-select w-auto">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="servis" {{ request('status') == 'servis' ? 'selected' : '' }}>Servis</option>
                <option value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="btn-primary">Filter</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Kode</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Plat Nomor</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Merk</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Tipe</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Tahun</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $index => $item)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-3 px-4 text-gray-300">{{ $kendaraan->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-white">{{ $item->kode_kendaraan }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->plat_nomor }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->merk }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->tipe }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->tahun }}</td>
                    <td class="py-3 px-4 text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button @click='detail(@json($item))' class="btn-icon" title="Detail kendaraan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button @click='edit(@json($item))' class="btn-icon" title="Edit kendaraan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('admin.kendaraan.destroy', $item) }}')" class="btn-icon" title="Hapus kendaraan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Kendaraan</h3>
                            <p class="empty-text">Mulai dengan menambahkan kendaraan baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $kendaraan->withQueryString()->links() }}</div>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Tambah Kendaraan</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.kendaraan.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Plat Nomor *</label>
                            <input type="text" name="plat_nomor" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Merk *</label>
                            <input type="text" name="merk" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="tipe" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" class="glass-input w-full" min="1900" max="{{ date('Y')+1 }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Rangka</label>
                            <input type="text" name="nomor_rangka" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Mesin</label>
                            <input type="text" name="nomor_mesin" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" class="glass-select w-full" required>
                                <option value="aktif">Aktif</option>
                                <option value="servis">Servis</option>
                                <option value="rusak">Rusak</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group md:col-span-2">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="glass-input w-full" rows="2"></textarea>
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

    {{-- Edit Modal --}}
    <div x-show="editModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="editModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Edit Kendaraan</h3>
                <button @click="editModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" x-bind:action="editAction">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Kode Kendaraan</label>
                            <input type="text" name="kode_kendaraan" x-model="editData.kode_kendaraan" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Plat Nomor *</label>
                            <input type="text" name="plat_nomor" x-model="editData.plat_nomor" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Merk *</label>
                            <input type="text" name="merk" x-model="editData.merk" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipe</label>
                            <input type="text" name="tipe" x-model="editData.tipe" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun</label>
                            <input type="number" name="tahun" x-model="editData.tahun" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Warna</label>
                            <input type="text" name="warna" x-model="editData.warna" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Rangka</label>
                            <input type="text" name="nomor_rangka" x-model="editData.nomor_rangka" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Mesin</label>
                            <input type="text" name="nomor_mesin" x-model="editData.nomor_mesin" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Perolehan</label>
                            <input type="date" name="tanggal_perolehan" x-model="editData.tanggal_perolehan" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" x-model="editData.status" class="glass-select w-full" required>
                                <option value="aktif">Aktif</option>
                                <option value="servis">Servis</option>
                                <option value="rusak">Rusak</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group md:col-span-2">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" x-model="editData.keterangan" class="glass-input w-full" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="editModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div x-show="detailModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-lg" @click.outside="detailModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Detail Kendaraan</h3>
                <button @click="detailModal = false" class="btn-icon">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Kode Kendaraan</span>
                    <span class="text-white font-medium" x-text="detailData.kode_kendaraan"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Plat Nomor</span>
                    <span class="text-white font-medium" x-text="detailData.plat_nomor"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Merk</span>
                    <span class="text-white font-medium" x-text="detailData.merk"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Tipe</span>
                    <span class="text-white font-medium" x-text="detailData.tipe"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Tahun</span>
                    <span class="text-white font-medium" x-text="detailData.tahun"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Warna</span>
                    <span class="text-white font-medium" x-text="detailData.warna"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Nomor Rangka</span>
                    <span class="text-white font-medium" x-text="detailData.nomor_rangka"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Nomor Mesin</span>
                    <span class="text-white font-medium" x-text="detailData.nomor_mesin"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Tanggal Perolehan</span>
                    <span class="text-white font-medium" x-text="detailData.tanggal_perolehan"></span>
                </div>
                <div class="flex justify-between py-2 border-b border-white/5">
                    <span class="text-gray-400">Status</span>
                    <span class="text-white font-medium" x-text="detailData.status"></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-400">Keterangan</span>
                    <span class="text-white font-medium" x-text="detailData.keterangan"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" @click="detailModal = false" class="btn-primary">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function kendaraanManager() {
    return {
        createModal: false,
        editModal: false,
        detailModal: false,
        editAction: '',
        editData: {},
        detailData: {},
        openCreate() { this.createModal = true; },
        detail(item) {
            this.detailData = item;
            this.detailModal = true;
        },
        edit(item) {
            this.editAction = '/admin/kendaraan/' + item.id;
            this.editData = {
                kode_kendaraan: item.kode_kendaraan || '',
                plat_nomor: item.plat_nomor || '',
                merk: item.merk || '',
                tipe: item.tipe || '',
                tahun: item.tahun || '',
                warna: item.warna || '',
                nomor_rangka: item.nomor_rangka || '',
                nomor_mesin: item.nomor_mesin || '',
                tanggal_perolehan: item.tanggal_perolehan ? item.tanggal_perolehan.substring(0,10) : '',
                status: item.status || 'aktif',
                keterangan: item.keterangan || ''
            };
            this.editModal = true;
        },
    }
}
</script>
@endpush
