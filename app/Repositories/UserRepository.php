<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class UserRepository
{
    public function __construct(protected User $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('role')->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): ?User
    {
        return $this->model->with('role')->find($id);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        return $user ? $user->delete() : false;
    }

    public function getActiveUsers(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('is_active', true)->with('role')->get();
    }

    public function getByRole(string $roleName): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('is_active', true)
            ->whereHas('role', fn ($q) => $q->where('name', $roleName))
            ->get();
    }
}
