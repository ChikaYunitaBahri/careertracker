<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->company->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'            => ['sometimes', 'required', 'string', 'max:255'],
            'industry'        => ['sometimes', 'nullable', 'string', 'max:100'],
            'size'            => ['sometimes', 'nullable', 'in:startup,small,medium,large,corporate'],
            'website'         => ['sometimes', 'nullable', 'url', 'max:500'],
            'location'        => ['sometimes', 'nullable', 'string', 'max:255'],
            'logo_url'        => ['sometimes', 'nullable', 'url', 'max:500'],
            'description'     => ['sometimes', 'nullable', 'string'],
            'culture_notes'   => ['sometimes', 'nullable', 'string'],
            'benefits_notes'  => ['sometimes', 'nullable', 'string'],
            'personal_rating' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:5'],
            'tags'            => ['sometimes', 'nullable', 'array'],
            'tags.*'          => ['string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'Nama perusahaan wajib diisi.',
            'name.max'                 => 'Nama perusahaan maksimal 255 karakter.',
            'size.in'                  => 'Ukuran perusahaan tidak valid. Pilih: startup, small, medium, large, atau corporate.',
            'website.url'              => 'Format URL website tidak valid.',
            'logo_url.url'             => 'Format URL logo tidak valid.',
            'personal_rating.integer'  => 'Rating harus berupa angka.',
            'personal_rating.min'      => 'Rating minimal 1.',
            'personal_rating.max'      => 'Rating maksimal 5.',
            'tags.array'               => 'Tags harus berupa array.',
            'tags.*.string'            => 'Setiap tag harus berupa teks.',
        ];
    }
}
