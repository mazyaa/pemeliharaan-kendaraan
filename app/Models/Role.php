<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function label(): string
    {
        return match ($this->name) {
            RoleEnum::ADMIN->value => RoleEnum::ADMIN->label(),
            RoleEnum::PENGAJU_KENDARAAN->value => RoleEnum::PENGAJU_KENDARAAN->label(),
            RoleEnum::KEPALA_BAGIAN->value => RoleEnum::KEPALA_BAGIAN->label(),
            RoleEnum::KEPALA_BIRO->value => RoleEnum::KEPALA_BIRO->label(),
            RoleEnum::PPTK->value => RoleEnum::PPTK->label(),
            default => $this->name,
        };
    }
}
