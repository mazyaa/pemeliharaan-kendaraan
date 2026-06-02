<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Services\RoleService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
        protected RoleService $roleService
    ) {}

    public function index()
    {
        $filters = request()->only(['search', 'role_id', 'is_active']);
        $users = $this->service->paginated($filters, 10);
        $roles = $this->roleService->all();
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        if (empty($data['is_active'])) $data['is_active'] = false;
        $this->service->create($data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        if (empty($data['password'])) unset($data['password']);
        if (!isset($data['is_active'])) $data['is_active'] = false;
        $this->service->update($id, $data);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}