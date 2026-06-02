@extends('layouts.app')
@section('title', 'Manajemen Role')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="roleManager()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Role</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola role pengguna sistem</p>
        </div>
        <button @click="openCreate()" class="btn-primary">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Role
        </button>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Nama</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Deskripsi</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $index => $role)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-3 px-4 text-gray-300">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-medium text-white">{{ $role->name }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $role->description }}</td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button @click='edit({{ $role->id }}, @json($role->name), @json($role->description))' class="btn-icon" title="Edit role">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('admin.roles.destroy', $role) }}')" class="btn-icon" title="Hapus role">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Role</h3>
                            <p class="empty-text">Mulai dengan menambahkan role baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Tambah Role</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label class="form-label">Nama Role</label>
                        <input type="text" name="name" class="glass-input w-full" required placeholder="Masukkan nama role">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="glass-input w-full" rows="3" placeholder="Deskripsi role (opsional)"></textarea>
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
        <div class="modal-content" @click.outside="editModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Edit Role</h3>
                <button @click="editModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" x-bind:action="editAction">
                @csrf @method('PUT')
                <div class="modal-body space-y-4">
                    <div class="form-group">
                        <label class="form-label">Nama Role</label>
                        <input type="text" name="name" x-model="editName" class="glass-input w-full" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" x-model="editDescription" class="glass-input w-full" rows="3"></textarea>
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
function roleManager() {
    return {
        createModal: false,
        editModal: false,
        editAction: '',
        editName: '',
        editDescription: '',
        openCreate() { this.createModal = true; },
        edit(id, name, description) {
            this.editAction = '/admin/roles/' + id;
            this.editName = name;
            this.editDescription = description;
            this.editModal = true;
        },
    }
}
</script>
@endpush
