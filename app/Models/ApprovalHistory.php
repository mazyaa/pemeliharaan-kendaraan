<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    protected $table = 'approval_histories';

    protected $fillable = [
        'pengajuan_servis_id',
        'approver_id',
        'approval_level',
        'status',
        'notes',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'approval_level' => 'integer',
            'approved_at' => 'datetime',
        ];
    }

    public function pengajuanServis()
    {
        return $this->belongsTo(PengajuanServis::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
