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
        return [
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal_pengajuan' => 'required|date',
            'keluhan' => 'required|string|max:2000',
            'lampiran' => 'nullable|array|max:5',
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }
}
