@extends('layouts.app')
@section('title', 'Assign Pengaju')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="assignManager()">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Assign Pengaju</h1>
            <p class="text-gray-500 text-sm mt-1">Atur penugasan pengaju ke kendaraan dinas</p>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="createModal = true" class="btn-primary flex-1 sm:flex-none">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Assignment
                </span>
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="filter-card">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-end">
            <div class="flex-1 w-full">
                <label class="block text-xs text-gray-500 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari plat nomor, merk, tipe..." class="glass-input w-full">
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
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Plat Nomor</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-500">Pengaju</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-500">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kendaraan as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $kendaraan->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $item->plat_nomor }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->merk }} {{ $item->tipe }}</td>
                    <td class="py-3 px-4 text-gray-700">
                        @if($item->pengaju)
                            {{ $item->pengaju->name }} ({{ $item->pengaju->nip }})
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            @if($item->pengaju)
                            <button type="button" onclick="confirmDelete('{{ route('admin.assign.destroy', $item->id) }}', 'Assignment ini akan dihapus.')" class="btn-icon" title="Hapus assignment">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @else
                            <span class="text-gray-600 text-xs">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Assignment</h3>
                            <p class="empty-text">Belum ada pengaju yang ditugaskan ke kendaraan.</p>
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
            </div>
            <div class="space-y-1 text-sm mt-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Plat Nomor:</span>
                    <span class="font-medium">{{ $item->plat_nomor }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Kendaraan:</span>
                    <span class="font-medium">{{ $item->merk }} {{ $item->tipe }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Pengaju:</span>
                    <span class="font-medium">
                        @if($item->pengaju)
                            {{ $item->pengaju->name }} ({{ $item->pengaju->nip }})
                        @else
                            <span class="text-gray-500">-</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="flex items-center justify-end gap-1 mt-3 pt-3 border-t border-gray-100">
                @if($item->pengaju)
                <button type="button" onclick="confirmDelete('{{ route('admin.assign.destroy', $item->id) }}', 'Assignment ini akan dihapus.')" class="btn-icon" title="Hapus assignment">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
                @else
                <span class="text-gray-600 text-xs">-</span>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            Belum ada assignment
        </div>
        @endforelse
        <div class="p-4">{{ $kendaraan->withQueryString()->links() }}</div>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-lg" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-gray-800">Tambah Assignment</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.assign.store') }}">
                @csrf
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label class="form-label">Kendaraan *</label>
                        <select name="kendaraan_id" class="glass-select w-full" required>
                            <option class="text-black" value="">Pilih Kendaraan</option>
                            @foreach($kendaraan as $item)
                            <option class="text-black" value="{{ $item->id }}">
                                {{ $item->plat_nomor }} - {{ $item->merk }} {{ $item->tipe }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pengaju *</label>
                        <select name="pengaju_id" class="glass-select w-full" required>
                            <option class="text-black" value="">Pilih Pengaju</option>
                            @foreach($pengajuList as $pengaju)
                            <option class="text-black" value="{{ $pengaju->id }}">
                                {{ $pengaju->name }} ({{ $pengaju->nip }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="createModal = false" class="btn-secondary">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function assignManager() {
    return {
        createModal: false,
    }
}
</script>
@endpush
