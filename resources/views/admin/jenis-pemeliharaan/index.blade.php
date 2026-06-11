@extends('layouts.app')
@section('title', 'Master Jenis Pemeliharaan')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="jenisManager()">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Master Jenis Pemeliharaan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola jenis pemeliharaan kendaraan dinas</p>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="openCreate()" class="btn-primary flex-1 sm:flex-none">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Jenis
                </span>
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="filter-card">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1 w-full">
                <label class="block text-xs text-gray-500 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kategori, deskripsi..." class="glass-input w-full">
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
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kategori</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Nama</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Interval (Hari)</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Deskripsi</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenis as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $jenis->firstItem() + $index }}</td>
                    <td class="py-3 px-4"><span class="badge-primary">{{ $item->kategori }}</span></td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item->nama }}</td>
                    <td class="py-3 px-4 text-center text-gray-700">{{ $item->interval_hari }}</td>
                    <td class="py-3 px-4 text-gray-700 max-w-xs truncate">{{ $item->deskripsi ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">
                        @if($item->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button @click='edit(@json($item))' class="btn-icon" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('admin.jenis-pemeliharaan.destroy', $item) }}')" class="btn-icon" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 00.659 1.591L19 14.5m-4.75-11.396c.251.023.501.05.75.082M12 21a8.966 8.966 0 005.982-2.275M12 21a8.966 8.966 0 01-5.982-2.275M15.75 3.186a24.284 24.284 0 012.068.858M6.318 3.186a24.284 24.284 0 00-2.068.858M12 3c-2.485 0-4.847.49-7.043 1.386"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Jenis Pemeliharaan</h3>
                            <p class="empty-text">Mulai dengan menambahkan jenis pemeliharaan baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $jenis->withQueryString()->links() }}</div>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($jenis as $index => $item)
        <div class="glass-card p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="font-semibold text-gray-800">{{ $jenis->firstItem() + $index }}</span>
                <span class="badge-primary text-xs">{{ $item->kategori }}</span>
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-medium">{{ $item->nama }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Interval:</span>
                    <span class="font-medium">{{ $item->interval_hari }} hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Deskripsi:</span>
                    <span class="font-medium max-w-[60%] text-right truncate">{{ $item->deskripsi ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    <span>
                        @if($item->is_active)
                            <span class="badge-success text-xs">Aktif</span>
                        @else
                            <span class="badge-danger text-xs">Nonaktif</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                <button @click='edit(@json($item))' class="btn-icon" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </button>
                <button type="button" onclick="confirmDelete('{{ route('admin.jenis-pemeliharaan.destroy', $item) }}')" class="btn-icon" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada jenis pemeliharaan
        </div>
        @endforelse
        <div class="p-4">{{ $jenis->withQueryString()->links() }}</div>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-lg" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Tambah Jenis Pemeliharaan</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.jenis-pemeliharaan.store') }}">
                @csrf
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <input type="text" name="kategori" class="glass-input w-full" required placeholder="Contoh: Mesin, Rem, Kelistrikan">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama *</label>
                        <input type="text" name="nama" class="glass-input w-full" required placeholder="Contoh: Ganti Oli Mesin">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Interval (hari) *</label>
                        <input type="number" name="interval_hari" class="glass-input w-full" required min="1" placeholder="Contoh: 30">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="glass-input w-full" rows="3" placeholder="Deskripsi jenis pemeliharaan..."></textarea>
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
        <div class="modal-content max-w-lg" @click.outside="editModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Edit Jenis Pemeliharaan</h3>
                <button @click="editModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" x-bind:action="editAction">
                @csrf @method('PUT')
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <input type="text" name="kategori" x-model="editData.kategori" class="glass-input w-full" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama *</label>
                        <input type="text" name="nama" x-model="editData.nama" class="glass-input w-full" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Interval (hari) *</label>
                        <input type="number" name="interval_hari" x-model="editData.interval_hari" class="glass-input w-full" required min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" x-model="editData.deskripsi" class="glass-input w-full" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" class="rounded bg-gray-50 border-gray-300 text-green-500 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="editModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function jenisManager() {
    return {
        createModal: false,
        editModal: false,
        editAction: '',
        editData: {},
        openCreate() { this.createModal = true; },
        edit(item) {
            this.editAction = '/admin/jenis-pemeliharaan/' + item.id;
            this.editData = {
                kategori: item.kategori || '',
                nama: item.nama || '',
                interval_hari: item.interval_hari || '',
                deskripsi: item.deskripsi || '',
                is_active: item.is_active ? true : false
            };
            this.editModal = true;
        },
    }
}
</script>
@endpush
