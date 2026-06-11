<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lampiranRule = $this->isMethod('post') ? 'required|array|min:1|max:5' : 'nullable|array|max:5';

        return [
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal_pengajuan' => 'required|date',
            'jenis_pemeliharaan_ids' => 'required|array|min:1',
            'jenis_pemeliharaan_ids.*' => 'exists:master_jenis_pemeliharaan,id',
            'lampiran' => $lampiranRule,
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }
}
