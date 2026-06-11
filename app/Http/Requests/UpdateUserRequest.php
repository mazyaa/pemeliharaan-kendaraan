<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
            'nip' => 'required|string|min:5|max:30',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:8|confirmed',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_active' => 'boolean',
        ];
    }
}
