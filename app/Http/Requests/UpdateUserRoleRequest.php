<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // sudah difilter auth + admin di middleware, di sini true saja
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'roles'   => ['nullable','array'],
            'roles.*' => ['in:admin,partner'], // role yang diizinkan
        ];
    }
}
