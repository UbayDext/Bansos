<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'title'         => ['required', 'string', 'max:255'],
        'description'   => ['required', 'string'],
        'target_amount' => ['required', 'integer', 'min:0'],
        'img'           => ['required', 'image', 'max:2048'],
        'collected_amount' => ['nullable', 'integer', 'min:0', 'lte:target_amount'],
         'status'        => ['nullable', 'in:draft,active,closed'],
        // ini yang sering lupa:
        'start_date'    => ['nullable', 'date'],
        'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],
    ];
}

}
