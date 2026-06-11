<?php

namespace App\Models;

use App\Enums\PengajuanStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanServis extends Model
{
    use SoftDeletes;

    protected $table = 'pengajuan_servis';

    protected $fillable = [
        'nomor_pengajuan',
        'kendaraan_id',
        'pengaju_id',
        'tanggal_pengajuan',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'date',
            'submitted_at' => 'datetime',
            'status' => PengajuanStatusEnum::class,
        ];
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function pengaju()
    {
        return $this->belongsTo(User::class, 'pengaju_id');
    }

    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class);
    }

    public function details()
    {
        return $this->hasMany(\App\Models\PengajuanServisDetail::class);
    }

    public function lampiran()
    {
        return $this->hasMany(LampiranPengajuan::class);
    }

    public function spk()
    {
        return $this->hasOne(Spk::class);
    }

    public function workflowLogs()
    {
        return $this->morphMany(WorkflowLog::class, 'reference');
    }

    public function getLabelStatusAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }
}
