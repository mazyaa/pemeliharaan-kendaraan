@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
            <div class="stat-card gradient-primary p-4 sm:p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="stat-icon w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        </div>
                    </div>
                    <p class="stat-value text-2xl sm:text-3xl">{{ $stats['total_kendaraan'] }}</p>
                    <p class="text-emerald-800 font-bold text-xs sm:text-sm">Total Kendaraan</p>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/20 rounded-full -mr-6 sm:-mr-10 -mt-6 sm:-mt-10"></div>
            </div>

            <div class="stat-card gradient-success p-4 sm:p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="stat-icon w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 11.25L5.25 7.5A2.25 2.25 0 017.35 6h9.3a2.25 2.25 0 012.1 1.5l1.5 3.75M4.5 16.5h15M6.75 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm13.5 0a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM3.75 11.25h16.5v3.75a1.5 1.5 0 01-1.5 1.5h-13.5a1.5 1.5 0 01-1.5-1.5v-3.75z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 8.25l1.5 1.5 3-3" />
                            </svg>
                        </div>
                    </div>
                    <p class="stat-value text-2xl sm:text-3xl">{{ $stats['kendaraan_aktif'] }}</p>
                    <p class="text-emerald-800 font-bold text-xs sm:text-sm">Kendaraan Aktif</p>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/20 rounded-full -mr-6 sm:-mr-10 -mt-6 sm:-mt-10"></div>
            </div>

            <div class="stat-card gradient-warning p-4 sm:p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="stat-icon w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                    </div>
                    <p class="stat-value text-2xl sm:text-3xl">{{ $stats['pengajuan_bulan_ini'] }}</p>
                    <p class="text-emerald-800 font-bold text-xs sm:text-sm">Pengajuan Bulan Ini</p>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/20 rounded-full -mr-6 sm:-mr-10 -mt-6 sm:-mt-10"></div>
            </div>

            <div class="stat-card gradient-secondary p-4 sm:p-6">
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <div class="stat-icon w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75l2.25 2.25L15 9.75m6 2.25a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="stat-value text-2xl sm:text-3xl">{{ $stats['pemeliharaan_selesai'] }}</p>
                    <p class="text-emerald-800 font-bold text-xs sm:text-sm">Pemeliharaan Selesai</p>
                </div>
                <div class="absolute top-0 right-0 w-20 h-20 sm:w-32 sm:h-32 bg-white/20 rounded-full -mr-6 sm:-mr-10 -mt-6 sm:-mt-10"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <div class="lg:col-span-2 glass-card p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Statistik Pengajuan</h3>
                <div class="h-52 sm:h-72">
                    <canvas id="pengajuanChart"></canvas>
                </div>
            </div>
            <div class="glass-card p-4 sm:p-6">
                <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Status Kendaraan</h3>
                <div class="h-52 sm:h-72">
                    <canvas id="kendaraanChart"></canvas>
                </div>
            </div>
        </div>

        <div class="table-container">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 px-4 sm:px-6 pt-4 sm:pt-6 pb-2 sm:pb-3">Pengajuan Terbaru</h3>

            <!-- Desktop Table -->
            <div class="overflow-x-auto hidden md:block">
                <table class="w-full text-xs sm:text-sm">
                    <thead>
                        <tr class="table-header">
                            <th>Nomor</th>
                            <th>Kendaraan</th>
                            <th>Pengaju</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPengajuan as $item)
                            <tr>
                                <td class="font-medium text-gray-800 px-3 sm:px-4 py-2.5 sm:py-3.5">{{ $item->nomor_pengajuan }}</td>
                                <td class="px-3 sm:px-4 py-2.5 sm:py-3.5">{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }}</td>
                                <td class="px-3 sm:px-4 py-2.5 sm:py-3.5">{{ $item->pengaju->name }}</td>
                                <td class="px-3 sm:px-4 py-2.5 sm:py-3.5">
                                    <span class="badge-{{ $item->status_color }}">{{ $item->label_status }}</span>
                                </td>
                                <td class="px-3 sm:px-4 py-2.5 sm:py-3.5">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-6 sm:py-8">Belum ada data pengajuan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                @forelse($recentPengajuan as $item)
                    <div class="glass-card p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-semibold text-gray-800">{{ $item->nomor_pengajuan }}</span>
                            <span class="text-xs text-gray-500">{{ $item->tanggal_pengajuan->format('d/m/Y') }}</span>
                        </div>
                        <div class="space-y-1 text-sm mt-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kendaraan:</span>
                                <span class="font-medium">{{ $item->kendaraan->merk }} {{ $item->kendaraan->tipe }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pengaju:</span>
                                <span class="font-medium">{{ $item->pengaju->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Status:</span>
                                <span><span class="badge-{{ $item->status_color }} text-xs">{{ $item->label_status }}</span></span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        Belum ada data pengajuan
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const pengajuanCtx = document.getElementById('pengajuanChart').getContext('2d');
            new Chart(pengajuanCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($chartData['monthly'])->pluck('month')) !!},
                    datasets: [{
                        label: 'Pengajuan',
                        data: {!! json_encode(collect($chartData['monthly'])->pluck('pengajuan')) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#9CA3AF'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#9CA3AF'
                            }
                        }
                    }
                }
            });

            const kendaraanCtx = document.getElementById('kendaraanChart').getContext('2d');
            new Chart(kendaraanCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(collect($chartData['kendaraan_status'])->pluck('label')) !!},
                    datasets: [{
                        data: {!! json_encode(collect($chartData['kendaraan_status'])->pluck('value')) !!},
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(107, 114, 128, 0.8)',
                        ],
                        borderWidth: 0,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 16,
                                usePointStyle: true,
                                color: '#374151'
                            }
                        }
                    },
                    cutout: '70%',
                }
            });
        </script>
    @endpush
@endsection
