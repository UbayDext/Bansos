<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

 public function rules(): array
{
    return [
        'title'         => ['required', 'string', 'max:255'],
        'description'   => ['required', 'string'],
        'target_amount' => ['required', 'integer', 'min:0'],
        'img'           => ['nullable', 'image', 'max:2048'],

        'start_date'    => ['nullable', 'date'],
        'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],

        // status boleh untuk admin (kamu sudah handle di controller)
        'status'        => ['nullable', 'in:draft,active,closed'],
        'collected_amount' => ['nullable', 'integer', 'min:0', 'lte:target_amount'],

    ];
}

}
