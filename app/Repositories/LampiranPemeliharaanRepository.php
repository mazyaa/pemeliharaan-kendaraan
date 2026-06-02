<?php

namespace App\Repositories;

use App\Models\LampiranPemeliharaan;

class LampiranPemeliharaanRepository
{
    public function __construct(protected LampiranPemeliharaan $model) {}

    public function create(array $data): LampiranPemeliharaan
    {
        return $this->model->create($data);
    }

    public function getByRiwayat(int $riwayatId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('riwayat_pemeliharaan_id', $riwayatId)->get();
    }

    public function delete(int $id): bool
    {
        $lampiran = $this->model->find($id);
        return $lampiran ? $lampiran->delete() : false;
    }
}
