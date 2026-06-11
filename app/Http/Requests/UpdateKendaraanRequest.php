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
            'nomor_rangka' => 'required|string|max:50',
            'nomor_mesin' => 'required|string|max:50',
            'merk' => 'required|string|max:100',
            'tipe' => 'required|string|max:100',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'required|string|max:50',
            'tanggal_perolehan' => 'required|date',
            'status' => 'required|in:aktif,servis,rusak,nonaktif',
            'keterangan' => 'required|string|max:1000',
        ];
    }
}
