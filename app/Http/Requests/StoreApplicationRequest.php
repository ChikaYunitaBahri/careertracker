<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->application->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id'         => ['nullable', 'exists:companies,id'],
            'status_id'          => ['required', 'exists:recruitment_statuses,id'],
            'position_name'      => ['required', 'string', 'max:255'],
            'company_name'       => ['required', 'string', 'max:255'],
            'applied_date'       => ['required', 'date'],
            'job_post_url'       => ['nullable', 'url', 'max:500'],
            'source'             => ['nullable', 'string', 'max:100'],
            'salary_min'         => ['nullable', 'integer', 'min:0'],
            'salary_max'         => ['nullable', 'integer', 'min:0', 'gte:salary_min'],
            'job_type'           => ['nullable', 'in:full_time,part_time,internship,contract,freelance'],
            'work_location_type' => ['nullable', 'in:onsite,remote,hybrid'],
            'location'           => ['nullable', 'string', 'max:255'],
            'referral_code'      => ['nullable', 'string', 'max:100'],
            'initial_notes'      => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'status_id.required' => 'Status rekrutmen wajib dipilih.',
            'position_name.required' => 'Nama posisi wajib diisi.',
            'company_name.required'  => 'Nama perusahaan wajib diisi.',
            'applied_date.required'  => 'Tanggal lamaran wajib diisi.',
            'salary_max.gte'         => 'Gaji maksimum harus lebih besar dari gaji minimum.',
        ];
    }
}
