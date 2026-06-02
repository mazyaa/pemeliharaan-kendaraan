<?php

namespace App\Http\Controllers\Pptk;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiwayatRequest;
use App\Http\Requests\UpdateRiwayatRequest;
use App\Services\RiwayatPemeliharaanService;
use App\Services\SpkService;

class RiwayatController extends Controller
{
    public function __construct(
        protected RiwayatPemeliharaanService $service,
        protected SpkService $spkService
    ) {}

    public function index()
    {
        $filters = request()->only(['search', 'status', 'date_from', 'date_to']);
        $riwayat = $this->service->paginated($filters, 10);
        $spkList = $this->spkService->paginated([], 100);
        return view('pptk.riwayat.index', compact('riwayat', 'spkList'));
    }

    public function create()
    {
        $spkList = $this->spkService->paginated([], 100);
        return view('pptk.riwayat.create', compact('spkList'));
    }

    public function store(StoreRiwayatRequest $request)
    {
        $data = $request->validated();
        $files = $request->file('lampiran') ?? [];
        unset($data['lampiran']);
        $this->service->create($data, auth()->id(), $files);
        return redirect()->route('pptk.riwayat.index')->with('success', 'Riwayat pemeliharaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $riwayat = $this->service->find($id);
        return view('pptk.riwayat.show', compact('riwayat'));
    }

    public function edit($id)
    {
        $riwayat = $this->service->find($id);
        $spkList = $this->spkService->paginated([], 100);
        return view('pptk.riwayat.edit', compact('riwayat', 'spkList'));
    }

    public function update(UpdateRiwayatRequest $request, $id)
    {
        $data = $request->validated();
        $files = $request->file('lampiran') ?? [];
        unset($data['lampiran']);
        $this->service->update($id, $data, auth()->id(), $files);
        return redirect()->route('pptk.riwayat.index')->with('success', 'Riwayat pemeliharaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('pptk.riwayat.index')->with('success', 'Riwayat pemeliharaan berhasil dihapus');
    }
}