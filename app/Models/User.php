<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'role_id',
        'nip',
        'name',
        'email',
        'password',
        'position',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(string $role): bool
    {
        return $this->role?->name === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleEnum::ADMIN->value);
    }

    public function isPengaju(): bool
    {
        return $this->hasRole(RoleEnum::PENGAJU_KENDARAAN->value);
    }

    public function isKabag(): bool
    {
        return $this->hasRole(RoleEnum::KEPALA_BAGIAN->value);
    }

    public function isKabiro(): bool
    {
        return $this->hasRole(RoleEnum::KEPALA_BIRO->value);
    }

    public function isPptk(): bool
    {
        return $this->hasRole(RoleEnum::PPTK->value);
    }

    public function kendaraan()
    {
        return $this->hasOne(\App\Models\Kendaraan::class, 'pengaju_id');
    }

    public function pengajuanServis()
    {
        return $this->hasMany(PengajuanServis::class, 'pengaju_id');
    }

    public function approvals()
    {
        return $this->hasMany(ApprovalHistory::class, 'approver_id');
    }
}
