<?php

namespace App\Services;

use App\Enums\PengajuanStatusEnum;
use App\Models\MasterJenisPemeliharaan;
use App\Models\PengajuanServis;
use App\Models\PengajuanServisDetail;
use App\Repositories\PengajuanServisRepository;
use App\Repositories\LampiranPengajuanRepository;
use App\Repositories\WorkflowLogRepository;
use Carbon\Carbon;
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
            $kendaraanId = $data['kendaraan_id'];
            $jenisIds = $data['jenis_pemeliharaan_ids'] ?? [];
            unset($data['jenis_pemeliharaan_ids']);

            $this->validateInterval($kendaraanId, $jenisIds);

            $data['nomor_pengajuan'] = $this->pengajuanRepo->generateNomorPengajuan();
            $data['status'] = PengajuanStatusEnum::DRAFT;

            $pengajuan = $this->pengajuanRepo->create($data);

            foreach ($jenisIds as $jenisId) {
                PengajuanServisDetail::create([
                    'pengajuan_servis_id' => $pengajuan->id,
                    'jenis_pemeliharaan_id' => $jenisId,
                ]);
            }

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

            $kendaraanId = $data['kendaraan_id'] ?? $pengajuan->kendaraan_id;
            $jenisIds = $data['jenis_pemeliharaan_ids'] ?? [];
            unset($data['jenis_pemeliharaan_ids']);

            $this->validateInterval($kendaraanId, $jenisIds, $id);

            $pengajuan = $this->pengajuanRepo->update($id, $data);

            if ($pengajuan && !empty($jenisIds)) {
                $pengajuan->details()->delete();
                foreach ($jenisIds as $jenisId) {
                    PengajuanServisDetail::create([
                        'pengajuan_servis_id' => $pengajuan->id,
                        'jenis_pemeliharaan_id' => $jenisId,
                    ]);
                }
            }

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

    protected function validateInterval(int $kendaraanId, array $jenisIds, ?int $excludePengajuanId = null): void
    {
        $now = now();
        $blocked = [];

        foreach ($jenisIds as $jenisId) {
            $jenis = MasterJenisPemeliharaan::find($jenisId);
            if (!$jenis) continue;

            // Check against existing pengajuan (all statuses)
            $latestDetail = PengajuanServisDetail::where('jenis_pemeliharaan_id', $jenisId)
                ->whereHas('pengajuanServis', function ($q) use ($kendaraanId, $excludePengajuanId) {
                    $q->where('kendaraan_id', $kendaraanId)
                      ->when($excludePengajuanId, fn($q) => $q->where('id', '!=', $excludePengajuanId));
                })
                ->latest()
                ->first();

            if ($latestDetail) {
                $lastDate = $latestDetail->pengajuanServis->tanggal_pengajuan;
                $nextAvailable = $lastDate->copy()->addDays($jenis->interval_hari);
                if ($nextAvailable->gt($now)) {
                    $blocked[] = [
                        'nama' => $jenis->nama,
                        'next_date' => $nextAvailable->locale('id')->format('d F Y'),
                        'remaining_days' => $nextAvailable->diffInDays($now),
                        'interval_hari' => $jenis->interval_hari,
                    ];
                    continue;
                }
            }

            // Check against completed services (riwayat)
            $riwayatDetail = \App\Models\RiwayatPemeliharaanDetail::whereHas('riwayatPemeliharaan.spk.pengajuanServis', function ($q) use ($kendaraanId) {
                $q->where('kendaraan_id', $kendaraanId);
            })
            ->where('jenis_pemeliharaan_id', $jenisId)
            ->latest()
            ->first();

            if ($riwayatDetail && $riwayatDetail->riwayatPemeliharaan->tanggal_selesai) {
                $lastServiceDate = $riwayatDetail->riwayatPemeliharaan->tanggal_selesai;
                $nextAvailable = $lastServiceDate->copy()->addDays($jenis->interval_hari);
                if ($nextAvailable->gt($now)) {
                    $blocked[] = [
                        'nama' => $jenis->nama,
                        'next_date' => $nextAvailable->locale('id')->format('d F Y'),
                        'remaining_days' => $nextAvailable->diffInDays($now),
                        'interval_hari' => $jenis->interval_hari,
                    ];
                }
            }
        }

        if (!empty($blocked)) {
            $names = array_column($blocked, 'nama');
            $details = array_map(fn($b) => "Batas waktu {$b['nama']} adalah {$b['next_date']} (interval {$b['interval_hari']} hari)", $blocked);

            throw \Illuminate\Validation\ValidationException::withMessages([
                'jenis_pemeliharaan_ids' => 'Anda tidak bisa melakukan pengajuan ' . implode(' & ', $names) . '. ' . implode(', ', $details) . '.',
            ]);
        }
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
