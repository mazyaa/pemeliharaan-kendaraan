<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use App\Services\PDFService;

class LaporanController extends Controller
{
    public function __construct(
        protected LaporanService $service,
        protected PDFService $pdfService
    ) {}

    public function index()
    {
        $filters = request()->only(['search', 'status', 'date_from', 'date_to']);
        $laporan = $this->service->generate($filters);
        return view('laporan.index', $laporan);
    }

    public function exportPdf()
    {
        $filters = request()->only(['search', 'status', 'date_from', 'date_to']);
        $data = $this->service->generate($filters);
        $pdf = $this->pdfService->generateLaporanPdf($data);
        return $pdf->download('laporan-pemeliharaan-' . now()->format('Y-m-d') . '.pdf');
    }
}