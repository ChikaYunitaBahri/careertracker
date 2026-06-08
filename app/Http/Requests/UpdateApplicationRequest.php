<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
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
            'company_id'         => ['sometimes', 'nullable', 'exists:companies,id'],
            'status_id'          => ['sometimes', 'required', 'exists:recruitment_statuses,id'],
            'position_name'      => ['sometimes', 'required', 'string', 'max:255'],
            'company_name'       => ['sometimes', 'required', 'string', 'max:255'],
            'applied_date'       => ['sometimes', 'required', 'date', 'before_or_equal:today'],
            'job_post_url'       => ['sometimes', 'nullable', 'url', 'max:500'],
            'source'             => ['sometimes', 'nullable', 'string', 'max:100'],
            'salary_min'         => ['sometimes', 'nullable', 'integer', 'min:0'],
            'salary_max'         => ['sometimes', 'nullable', 'integer', 'min:0', 'gte:salary_min'],
            'job_type'           => ['sometimes', 'nullable', 'in:full_time,part_time,internship,contract,freelance'],
            'work_location_type' => ['sometimes', 'nullable', 'in:onsite,remote,hybrid'],
            'location'           => ['sometimes', 'nullable', 'string', 'max:255'],
            'referral_code'      => ['sometimes', 'nullable', 'string', 'max:100'],
            'initial_notes'      => ['sometimes', 'nullable', 'string'],
            'is_archived'        => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.exists'          => 'Perusahaan yang dipilih tidak ditemukan.',
            'status_id.required'         => 'Status lamaran wajib diisi.',
            'status_id.exists'           => 'Status lamaran tidak valid.',
            'position_name.required'     => 'Nama posisi wajib diisi.',
            'position_name.max'          => 'Nama posisi maksimal 255 karakter.',
            'company_name.required'      => 'Nama perusahaan wajib diisi.',
            'applied_date.required'      => 'Tanggal melamar wajib diisi.',
            'applied_date.date'          => 'Format tanggal melamar tidak valid.',
            'applied_date.before_or_equal' => 'Tanggal melamar tidak boleh lebih dari hari ini.',
            'job_post_url.url'           => 'Format URL lowongan tidak valid.',
            'salary_min.integer'         => 'Gaji minimum harus berupa angka.',
            'salary_min.min'             => 'Gaji minimum tidak boleh negatif.',
            'salary_max.integer'         => 'Gaji maksimum harus berupa angka.',
            'salary_max.gte'             => 'Gaji maksimum harus lebih besar atau sama dengan gaji minimum.',
            'job_type.in'                => 'Tipe pekerjaan tidak valid. Pilih: full_time, part_time, internship, contract, atau freelance.',
            'work_location_type.in'      => 'Tipe lokasi kerja tidak valid. Pilih: onsite, remote, atau hybrid.',
            'is_archived.boolean'        => 'Nilai arsip harus true atau false.',
        ];
    }
}
