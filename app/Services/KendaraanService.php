<?php

namespace App\Services;

use App\Repositories\KendaraanRepository;
use App\Models\Kendaraan;

class KendaraanService
{
    public function __construct(protected KendaraanRepository $repo) {}

    public function paginated(array $filters = [], int $perPage = 10)
    {
        return $this->repo->paginated($filters, $perPage);
    }

    public function find(int $id): ?Kendaraan
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Kendaraan
    {
        if (empty($data['kode_kendaraan'])) {
            $data['kode_kendaraan'] = $this->repo->generateKodeKendaraan();
        }
        return $this->repo->create($data);
    }

    public function update(int $id, array $data): ?Kendaraan
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }

    public function count(): int
    {
        return $this->repo->count();
    }

    public function countByStatus(string $status): int
    {
        return $this->repo->countByStatus($status);
    }

    public function getActive()
    {
        return $this->repo->getActive();
    }

    public function generateKodeKendaraan(): string
    {
        return $this->repo->generateKodeKendaraan();
    }
}
