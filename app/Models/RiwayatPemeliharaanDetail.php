<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPemeliharaanDetail extends Model
{
    protected $table = 'riwayat_pemeliharaan_detail';

    protected $fillable = [
        'riwayat_pemeliharaan_id',
        'jenis_pemeliharaan_id',
    ];

    public function riwayatPemeliharaan()
    {
        return $this->belongsTo(RiwayatPemeliharaan::class);
    }

    public function jenisPemeliharaan()
    {
        return $this->belongsTo(MasterJenisPemeliharaan::class, 'jenis_pemeliharaan_id');
    }
}
