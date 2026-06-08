<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->companyContact->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'role'         => ['sometimes', 'nullable', 'string', 'max:100'],
            'email'        => ['sometimes', 'nullable', 'email', 'max:255'],
            'phone'        => ['sometimes', 'nullable', 'string', 'max:30'],
            'linkedin_url' => ['sometimes', 'nullable', 'url', 'max:500'],
            'notes'        => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama kontak wajib diisi.',
            'name.max'           => 'Nama kontak maksimal 255 karakter.',
            'role.max'           => 'Jabatan kontak maksimal 100 karakter.',
            'email.email'        => 'Format email tidak valid.',
            'email.max'          => 'Email maksimal 255 karakter.',
            'phone.max'          => 'Nomor telepon maksimal 30 karakter.',
            'linkedin_url.url'   => 'Format URL LinkedIn tidak valid.',
            'linkedin_url.max'   => 'URL LinkedIn maksimal 500 karakter.',
        ];
    }
}
