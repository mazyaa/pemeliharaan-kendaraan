<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRiwayatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'spk_id' => 'required|exists:spk,id',
            'tanggal_masuk' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_masuk',
            'nama_bengkel' => 'required|string|max:255',
            'hasil_pemeliharaan' => 'required|string|max:2000',
            'status' => 'required|in:diproses,selesai,ditunda',
            'catatan' => 'nullable|string|max:2000',
            'lampiran' => 'nullable|array|max:5',
            'lampiran.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ];
    }
}
