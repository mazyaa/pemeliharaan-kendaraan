<?php

namespace App\Repositories;

use App\Models\WorkflowLog;

class WorkflowLogRepository
{
    public function __construct(protected WorkflowLog $model) {}

    public function create(array $data): WorkflowLog
    {
        return $this->model->create($data);
    }

    public function getByReference(string $type, int $id): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('changedByUser')
            ->where('reference_type', $type)
            ->where('reference_id', $id)
            ->latest()
            ->get();
    }
}
