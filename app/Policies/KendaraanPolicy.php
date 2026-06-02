<?php

namespace App\Policies;

use App\Models\User;

class KendaraanPolicy
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
        return $user->isAdmin() || $user->isPengelola();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin() || $user->isPengelola();
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}
