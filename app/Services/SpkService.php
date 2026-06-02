<?php

namespace App\Services;

use App\Enums\PengajuanStatusEnum;
use App\Models\Spk;
use App\Repositories\SpkRepository;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\WorkflowLogRepository;
use Illuminate\Support\Facades\DB;

class SpkService
{
    public function __construct(
        protected SpkRepository $spkRepo,
        protected PengajuanServisRepository $pengajuanRepo,
        protected WorkflowLogRepository $workflowRepo,
    ) {}

    public function paginated(array $filters = [], int $perPage = 10)
    {
        return $this->spkRepo->paginated($filters, $perPage);
    }

    public function find(int $id): ?Spk
    {
        return $this->spkRepo->find($id);
    }

    public function createFromPengajuan(int $pengajuanId, int $userId, string $keterangan = ''): ?Spk
    {
        return DB::transaction(function () use ($pengajuanId, $userId, $keterangan) {
            $pengajuan = $this->pengajuanRepo->find($pengajuanId);
            if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::APPROVED_PPTK) {
                return null;
            }

            $spk = $this->spkRepo->create([
                'pengajuan_servis_id' => $pengajuanId,
                'nomor_spk' => $this->spkRepo->generateNomorSpk(),
                'tanggal_spk' => now(),
                'created_by' => $userId,
                'keterangan' => $keterangan,
            ]);

            $oldStatus = $pengajuan->status->value;
            $this->pengajuanRepo->update($pengajuanId, [
                'status' => PengajuanStatusEnum::SPK_GENERATED,
            ]);

            $this->workflowRepo->create([
                'reference_type' => \App\Models\PengajuanServis::class,
                'reference_id' => $pengajuanId,
                'from_status' => $oldStatus,
                'to_status' => PengajuanStatusEnum::SPK_GENERATED->value,
                'changed_by' => $userId,
                'notes' => 'SPK diterbitkan: ' . $spk->nomor_spk,
            ]);

            return $spk;
        });
    }

    public function count(): int
    {
        return $this->spkRepo->count();
    }

    public function countThisMonth(): int
    {
        return $this->spkRepo->countThisMonth();
    }

    public function generateNomorSpk(): string
    {
        return $this->spkRepo->generateNomorSpk();
    }
}
