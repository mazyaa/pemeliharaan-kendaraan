<?php

namespace App\Http\Controllers\Pptk;

use App\Http\Controllers\Controller;
use App\Services\SpkService;
use App\Services\PDFService;
use App\Repositories\PengajuanServisRepository;
use App\Enums\PengajuanStatusEnum;

class SpkController extends Controller
{
    public function __construct(
        protected SpkService $service,
        protected PDFService $pdfService,
        protected PengajuanServisRepository $pengajuanRepo
    ) {}

    public function index()
    {
        $filters = request()->only(['search']);
        $spk = $this->service->paginated($filters, (int) request('perPage', 10));
        $pendingPengajuan = $this->pengajuanRepo->getPendingForSpk();
        return view('pptk.spk.index', compact('spk', 'pendingPengajuan'));
    }

    public function show($id)
    {
        $spk = $this->service->find($id);
        return view('pptk.spk.show', compact('spk'));
    }

    public function preview($id)
    {
        $spk = $this->service->find($id);
        $pdf = $this->pdfService->generateSpkPdf($spk);
        $filename = 'spk-' . str_replace('/', '-', $spk->nomor_spk) . '.pdf';
        return $pdf->stream($filename);
    }

    public function download($id)
    {
        $spk = $this->service->find($id);
        $pdf = $this->pdfService->generateSpkPdf($spk);
        $filename = 'spk-' . str_replace('/', '-', $spk->nomor_spk) . '.pdf';
        return $pdf->download($filename);
    }

    public function generate($id)
    {
        $pengajuan = $this->pengajuanRepo->find($id);
        if (!$pengajuan || $pengajuan->status !== PengajuanStatusEnum::DISPOSED_BIRO) {
            return redirect()->route('pptk.spk.index')->with('error', 'SPK tidak dapat diterbitkan untuk pengajuan ini');
        }

        if ($pengajuan->spk) {
            return redirect()->route('pptk.spk.index')->with('error', 'SPK sudah pernah diterbitkan untuk pengajuan ini');
        }

        $spk = $this->service->createFromPengajuan($id, auth()->id());
        if ($spk) {
            return redirect()->route('pptk.spk.show', $spk->id)->with('success', 'SPK berhasil diterbitkan');
        }
        return redirect()->route('pptk.spk.index')->with('error', 'Gagal menerbitkan SPK');
    }
}