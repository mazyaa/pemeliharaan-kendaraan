<?php

namespace App\Services;

use App\Repositories\RiwayatPemeliharaanRepository;

class LaporanService
{
    public function __construct(protected RiwayatPemeliharaanRepository $riwayatRepo) {}

    public function generate(array $filters, int $perPage = 10): array
    {
        $riwayat = $this->riwayatRepo->paginated($filters, $perPage);
        $collection = $riwayat->getCollection();

        $totalSelesai = $collection->filter(fn ($r) => $r->status->value === 'selesai')->count();
        $totalDiproses = $collection->filter(fn ($r) => $r->status->value === 'diproses')->count();

        return [
            'data' => $riwayat,
            'summary' => [
                'total_selesai' => $totalSelesai,
                'total_diproses' => $totalDiproses,
                'total_data' => $riwayat->total(),
            ],
            'filters' => $filters,
        ];
    }
}
