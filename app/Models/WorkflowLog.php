<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WorkflowLog extends Model
{
    protected $fillable = [
        'reference_type',
        'reference_id',
        'from_status',
        'to_status',
        'changed_by',
        'notes',
    ];

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
