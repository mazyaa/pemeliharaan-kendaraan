<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\RoleService;

class RoleController extends Controller
{
    public function __construct(protected RoleService $service) {}

    public function index()
    {
        $roles = $this->service->all();
        return view('admin.roles.index', compact('roles'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.roles.index')->with('success', 'Role berhasil dihapus');
    }
}