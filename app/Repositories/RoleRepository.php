<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository
{
    public function __construct(protected Role $model) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Role
    {
        return $this->model->find($id);
    }

    public function findByName(string $name): ?Role
    {
        return $this->model->where('name', $name)->first();
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): ?Role
    {
        $role = $this->find($id);
        if ($role) {
            $role->update($data);
        }
        return $role;
    }

    public function delete(int $id): bool
    {
        $role = $this->find($id);
        return $role ? $role->delete() : false;
    }
}
