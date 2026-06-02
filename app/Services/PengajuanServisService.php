<?php

namespace App\Services;

use App\Enums\PengajuanStatusEnum;
use App\Models\PengajuanServis;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\LampiranPengajuanRepository;
use App\Repositories\WorkflowLogRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengajuanServisService
{
    public function __construct(
        protected PengajuanServisRepository $pengajuanRepo,
        protected LampiranPengajuanRepository $lampiranRepo,
        protected WorkflowLogRepository $workflowRepo,
    ) {}

    public function paginated(array $filters = [], int $perPage = 10)
    {
        return $this->pengajuanRepo->paginated($filters, $perPage);
    }

    public function find(int $id): ?PengajuanServis
    {
        return $this->pengajuanRepo->find($id);
    }

    public function create(array $data, array $files = []): PengajuanServis
    {
        return DB::transaction(function () use ($data, $files) {
            $data['nomor_pengajuan'] = $this->pengajuanRepo->generateNomorPengajuan();
            $data['status'] = PengajuanStatusEnum::DRAFT;

            $pengajuan = $this->pengajuanRepo->create($data);

            if (!empty($files)) {
                $this->uploadLampiran($pengajuan, $files);
            }

            $this->workflowRepo->create([
                'reference_type' => PengajuanServis::class,
                'reference_id' => $pengajuan->id,
                'from_status' => null,
                'to_status' => PengajuanStatusEnum::DRAFT->value,
                'changed_by' => $data['pengaju_id'],
                'notes' => 'Pengajuan dibuat',
            ]);

            return $pengajuan;
        });
    }

    public function update(int $id, array $data, array $files = []): ?PengajuanServis
    {
        return DB::transaction(function () use ($id, $data, $files) {
            $pengajuan = $this->pengajuanRepo->find($id);

            if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DRAFT) {
                return null;
            }

            $pengajuan = $this->pengajuanRepo->update($id, $data);

            if (!empty($files) && $pengajuan) {
                $this->uploadLampiran($pengajuan, $files);
            }

            return $pengajuan;
        });
    }

    public function submit(int $pengajuanId, int $userId): ?PengajuanServis
    {
        return DB::transaction(function () use ($pengajuanId, $userId) {
            $pengajuan = $this->pengajuanRepo->find($pengajuanId);

            if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DRAFT) {
                return null;
            }

            $oldStatus = $pengajuan->status->value;
            $pengajuan = $this->pengajuanRepo->update($pengajuan->id, [
                'status' => PengajuanStatusEnum::SUBMITTED,
                'submitted_at' => now(),
            ]);

            $this->workflowRepo->create([
                'reference_type' => PengajuanServis::class,
                'reference_id' => $pengajuan->id,
                'from_status' => $oldStatus,
                'to_status' => PengajuanStatusEnum::SUBMITTED->value,
                'changed_by' => $userId,
                'notes' => 'Pengajuan disubmit untuk approval',
            ]);

            return $pengajuan;
        });
    }

    public function delete(int $id): bool
    {
        $pengajuan = $this->pengajuanRepo->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DRAFT) {
            return false;
        }

        if ($pengajuan->lampiran->isNotEmpty()) {
            foreach ($pengajuan->lampiran as $lampiran) {
                Storage::disk('public')->delete($lampiran->file_path);
            }
        }

        return $this->pengajuanRepo->delete($id);
    }

    public function count(): int
    {
        return $this->pengajuanRepo->count();
    }

    public function countThisMonth(): int
    {
        return $this->pengajuanRepo->countThisMonth();
    }

    protected function uploadLampiran(PengajuanServis $pengajuan, array $files): void
    {
        foreach ($files as $file) {
            $path = $file->store('lampiran-pengajuan', 'public');
            $this->lampiranRepo->create([
                'pengajuan_servis_id' => $pengajuan->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
        }
    }
}
