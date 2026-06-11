<?php

namespace App\Repositories;

use App\Models\Spk;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class SpkRepository
{
    public function __construct(protected Spk $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['pengajuanServis.kendaraan', 'pengajuanServis.pengaju', 'creator'])->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_spk', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Spk
    {
        return $this->model->with([
            'pengajuanServis.kendaraan',
            'pengajuanServis.pengaju',
            'pengajuanServis.lampiran',
            'pengajuanServis.details.jenisPemeliharaan',
            'creator',
            'riwayatPemeliharaan.lampiran',
        ])->find($id);
    }

    public function create(array $data): Spk
    {
        return $this->model->create($data);
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countThisMonth(): int
    {
        return $this->model->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function generateNomorSpk(): string
    {
        $now = now();
        $prefix = 'SPK/' . $now->format('Y/m') . '/';
        $last = $this->model->where('nomor_spk', 'like', "{$prefix}%")
            ->orderByDesc('nomor_spk')
            ->first();

        $number = 1;
        if ($last) {
            $lastNumber = (int) substr($last->nomor_spk, -4);
            $number = $lastNumber + 1;
        }
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
