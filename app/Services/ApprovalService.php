<?php

namespace App\Services;

use App\Enums\ApprovalLevelEnum;
use App\Enums\ApprovalStatusEnum;
use App\Enums\PengajuanStatusEnum;
use App\Models\PengajuanServis;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\ApprovalHistoryRepository;
use App\Repositories\WorkflowLogRepository;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    public function __construct(
        protected PengajuanServisRepository $pengajuanRepo,
        protected ApprovalHistoryRepository $approvalRepo,
        protected WorkflowLogRepository $workflowRepo,
    ) {}

    public function find(int $id): ?PengajuanServis
    {
        return $this->pengajuanRepo->find($id);
    }

    public function approve(int $pengajuanId, int $approverId, string $notes = ''): ?PengajuanServis
    {
        return DB::transaction(function () use ($pengajuanId, $approverId, $notes) {
            $pengajuan = $this->pengajuanRepo->find($pengajuanId);
            if (!$pengajuan) return null;

            $currentStatus = $pengajuan->status;
            $oldStatus = $currentStatus->value;

            $newStatus = match ($currentStatus) {
                PengajuanStatusEnum::SUBMITTED => PengajuanStatusEnum::APPROVED_KABAG,
                PengajuanStatusEnum::APPROVED_KABAG => PengajuanStatusEnum::DISPOSED_BIRO,
                PengajuanStatusEnum::DISPOSED_BIRO => PengajuanStatusEnum::APPROVED_PPTK,
                default => null,
            };

            if (!$newStatus) return null;

            $approvalLevel = match ($currentStatus) {
                PengajuanStatusEnum::SUBMITTED => ApprovalLevelEnum::KEPALA_BAGIAN,
                PengajuanStatusEnum::APPROVED_KABAG => ApprovalLevelEnum::KEPALA_BIRO,
                PengajuanStatusEnum::DISPOSED_BIRO => ApprovalLevelEnum::PPTK,
                default => null,
            };

            $pengajuan = $this->pengajuanRepo->update($pengajuanId, [
                'status' => $newStatus,
            ]);

            $this->approvalRepo->create([
                'pengajuan_servis_id' => $pengajuanId,
                'approver_id' => $approverId,
                'approval_level' => $approvalLevel->value,
                'status' => ApprovalStatusEnum::APPROVED->value,
                'notes' => $notes,
                'approved_at' => now(),
            ]);

            $this->workflowRepo->create([
                'reference_type' => PengajuanServis::class,
                'reference_id' => $pengajuanId,
                'from_status' => $oldStatus,
                'to_status' => $newStatus->value,
                'changed_by' => $approverId,
                'notes' => $notes ?: 'Disetujui',
            ]);

            return $pengajuan;
        });
    }

    public function reject(int $pengajuanId, int $approverId, string $notes = ''): ?PengajuanServis
    {
        return DB::transaction(function () use ($pengajuanId, $approverId, $notes) {
            $pengajuan = $this->pengajuanRepo->find($pengajuanId);
            if (!$pengajuan) return null;

            $currentStatus = $pengajuan->status;
            $oldStatus = $currentStatus->value;

            $newStatus = match ($currentStatus) {
                PengajuanStatusEnum::SUBMITTED => PengajuanStatusEnum::REJECTED_KABAG,
                PengajuanStatusEnum::APPROVED_KABAG => PengajuanStatusEnum::REJECTED_BIRO,
                PengajuanStatusEnum::DISPOSED_BIRO => PengajuanStatusEnum::REJECTED_PPTK,
                default => null,
            };

            if (!$newStatus) return null;

            $approvalLevel = match ($currentStatus) {
                PengajuanStatusEnum::SUBMITTED => ApprovalLevelEnum::KEPALA_BAGIAN,
                PengajuanStatusEnum::APPROVED_KABAG => ApprovalLevelEnum::KEPALA_BIRO,
                PengajuanStatusEnum::DISPOSED_BIRO => ApprovalLevelEnum::PPTK,
                default => null,
            };

            $pengajuan = $this->pengajuanRepo->update($pengajuanId, [
                'status' => $newStatus,
            ]);

            $this->approvalRepo->create([
                'pengajuan_servis_id' => $pengajuanId,
                'approver_id' => $approverId,
                'approval_level' => $approvalLevel->value,
                'status' => ApprovalStatusEnum::REJECTED->value,
                'notes' => $notes,
                'approved_at' => now(),
            ]);

            $this->workflowRepo->create([
                'reference_type' => PengajuanServis::class,
                'reference_id' => $pengajuanId,
                'from_status' => $oldStatus,
                'to_status' => $newStatus->value,
                'changed_by' => $approverId,
                'notes' => $notes ?: 'Ditolak',
            ]);

            return $pengajuan;
        });
    }

    public function dispose(int $pengajuanId, int $approverId, string $notes = ''): ?PengajuanServis
    {
        return $this->approve($pengajuanId, $approverId, $notes);
    }

    public function getPendingForKabag()
    {
        return $this->pengajuanRepo->getPendingApproval(PengajuanStatusEnum::SUBMITTED->value);
    }

    public function getHistoryForKabag(array $filters = [])
    {
        return $this->pengajuanRepo->getByStatuses(
            [
                PengajuanStatusEnum::APPROVED_KABAG->value,
                PengajuanStatusEnum::REJECTED_KABAG->value,
                PengajuanStatusEnum::DISPOSED_BIRO->value,
                PengajuanStatusEnum::REJECTED_BIRO->value,
                PengajuanStatusEnum::APPROVED_PPTK->value,
                PengajuanStatusEnum::REJECTED_PPTK->value,
                PengajuanStatusEnum::SPK_GENERATED->value,
                PengajuanStatusEnum::COMPLETED->value,
            ],
            $filters
        );
    }

    public function getPendingForKabiro()
    {
        return $this->pengajuanRepo->getPendingApproval(PengajuanStatusEnum::APPROVED_KABAG->value);
    }

    public function getPendingForPptk()
    {
        return $this->pengajuanRepo->getPendingApproval(PengajuanStatusEnum::DISPOSED_BIRO->value);
    }

    public function getHistoryForKabiro(array $filters = [])
    {
        return $this->pengajuanRepo->getByStatuses(
            [
                PengajuanStatusEnum::DISPOSED_BIRO->value,
                PengajuanStatusEnum::REJECTED_BIRO->value,
                PengajuanStatusEnum::APPROVED_PPTK->value,
                PengajuanStatusEnum::REJECTED_PPTK->value,
                PengajuanStatusEnum::SPK_GENERATED->value,
                PengajuanStatusEnum::COMPLETED->value,
            ],
            $filters
        );
    }

    public function getHistoryForPptk(array $filters = [])
    {
        return $this->pengajuanRepo->getByStatuses(
            [
                PengajuanStatusEnum::APPROVED_PPTK->value,
                PengajuanStatusEnum::REJECTED_PPTK->value,
                PengajuanStatusEnum::SPK_GENERATED->value,
                PengajuanStatusEnum::COMPLETED->value,
            ],
            $filters
        );
    }
}
