<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    protected $table = 'spk';

    protected $fillable = [
        'pengajuan_servis_id',
        'nomor_spk',
        'tanggal_spk',
        'created_by',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_spk' => 'date',
        ];
    }

    public function pengajuanServis()
    {
        return $this->belongsTo(PengajuanServis::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function riwayatPemeliharaan()
    {
        return $this->hasOne(RiwayatPemeliharaan::class);
    }
}
