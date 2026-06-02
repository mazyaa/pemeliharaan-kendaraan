<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKendaraanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_kendaraan' => 'nullable|string|max:20|unique:kendaraan,kode_kendaraan,' . $this->route('kendaraan'),
            'plat_nomor' => 'required|string|max:20',
            'nomor_rangka' => 'nullable|string|max:50',
            'nomor_mesin' => 'nullable|string|max:50',
            'merk' => 'required|string|max:100',
            'tipe' => 'nullable|string|max:100',
            'tahun' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'nullable|string|max:50',
            'tanggal_perolehan' => 'nullable|date',
            'status' => 'required|in:aktif,servis,rusak,nonaktif',
            'keterangan' => 'nullable|string|max:1000',
        ];
    }
}
