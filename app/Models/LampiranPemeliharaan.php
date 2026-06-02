<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranPemeliharaan extends Model
{
    protected $table = 'lampiran_pemeliharaan';

    protected $fillable = [
        'riwayat_pemeliharaan_id',
        'file_name',
        'file_path',
    ];

    public function riwayatPemeliharaan()
    {
        return $this->belongsTo(RiwayatPemeliharaan::class);
    }
}
