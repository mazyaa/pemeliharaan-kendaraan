<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengajuanRequest;
use App\Services\PengajuanServisService;
use App\Services\KendaraanService;

class PengajuanController extends Controller
{
    public function __construct(
        protected PengajuanServisService $service,
        protected KendaraanService $kendaraanService
    ) {}

    public function index()
    {
        $filters = request()->only(['search', 'status', 'kendaraan_id']);
        $filters['pengaju_id'] = auth()->id();
        $pengajuan = $this->service->paginated($filters, 10);
        $kendaraan = $this->kendaraanService->getActive();
        return view('pengelola.pengajuan.index', compact('pengajuan', 'kendaraan'));
    }

    public function create()
    {
        $kendaraan = $this->kendaraanService->getActive();
        return view('pengelola.pengajuan.create', compact('kendaraan'));
    }

    public function store(StorePengajuanRequest $request)
    {
        $data = $request->validated();
        $files = $request->file('lampiran') ?? [];
        $data['pengaju_id'] = auth()->id();
        unset($data['lampiran']);
        $this->service->create($data, $files);
        return redirect()->route('pengelola.pengajuan.index')->with('success', 'Pengajuan berhasil dibuat');
    }

    public function show($id)
    {
        $pengajuan = $this->service->find($id);
        return view('pengelola.pengajuan.show', compact('pengajuan'));
    }

    public function edit($id)
    {
        $pengajuan = $this->service->find($id);
        $kendaraan = $this->kendaraanService->getActive();
        return view('pengelola.pengajuan.edit', compact('pengajuan', 'kendaraan'));
    }

    public function update(StorePengajuanRequest $request, $id)
    {
        $data = $request->validated();
        $files = $request->file('lampiran') ?? [];
        unset($data['lampiran']);
        $this->service->update($id, $data, $files);
        return redirect()->route('pengelola.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('pengelola.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus');
    }

    public function submit($id)
    {
        $this->service->submit($id, auth()->id());
        return redirect()->route('pengelola.pengajuan.index')->with('success', 'Pengajuan berhasil disubmit');
    }
}