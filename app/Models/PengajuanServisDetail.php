<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanServisDetail extends Model
{
    protected $table = 'pengajuan_servis_detail';

    protected $fillable = [
        'pengajuan_servis_id',
        'jenis_pemeliharaan_id',
        'keterangan',
    ];

    public function pengajuanServis()
    {
        return $this->belongsTo(PengajuanServis::class);
    }

    public function jenisPemeliharaan()
    {
        return $this->belongsTo(MasterJenisPemeliharaan::class, 'jenis_pemeliharaan_id');
    }
}
