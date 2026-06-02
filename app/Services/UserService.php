<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    public function __construct(protected UserRepository $repo) {}

    public function paginated(array $filters = [], int $perPage = 10)
    {
        return $this->repo->paginated($filters, $perPage);
    }

    public function find(int $id): ?User
    {
        return $this->repo->find($id);
    }

    public function create(array $data): User
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data): ?User
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }

    public function getActiveUsers()
    {
        return $this->repo->getActiveUsers();
    }

    public function getByRole(string $roleName)
    {
        return $this->repo->getByRole($roleName);
    }
}
