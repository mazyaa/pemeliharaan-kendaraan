<?php

namespace App\Services;

use App\Enums\PengajuanStatusEnum;
use App\Enums\RiwayatStatusEnum;
use App\Models\RiwayatPemeliharaan;
use App\Repositories\RiwayatPemeliharaanRepository;
use App\Repositories\LampiranPemeliharaanRepository;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\WorkflowLogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RiwayatPemeliharaanService
{
    public function __construct(
        protected RiwayatPemeliharaanRepository $riwayatRepo,
        protected LampiranPemeliharaanRepository $lampiranRepo,
        protected PengajuanServisRepository $pengajuanRepo,
        protected WorkflowLogRepository $workflowRepo,
    ) {}

    public function paginated(array $filters = [], int $perPage = 10)
    {
        return $this->riwayatRepo->paginated($filters, $perPage);
    }

    public function find(int $id): ?RiwayatPemeliharaan
    {
        return $this->riwayatRepo->find($id);
    }

    public function create(array $data, int $userId, array $files = []): RiwayatPemeliharaan
    {
        return DB::transaction(function () use ($data, $userId, $files) {
            $riwayat = $this->riwayatRepo->create($data);

            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = $file->store('lampiran-pemeliharaan', 'public');
                    $this->lampiranRepo->create([
                        'riwayat_pemeliharaan_id' => $riwayat->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            if ($riwayat->status === RiwayatStatusEnum::SELESAI) {
                $this->completePengajuan($riwayat->spk->pengajuan_servis_id, $userId);
            }

            return $riwayat;
        });
    }

    public function update(int $id, array $data, int $userId, array $files = []): ?RiwayatPemeliharaan
    {
        return DB::transaction(function () use ($id, $data, $userId, $files) {
            $riwayat = $this->riwayatRepo->update($id, $data);

            if (!$riwayat) return null;

            if (!empty($files)) {
                foreach ($files as $file) {
                    $path = $file->store('lampiran-pemeliharaan', 'public');
                    $this->lampiranRepo->create([
                        'riwayat_pemeliharaan_id' => $riwayat->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_path' => $path,
                    ]);
                }
            }

            if ($riwayat->status === RiwayatStatusEnum::SELESAI) {
                $this->completePengajuan($riwayat->spk->pengajuan_servis_id, $userId);
            }

            return $riwayat;
        });
    }

    public function count(): int
    {
        return $this->riwayatRepo->count();
    }

    public function countSelesai(): int
    {
        return $this->riwayatRepo->countSelesai();
    }

    public function totalBiaya(): float
    {
        return $this->riwayatRepo->totalBiaya();
    }

    public function delete(int $id): bool
    {
        return $this->riwayatRepo->delete($id);
    }

    protected function completePengajuan(int $pengajuanId, int $userId): void
    {
        $pengajuan = $this->pengajuanRepo->find($pengajuanId);
        if ($pengajuan && $pengajuan->status === PengajuanStatusEnum::SPK_GENERATED) {
            $oldStatus = $pengajuan->status->value;
            $this->pengajuanRepo->update($pengajuanId, [
                'status' => PengajuanStatusEnum::COMPLETED,
            ]);

            $this->workflowRepo->create([
                'reference_type' => \App\Models\PengajuanServis::class,
                'reference_id' => $pengajuanId,
                'from_status' => $oldStatus,
                'to_status' => PengajuanStatusEnum::COMPLETED->value,
                'changed_by' => $userId,
                'notes' => 'Pemeliharaan selesai',
            ]);
        }
    }
}
