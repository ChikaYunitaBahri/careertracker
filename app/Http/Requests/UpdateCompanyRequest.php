<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * FIX: Pastikan company milik user yang login.
     * $this->route('company') mengambil model dari route binding.
     */
    public function authorize(): bool
    {
        $company = $this->route('company');

        // Jika company tidak ditemukan di route, tolak
        if (! $company) {
            return false;
        }

        // Pastikan user login & company milik user tersebut
        return $this->user() !== null
            && $company->user_id === $this->user()->id;
    }

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