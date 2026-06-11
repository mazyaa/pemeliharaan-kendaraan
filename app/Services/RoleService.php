<?php

namespace App\Services;

use App\Repositories\RoleRepository;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleService
{
    public function __construct(protected RoleRepository $repo) {}

    public function paginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repo->paginated($filters, $perPage);
    }

    public function all()
    {
        return $this->repo->all();
    }

    public function find(int $id): ?Role
    {
        return $this->repo->find($id);
    }

    public function create(array $data): Role
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data): ?Role
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }
}
