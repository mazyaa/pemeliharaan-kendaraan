@extends('layouts.app')
@section('title', 'Manajemen Kendaraan')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="kendaraanManager()">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Kendaraan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola data kendaraan dinas</p>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="openCreate()" class="btn-primary flex-1 sm:flex-none">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Kendaraan
                </span>
            </button>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="filter-card">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1 w-full">
                <label class="block text-xs text-gray-500 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode, plat, merk, tipe..." class="glass-input w-full">
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select name="status" class="glass-select w-full sm:w-48">
                    <option class="text-black" value="">Semua Status</option>
                    <option class="text-black" value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option class="text-black" value="servis" {{ request('status') == 'servis' ? 'selected' : '' }}>Servis</option>
                    <option class="text-black" value="rusak" {{ request('status') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option class="text-black" value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="btn-primary w-full sm:w-auto">Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-container hidden md:block">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kode</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Plat Nomor</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Merk</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Tipe</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Tahun</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $kendaraan->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item->kode_kendaraan }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->plat_nomor }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->merk }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tipe }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tahun }}</td>
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

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($kendaraan as $index => $item)
        <div class="glass-card p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="font-semibold text-gray-800">{{ $kendaraan->firstItem() + $index }}</span>
                <span class="badge-{{ $item->status_color }} text-xs">{{ $item->label_status }}</span>
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Kode:</span>
                    <span class="font-medium">{{ $item->kode_kendaraan }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Plat Nomor:</span>
                    <span class="font-medium">{{ $item->plat_nomor }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Merk:</span>
                    <span class="font-medium">{{ $item->merk }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tipe:</span>
                    <span class="font-medium">{{ $item->tipe }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tahun:</span>
                    <span class="font-medium">{{ $item->tahun }}</span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
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
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada kendaraan
        </div>
        @endforelse
        <div class="p-4">{{ $kendaraan->withQueryString()->links() }}</div>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Tambah Kendaraan</h3>
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
                            <label class="form-label">Tipe *</label>
                            <input type="text" name="tipe" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tahun *</label>
                            <input type="number" name="tahun" class="glass-input w-full" min="1900" max="{{ date('Y')+1 }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Warna *</label>
                            <input type="text" name="warna" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Rangka *</label>
                            <input type="text" name="nomor_rangka" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Mesin *</label>
                            <input type="text" name="nomor_mesin" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Perolehan *</label>
                            <input type="date" name="tanggal_perolehan" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status *</label>
                            <select name="status" class="glass-select w-full" required>
                                <option class="text-black" value="aktif">Aktif</option>
                                <option class="text-black" value="servis">Servis</option>
                                <option class="text-black" value="rusak">Rusak</option>
                                <option class="text-black" value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="form-group md:col-span-2">
                            <label class="form-label">Keterangan *</label>
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
                <h3 class="text-lg font-bold text-gray-800">Edit Kendaraan</h3>
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
                                <option class="text-black" value="aktif">Aktif</option>
                                <option class="text-black" value="servis">Servis</option>
                                <option class="text-black" value="rusak">Rusak</option>
                                <option class="text-black" value="nonaktif">Nonaktif</option>
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
         <div class="modal-content max-w-2xl" @click.outside="detailModal = false">
             <div class="modal-header">
                 <h3 class="text-lg font-bold text-gray-800">Detail Kendaraan</h3>
                 <button @click="detailModal = false" class="btn-icon">&times;</button>
             </div>
             <div class="modal-body space-y-6">
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <div>
                         <span class="text-sm text-gray-500 block">Kode Kendaraan</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.kode_kendaraan"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Plat Nomor</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.plat_nomor"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Merk</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.merk"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Tipe</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.tipe"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Tahun</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.tahun"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Warna</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.warna"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Nomor Rangka</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.nomor_rangka"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Nomor Mesin</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.nomor_mesin"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Tanggal Perolehan</span>
                         <p class="text-gray-800 font-medium text-lg" x-text="detailData.tanggal_perolehan"></p>
                     </div>
                     <div>
                         <span class="text-sm text-gray-500 block">Status</span>
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                               :class="'bg-' + detailData.status_color + '/20 text-' + detailData.status_color"
                               x-text="detailData.label_status"></span>
                     </div>
                     <div class="md:col-span-2">
                         <span class="text-sm text-gray-500 block">Keterangan</span>
                         <p class="text-gray-800 font-medium whitespace-pre-line" x-text="detailData.keterangan"></p>
                     </div>
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
