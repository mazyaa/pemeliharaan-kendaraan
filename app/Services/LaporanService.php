<?php

namespace App\Services;

use App\Repositories\RiwayatPemeliharaanRepository;

class LaporanService
{
    public function __construct(protected RiwayatPemeliharaanRepository $riwayatRepo) {}

    public function generate(array $filters): array
    {
        $riwayat = $this->riwayatRepo->paginated($filters, 1000);
        $collection = $riwayat->getCollection();

        $totalBiaya = $collection->sum('biaya');
        $totalSelesai = $collection->filter(fn ($r) => $r->status->value === 'selesai')->count();
        $totalDiproses = $collection->filter(fn ($r) => $r->status->value === 'diproses')->count();

        return [
            'data' => $riwayat,
            'summary' => [
                'total_biaya' => $totalBiaya,
                'total_selesai' => $totalSelesai,
                'total_diproses' => $totalDiproses,
                'total_data' => $riwayat->total(),
            ],
            'filters' => $filters,
        ];
    }
}
