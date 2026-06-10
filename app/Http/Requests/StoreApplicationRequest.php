<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'position_name'      => ['required', 'string', 'max:255'],
            'company_name'       => ['required', 'string', 'max:255'],
            'status_id'          => ['required', 'exists:recruitment_statuses,id'],
            'applied_date'       => ['required', 'date'],
            'job_type'           => ['nullable', 'in:full_time,part_time,internship,contract,freelance'],
            'work_location_type' => ['nullable', 'in:onsite,remote,hybrid'],
            'location'           => ['nullable', 'string', 'max:255'],
            'salary_min'         => ['nullable', 'integer', 'min:0'],
            'salary_max'         => ['nullable', 'integer', 'min:0', 'gte:salary_min'],
            'source'             => ['nullable', 'string', 'max:100'],
            'referral_code'      => ['nullable', 'string', 'max:100'],
            'job_post_url'       => ['nullable', 'url', 'max:500'],
            'initial_notes'      => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'position_name.required' => 'Nama posisi wajib diisi.',
            'company_name.required'  => 'Nama perusahaan wajib diisi.',
            'status_id.required'     => 'Status lamaran wajib dipilih.',
            'status_id.exists'       => 'Status yang dipilih tidak valid.',
            'applied_date.required'  => 'Tanggal melamar wajib diisi.',
            'applied_date.date'      => 'Format tanggal tidak valid.',
            'salary_max.gte'         => 'Gaji maksimum harus lebih besar atau sama dengan gaji minimum.',
            'job_post_url.url'       => 'Format URL tidak valid. Pastikan diawali dengan https://',
        ];
    }
}
