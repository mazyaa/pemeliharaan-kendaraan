<?php

namespace App\Repositories;

use App\Models\LampiranPengajuan;

class LampiranPengajuanRepository
{
    public function __construct(protected LampiranPengajuan $model) {}

    public function create(array $data): LampiranPengajuan
    {
        return $this->model->create($data);
    }

    public function getByPengajuan(int $pengajuanId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('pengajuan_servis_id', $pengajuanId)->get();
    }

    public function delete(int $id): bool
    {
        $lampiran = $this->model->find($id);
        return $lampiran ? $lampiran->delete() : false;
    }
}
