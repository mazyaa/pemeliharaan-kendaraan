@extends('layouts.app')
@section('title', 'Laporan Pemeliharaan')

@section('content')
<div class="space-y-6 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Laporan Pemeliharaan</h1>
            <p class="text-gray-400 text-sm mt-1">Laporan data pemeliharaan kendaraan dinas</p>
        </div>
        <a href="{{ route('laporan.export-pdf') }}?{{ http_build_query(request()->query()) }}" class="btn-success">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export PDF
            </span>
        </a>
    </div>

    <div class="filter-card">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bengkel, hasil..." class="glass-input flex-1 min-w-[200px]">
            <select name="status" class="glass-select w-auto">
                <option value="">Semua Status</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditunda" {{ request('status') == 'ditunda' ? 'selected' : '' }}>Ditunda</option>
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
        <div class="stat-card gradient-primary">
            <div class="relative z-10">
                <p class="text-2xl font-bold">Rp {{ number_format($summary['total_biaya'], 0, ',', '.') }}</p>
                <p class="text-white/80 text-sm mt-1">Total Biaya</p>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table class="w-full text-sm">
            <thead class="table-header">
                <tr>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">No</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">SPK</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Kendaraan</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Bengkel</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Masuk</th>
                    <th class="text-left py-3 px-4 font-semibold text-gray-400">Selesai</th>
                    <th class="text-right py-3 px-4 font-semibold text-gray-400">Biaya</th>
                    <th class="text-center py-3 px-4 font-semibold text-gray-400">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                    <td class="py-3 px-4 text-gray-300">{{ $data->firstItem() + $index }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ optional($item->spk)->nomor_spk ?? '-' }}</td>
                    <td class="py-3 px-4 text-gray-300">
                        @php
                            $kendaraan = optional(optional($item->spk)->pengajuanServis)->kendaraan;
                        @endphp
                        {{ $kendaraan ? $kendaraan->merk.' '.$kendaraan->tipe : '-' }}
                    </td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->nama_bengkel }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->tanggal_masuk->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-gray-300">{{ $item->tanggal_selesai?->format('d/m/Y') ?? '-' }}</td>
                    <td class="py-3 px-4 text-right text-gray-300">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-center"><span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
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
        <div class="p-4 border-t border-white/5">{{ $data->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
