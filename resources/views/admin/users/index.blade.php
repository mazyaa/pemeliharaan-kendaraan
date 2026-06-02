@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="space-y-6 animate-fade-in" x-data="userManager()">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Pengguna</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola pengguna sistem</p>
        </div>
        <button @click="openCreate()" class="btn-primary">
            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </button>
    </div>

    {{-- Search & Filter --}}
    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NIP..." class="glass-input flex-1 min-w-[200px]">
            <select name="role_id" class="glass-select w-auto">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
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
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Nama</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Email</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Role</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">NIP</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Posisi</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Telepon</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Status</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-3 px-4 text-gray-300">{{ $users->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-medium text-white">{{ $user->name }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->email }}</td>
                    <td class="py-3 px-4"><span class="badge-primary">{{ $user->role?->name }}</span></td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->nip }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->position }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $user->phone }}</td>
                    <td class="py-3 px-4 text-center">
                        @if($user->is_active)
                            <span class="badge-success">Aktif</span>
                        @else
                            <span class="badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-center gap-1">
                            <button @click='edit(@json($user))' class="btn-icon" title="Edit pengguna">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}')" class="btn-icon" title="Hapus pengguna">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <h3 class="empty-title">Belum Ada Pengguna</h3>
                            <p class="empty-text">Mulai dengan menambahkan pengguna baru.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $users->withQueryString()->links() }}</div>
    </div>

    {{-- Create Modal --}}
    <div x-show="createModal" class="modal-backdrop" x-cloak>
        <div class="modal-content max-w-2xl" @click.outside="createModal = false">
            <div class="modal-header">
                <h3 class="text-lg font-bold text-white">Tambah Pengguna</h3>
                <button @click="createModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Nama *</label>
                            <input type="text" name="name" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password *</label>
                            <input type="password" name="password" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Role *</label>
                            <select name="role_id" class="glass-select w-full" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Posisi</label>
                            <input type="text" name="position" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password *</label>
                            <input type="password" name="password_confirmation" class="glass-input w-full" required>
                        </div>
                        <div class="md:col-span-2 form-group">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" checked class="rounded bg-white/5 border-white/20 text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-300">Aktif</span>
                            </label>
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
                <h3 class="text-lg font-bold text-white">Edit Pengguna</h3>
                <button @click="editModal = false" class="btn-icon">&times;</button>
            </div>
            <form method="POST" x-bind:action="editAction">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Nama *</label>
                            <input type="text" name="name" x-model="editData.name" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" x-model="editData.email" class="glass-input w-full" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" x-model="editData.nip" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password <span class="text-gray-500 text-xs">(kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Role *</label>
                            <select name="role_id" x-model="editData.role_id" class="glass-select w-full" required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Posisi</label>
                            <input type="text" name="position" x-model="editData.position" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Telepon</label>
                            <input type="text" name="phone" x-model="editData.phone" class="glass-input w-full">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="glass-input w-full">
                        </div>
                        <div class="md:col-span-2 form-group">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" class="rounded bg-white/5 border-white/20 text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-300">Aktif</span>
                            </label>
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
</div>
@endsection

@push('scripts')
<script>
function userManager() {
    return {
        createModal: false,
        editModal: false,
        editAction: '',
        editData: {},
        openCreate() { this.createModal = true; },
        edit(user) {
            this.editAction = '/admin/users/' + user.id;
            this.editData = {
                name: user.name || '',
                email: user.email || '',
                nip: user.nip || '',
                role_id: user.role_id || '',
                position: user.position || '',
                phone: user.phone || '',
                is_active: user.is_active ? true : false
            };
            this.editModal = true;
        },
    }
}
</script>
@endpush
