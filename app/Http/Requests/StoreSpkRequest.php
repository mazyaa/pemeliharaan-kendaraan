<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pengajuan_servis_id' => 'required|exists:pengajuan_servis,id',
            'keterangan' => 'nullable|string|max:2000',
        ];
    }
}
