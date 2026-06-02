<?php

namespace App\Policies;

use App\Models\User;

class SPKPolicy
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
}
