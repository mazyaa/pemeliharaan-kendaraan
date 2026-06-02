<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PengajuanServis;

class PengajuanServisPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, PengajuanServis $pengajuanServis): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isPengelola() && $pengajuanServis->pengaju_id === $user->id) return true;
        if ($user->isKabag() || $user->isKabiro() || $user->isPptk()) return true;
        return false;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPengelola();
    }

    public function update(User $user, PengajuanServis $pengajuanServis): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isPengelola() && $pengajuanServis->pengaju_id === $user->id) {
            return $pengajuanServis->status->value === 'draft';
        }
        return false;
    }

    public function delete(User $user, PengajuanServis $pengajuanServis): bool
    {
        if ($user->isAdmin()) return true;
        if ($user->isPengelola() && $pengajuanServis->pengaju_id === $user->id) {
            return $pengajuanServis->status->value === 'draft';
        }
        return false;
    }

    public function approve(User $user): bool
    {
        return $user->isKabag() || $user->isKabiro() || $user->isPptk();
    }
}
