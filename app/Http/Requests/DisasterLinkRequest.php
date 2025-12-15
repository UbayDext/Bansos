<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisasterLinkRequest extends FormRequest
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
            'platform'   => ['required','string','max:50'],
            'url'        => ['required','url','max:255'],
            'sort_order' => ['nullable','integer','min:0'],
        ];
    }
    public function prepareForValidation(): void
    {
        $this->merge([
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
