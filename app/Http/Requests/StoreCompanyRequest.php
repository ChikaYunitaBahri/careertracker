<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * FIX: Sebelumnya: $this->company->user_id === $this->user()->id
     * yang error karena $this->company null saat CREATE (bukan update).
     * Untuk store, cukup pastikan user sudah login.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'industry'        => ['nullable', 'string', 'max:100'],
            'size'            => ['nullable', 'string', 'max:50'],
            'website'         => ['nullable', 'url', 'max:255'],
            'location'        => ['nullable', 'string', 'max:255'],
            'logo_url'        => ['nullable', 'url', 'max:255'],
            'personal_rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'description'     => ['nullable', 'string'],
            'culture_notes'   => ['nullable', 'string'],
            'benefits_notes'  => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama perusahaan wajib diisi.',
            'name.max'      => 'Nama perusahaan maksimal 255 karakter.',
            'website.url'   => 'Format website tidak valid (harus diawali https://).',
            'logo_url.url'  => 'Format URL logo tidak valid.',
        ];
    }
}