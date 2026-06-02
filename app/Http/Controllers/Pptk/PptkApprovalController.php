<?php

namespace App\Http\Controllers\Pptk;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalRequest;
use App\Services\ApprovalService;
use App\Services\SpkService;
use App\Enums\PengajuanStatusEnum;

class PptkApprovalController extends Controller
{
    public function __construct(
        protected ApprovalService $approvalService,
        protected SpkService $spkService
    ) {}

    public function index()
    {
        $pengajuan = $this->approvalService->getPendingForPptk();
        return view('pptk.approval.index', compact('pengajuan'));
    }

    public function history()
    {
        $filters = request()->only(['search', 'status']);
        $pengajuan = $this->approvalService->getHistoryForPptk($filters);
        return view('pptk.approval.history', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = $this->approvalService->find($id);
        return view('pptk.approval.show', compact('pengajuan'));
    }

    public function approve($id, ApprovalRequest $request)
    {
        $pengajuan = $this->approvalService->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DISPOSED_BIRO) {
            return redirect()->route('pptk.approval.index')->with('error', 'Pengajuan tidak dapat disetujui');
        }

        $this->approvalService->approve($id, auth()->id(), $request->validated()['notes'] ?? '');

        $spk = $this->spkService->createFromPengajuan($id, auth()->id());
        if ($spk) {
            return redirect()->route('pptk.spk.show', $spk->id)->with('success', 'Pengajuan disetujui dan SPK berhasil diterbitkan');
        }

        return redirect()->route('pptk.approval.index')->with('error', 'Pengajuan disetujui tetapi gagal menerbitkan SPK');
    }

    public function reject($id, ApprovalRequest $request)
    {
        $pengajuan = $this->approvalService->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DISPOSED_BIRO) {
            return redirect()->route('pptk.approval.index')->with('error', 'Pengajuan tidak dapat ditolak');
        }

        $this->approvalService->reject($id, auth()->id(), $request->validated()['notes'] ?? '');
        return redirect()->route('pptk.approval.index')->with('success', 'Pengajuan ditolak');
    }

    public function generateSpk($id)
    {
        $pengajuan = $this->approvalService->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::APPROVED_PPTK) {
            return redirect()->route('pptk.approval.index')->with('error', 'SPK tidak dapat diterbitkan');
        }

        $spk = $this->spkService->createFromPengajuan($id, auth()->id());
        if ($spk) {
            return redirect()->route('pptk.spk.show', $spk->id)->with('success', 'SPK berhasil diterbitkan');
        }
        return back()->with('error', 'Gagal menerbitkan SPK');
    }
}
