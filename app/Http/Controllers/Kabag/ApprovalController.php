<?php

namespace App\Http\Controllers\Kabag;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalRequest;
use App\Services\ApprovalService;
use App\Enums\PengajuanStatusEnum;

class ApprovalController extends Controller
{
    public function __construct(protected ApprovalService $service) {}

    public function index()
    {
        $pengajuan = $this->service->getPendingForKabag((int) request('perPage', 10));
        return view('kabag.approval.index', compact('pengajuan'));
    }

    public function history()
    {
        $filters = request()->only(['search', 'status']);
        $pengajuan = $this->service->getHistoryForKabag($filters, (int) request('perPage', 10));
        return view('kabag.approval.history', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = $this->service->find($id);
        return view('kabag.approval.show', compact('pengajuan'));
    }

    public function approve($id, ApprovalRequest $request)
    {
        $pengajuan = $this->service->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::SUBMITTED) {
            return redirect()->route('kabag.approval.index')->with('error', 'Pengajuan tidak dapat disetujui');
        }

        $this->service->approve($id, auth()->id(), $request->validated()['notes'] ?? '');
        return redirect()->route('kabag.approval.index')->with('success', 'Pengajuan berhasil disetujui');
    }

    public function reject($id, ApprovalRequest $request)
    {
        $pengajuan = $this->service->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::SUBMITTED) {
            return redirect()->route('kabag.approval.index')->with('error', 'Pengajuan tidak dapat ditolak');
        }

        $this->service->reject($id, auth()->id(), $request->validated()['notes'] ?? '');
        return redirect()->route('kabag.approval.index')->with('success', 'Pengajuan ditolak');
    }
}
