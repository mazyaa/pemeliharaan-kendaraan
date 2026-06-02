<?php

namespace App\Policies;

use App\Models\User;

class RiwayatPemeliharaanPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isPptk();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin() || $user->isPptk();
    }
}
