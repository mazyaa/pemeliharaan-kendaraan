<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJenisPemeliharaan extends Model
{
    use SoftDeletes;

    protected $table = 'master_jenis_pemeliharaan';

    protected $fillable = [
        'kategori',
        'nama',
        'interval_hari',
        'deskripsi',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'interval_hari' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
