@extends('layouts.app')
@section('title', 'Laporan Pemeliharaan')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Pemeliharaan</h1>
            <p class="text-gray-500 text-sm mt-1">Laporan data pemeliharaan kendaraan dinas</p>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="{{ route('laporan.export-pdf') }}?{{ http_build_query(request()->query()) }}" class="btn-success flex-1 sm:flex-none">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </span>
            </a>
        </div>
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

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="stat-card gradient-success">
            <div class="relative z-10">
                <p class="text-2xl font-bold">{{ $summary['total_selesai'] }}</p>
                <p class="text-white/80 text-sm mt-1">Selesai</p>
            </div>
        </div>
        <div class="stat-card gradient-warning">
            <div class="relative z-10">
                <p class="text-2xl font-bold">{{ $summary['total_diproses'] }}</p>
                <p class="text-white/80 text-sm mt-1">Diproses</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <!-- Desktop Table -->
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm">
                <thead class="table-header">
                    <tr>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">No</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">SPK</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">Kendaraan</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">Bengkel</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">Masuk</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-500">Selesai</th>
                        <th class="text-center py-3 px-4 font-semibold text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $index => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-gray-700">{{ $data->firstItem() + $index }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ optional($item->spk)->nomor_spk ?? '-' }}</td>
                    <td class="py-3 px-4 text-gray-700">
                        @php
                            $kendaraan = optional(optional($item->spk)->pengajuanServis)->kendaraan;
                        @endphp
                        {{ $kendaraan ? $kendaraan->merk.' '.$kendaraan->tipe : '-' }}
                    </td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->nama_bengkel }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tanggal_masuk->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                    <td class="py-3 px-4 text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <h3 class="empty-title">Tidak Ada Data</h3>
                            <p class="empty-text">Belum ada data laporan pemeliharaan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Cards -->
    <div class="md:hidden space-y-3">
        @forelse($data as $index => $item)
            <div class="glass-card p-4">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-semibold text-gray-800">SPK: {{ optional($item->spk)->nomor_spk ?? '-' }}</span>
                    <span class="text-xs text-gray-500">{{ $item->tanggal_masuk->format('d/m/Y') }}</span>
                </div>
                <div class="space-y-1 text-sm mt-3">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Kendaraan:</span>
                        <span class="font-medium">
                            @php
                                $kendaraan = optional(optional($item->spk)->pengajuanServis)->kendaraan;
                            @endphp
                            {{ $kendaraan ? $kendaraan->merk.' '.$kendaraan->tipe : '-' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Bengkel:</span>
                        <span class="font-medium">{{ $item->nama_bengkel }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Selesai:</span>
                        <span class="font-medium">{{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Status:</span>
                        <span><span class="badge-{{ $item->status_color }} text-xs">{{ $item->label_status }}</span></span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                Tidak ada data
            </div>
        @endforelse
    </div>
        <div class="p-4 border-t border-gray-200">{{ $data->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
