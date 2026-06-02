<?php

namespace App\Services;

use App\Models\Spk;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFService
{
    public function generateSpkPdf(Spk $spk)
    {
        $pdf = Pdf::loadView('pdf.spk', [
            'spk' => $spk,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    public function generateLaporanPdf(array $data)
    {
        $pdf = Pdf::loadView('pdf.laporan', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf;
    }
}
