<?php

namespace App\Repositories;

use App\Models\PengajuanServis;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PengajuanServisRepository
{
    public function __construct(protected PengajuanServis $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['kendaraan', 'pengaju', 'lampiran'])->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                    ->orWhereHas('kendaraan', function ($q) use ($search) {
                        $q->where('plat_nomor', 'like', "%{$search}%")
                            ->orWhere('merk', 'like', "%{$search}%")
                            ->orWhere('tipe', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['kendaraan_id'])) {
            $query->where('kendaraan_id', $filters['kendaraan_id']);
        }

        if (!empty($filters['pengaju_id'])) {
            $query->where('pengaju_id', $filters['pengaju_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->where('tanggal_pengajuan', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('tanggal_pengajuan', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?PengajuanServis
    {
        return $this->model->with(['kendaraan', 'pengaju', 'lampiran', 'approvalHistories.approver', 'spk', 'workflowLogs.changedByUser', 'details.jenisPemeliharaan'])->find($id);
    }

    public function create(array $data): PengajuanServis
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?PengajuanServis
    {
        $pengajuan = $this->find($id);
        if ($pengajuan) {
            $pengajuan->update($data);
        }
        return $pengajuan;
    }

    public function delete(int $id): bool
    {
        $pengajuan = $this->find($id);
        return $pengajuan ? $pengajuan->delete() : false;
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function countByStatus(string $status): int
    {
        return $this->model->where('status', $status)->count();
    }

    public function countThisMonth(): int
    {
        return $this->model->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    public function getPendingApproval(string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with(['kendaraan', 'pengaju'])
            ->where('status', $status)
            ->latest()
            ->paginate($perPage);
    }

    public function getPendingForSpk(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['kendaraan', 'pengaju'])
            ->where('status', \App\Enums\PengajuanStatusEnum::DISPOSED_BIRO)
            ->whereDoesntHave('spk')
            ->latest()
            ->get();
    }

    public function getByStatuses(array $statuses, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with(['kendaraan', 'pengaju', 'lampiran', 'approvalHistories.approver'])
            ->whereIn('status', $statuses)
            ->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('nomor_pengajuan', 'like', "%{$search}%")
                    ->orWhereHas('kendaraan', function ($q) use ($search) {
                        $q->where('plat_nomor', 'like', "%{$search}%")
                            ->orWhere('merk', 'like', "%{$search}%")
                            ->orWhere('tipe', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage);
    }

    public function generateNomorPengajuan(): string
    {
        $now = now();
        $prefix = 'PJ/' . $now->format('Y/m') . '/';
        $last = $this->model->withTrashed()->where('nomor_pengajuan', 'like', "{$prefix}%")
            ->orderByDesc('nomor_pengajuan')
            ->first();

        $number = 1;
        if ($last) {
            $lastNumber = (int) substr($last->nomor_pengajuan, -4);
            $number = $lastNumber + 1;
        }
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
