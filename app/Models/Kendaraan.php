<?php

namespace App\Models;

use App\Enums\KendaraanStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use SoftDeletes;

    protected $table = 'kendaraan';

    protected $fillable = [
        'kode_kendaraan',
        'plat_nomor',
        'nomor_rangka',
        'nomor_mesin',
        'merk',
        'tipe',
        'tahun',
        'warna',
        'tanggal_perolehan',
        'status',
        'keterangan',
        'pengaju_id',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'tanggal_perolehan' => 'date',
            'status' => KendaraanStatusEnum::class,
        ];
    }

    public function pengaju()
    {
        return $this->belongsTo(\App\Models\User::class, 'pengaju_id');
    }

    public function pengajuanServis()
    {
        return $this->hasMany(PengajuanServis::class);
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
