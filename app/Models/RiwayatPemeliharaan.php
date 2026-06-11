<?php

namespace App\Models;

use App\Enums\RiwayatStatusEnum;
use Illuminate\Database\Eloquent\Model;

class RiwayatPemeliharaan extends Model
{
    protected $table = 'riwayat_pemeliharaan';

    protected $fillable = [
        'spk_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'nama_bengkel',
        'hasil_pemeliharaan',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_masuk' => 'date',
            'tanggal_selesai' => 'date',
            'status' => RiwayatStatusEnum::class,
        ];
    }

    public function spk()
    {
        return $this->belongsTo(Spk::class);
    }

    public function detailPemeliharaan()
    {
        return $this->hasMany(\App\Models\RiwayatPemeliharaanDetail::class);
    }

    public function lampiran()
    {
        return $this->hasMany(LampiranPemeliharaan::class);
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
