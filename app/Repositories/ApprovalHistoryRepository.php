<?php

namespace App\Repositories;

use App\Models\ApprovalHistory;

class ApprovalHistoryRepository
{
    public function __construct(protected ApprovalHistory $model) {}

    public function getByPengajuan(int $pengajuanId): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('approver')
            ->where('pengajuan_servis_id', $pengajuanId)
            ->latest()
            ->get();
    }

    public function create(array $data): ApprovalHistory
    {
        return $this->model->create($data);
    }
}
