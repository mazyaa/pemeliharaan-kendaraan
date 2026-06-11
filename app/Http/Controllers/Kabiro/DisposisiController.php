<?php

namespace App\Http\Controllers\Kabiro;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalRequest;
use App\Services\ApprovalService;
use App\Enums\PengajuanStatusEnum;

class DisposisiController extends Controller
{
    public function __construct(protected ApprovalService $service) {}

    public function index()
    {
        $pengajuan = $this->service->getPendingForKabiro((int) request('perPage', 10));
        return view('kabiro.disposisi.index', compact('pengajuan'));
    }

    public function history()
    {
        $filters = request()->only(['search', 'status']);
        $pengajuan = $this->service->getHistoryForKabiro($filters, (int) request('perPage', 10));
        return view('kabiro.disposisi.history', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = $this->service->find($id);
        return view('kabiro.disposisi.show', compact('pengajuan'));
    }

    public function approve($id, ApprovalRequest $request)
    {
        $pengajuan = $this->service->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::APPROVED_KABAG) {
            return redirect()->route('kabiro.disposisi.index')->with('error', 'Pengajuan tidak dapat didisposisi');
        }

        $this->service->approve($id, auth()->id(), $request->validated()['notes'] ?? '');
        return redirect()->route('kabiro.disposisi.index')->with('success', 'Pengajuan berhasil didisposisi');
    }

    public function reject($id, ApprovalRequest $request)
    {
        $pengajuan = $this->service->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::APPROVED_KABAG) {
            return redirect()->route('kabiro.disposisi.index')->with('error', 'Pengajuan tidak dapat ditolak');
        }

        $this->service->reject($id, auth()->id(), $request->validated()['notes'] ?? '');
        return redirect()->route('kabiro.disposisi.index')->with('success', 'Pengajuan ditolak');
    }
}
