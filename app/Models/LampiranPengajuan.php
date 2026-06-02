<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LampiranPengajuan extends Model
{
    protected $table = 'lampiran_pengajuan';

    protected $fillable = [
        'pengajuan_servis_id',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
    }

    public function pengajuanServis()
    {
        return $this->belongsTo(PengajuanServis::class);
    }
}
