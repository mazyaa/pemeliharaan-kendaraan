<?php

namespace App\Repositories;

use App\Enums\KendaraanStatusEnum;
use App\Models\Kendaraan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class KendaraanRepository
{
    public function __construct(protected Kendaraan $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('kode_kendaraan', 'like', "%{$search}%")
                  ->orWhere('plat_nomor', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['merk'])) {
            $query->where('merk', $filters['merk']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?Kendaraan
    {
        return $this->model->find($id);
    }

    public function create(array $data): Kendaraan
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?Kendaraan
    {
        $kendaraan = $this->find($id);
        if ($kendaraan) {
            $kendaraan->update($data);
        }
        return $kendaraan;
    }

    public function delete(int $id): bool
    {
        $kendaraan = $this->find($id);
        return $kendaraan ? $kendaraan->delete() : false;
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countByStatus(string $status): int
    {
        return $this->model->where('status', $status)->count();
    }

    public function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('status', KendaraanStatusEnum::AKTIF)->get();
    }

    public function generateKodeKendaraan(): string
    {
        $last = $this->model->orderByDesc('id')->first();
        $number = 1;
        if ($last) {
            $lastNumber = (int) substr($last->kode_kendaraan, 3);
            $number = $lastNumber + 1;
        }
        return 'KR-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}
