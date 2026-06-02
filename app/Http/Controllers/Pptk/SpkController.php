<?php

namespace App\Http\Controllers\Pptk;

use App\Http\Controllers\Controller;
use App\Services\SpkService;
use App\Services\PDFService;

class SpkController extends Controller
{
    public function __construct(
        protected SpkService $service,
        protected PDFService $pdfService
    ) {}

    public function index()
    {
        $filters = request()->only(['search']);
        $spk = $this->service->paginated($filters, 10);
        return view('pptk.spk.index', compact('spk'));
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
}