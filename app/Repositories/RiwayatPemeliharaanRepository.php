<?php

namespace App\Repositories;

use App\Models\RiwayatPemeliharaan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class RiwayatPemeliharaanRepository
{
    public function __construct(protected RiwayatPemeliharaan $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['spk.pengajuanServis.kendaraan', 'lampiran'])->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nama_bengkel', 'like', "%{$search}%")
                  ->orWhere('hasil_pemeliharaan', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('tanggal_masuk', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('tanggal_masuk', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?RiwayatPemeliharaan
    {
        return $this->model->with([
            'spk.pengajuanServis.kendaraan',
            'spk.pengajuanServis.pengaju',
            'spk.creator',
            'lampiran',
        ])->find($id);
    }

    public function create(array $data): RiwayatPemeliharaan
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?RiwayatPemeliharaan
    {
        $riwayat = $this->find($id);
        if ($riwayat) {
            $riwayat->update($data);
        }
        return $riwayat;
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countSelesai(): int
    {
        return $this->model->where('status', 'selesai')->count();
    }

    public function totalBiaya(): float
    {
        return (float) $this->model->sum('biaya');
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->where('id', $id)->delete();
    }

    public function getByDateRange(string $from, string $to): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['spk.pengajuanServis.kendaraan'])
            ->whereBetween('tanggal_masuk', [$from, $to])
            ->get();
    }
}
