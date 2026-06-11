<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\SpkRepository;
use App\Repositories\RiwayatPemeliharaanRepository;

class DashboardService
{
    public function __construct(
        protected KendaraanRepository $kendaraanRepo,
        protected PengajuanServisRepository $pengajuanRepo,
        protected SpkRepository $spkRepo,
        protected RiwayatPemeliharaanRepository $riwayatRepo,
    ) {}

    public function getAdminStats(): array
    {
        return [
            'total_kendaraan' => $this->kendaraanRepo->count(),
            'kendaraan_aktif' => $this->kendaraanRepo->countByStatus('aktif'),
            'kendaraan_servis' => $this->kendaraanRepo->countByStatus('servis'),
            'kendaraan_rusak' => $this->kendaraanRepo->countByStatus('rusak'),
            'kendaraan_nonaktif' => $this->kendaraanRepo->countByStatus('nonaktif'),
            'pengajuan_bulan_ini' => $this->pengajuanRepo->countThisMonth(),
            'total_pengajuan' => $this->pengajuanRepo->count(),
            'spk_terbit' => $this->spkRepo->countThisMonth(),
            'total_spk' => $this->spkRepo->count(),
            'pemeliharaan_selesai' => $this->riwayatRepo->countSelesai(),
        ];
    }

    public function getChartData(): array
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'pengajuan' => $this->pengajuanRepo->paginated([
                    'date_from' => $date->startOfMonth()->format('Y-m-d'),
                    'date_to' => $date->endOfMonth()->format('Y-m-d'),
                ], 1000)->total(),
                'spk' => $this->spkRepo->paginated([], 1000)->total(),
            ];
        }

        $kendaraanStatus = [
            ['label' => 'Aktif', 'value' => $this->kendaraanRepo->countByStatus('aktif')],
            ['label' => 'Servis', 'value' => $this->kendaraanRepo->countByStatus('servis')],
            ['label' => 'Rusak', 'value' => $this->kendaraanRepo->countByStatus('rusak')],
            ['label' => 'Nonaktif', 'value' => $this->kendaraanRepo->countByStatus('nonaktif')],
        ];

        return [
            'monthly' => $months,
            'kendaraan_status' => $kendaraanStatus,
        ];
    }

    public function getRecentPengajuan(int $limit = 5)
    {
        return $this->pengajuanRepo->paginated([], $limit);
    }
}
