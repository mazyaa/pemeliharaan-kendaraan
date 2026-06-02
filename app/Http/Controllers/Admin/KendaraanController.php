<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKendaraanRequest;
use App\Http\Requests\UpdateKendaraanRequest;
use App\Services\KendaraanService;

class KendaraanController extends Controller
{
    public function __construct(protected KendaraanService $service) {}

    public function index()
    {
        $filters = request()->only(['search', 'status', 'merk']);
        $kendaraan = $this->service->paginated($filters, 10);
        return view('admin.kendaraan.index', compact('kendaraan'));
    }

    public function store(StoreKendaraanRequest $request)
    {
        $this->service->create($request->validated());
        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function update(UpdateKendaraanRequest $request, $id)
    {
        $this->service->update($id, $request->validated());
        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus');
    }
}