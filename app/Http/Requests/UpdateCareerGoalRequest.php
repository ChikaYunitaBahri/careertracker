<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->careerGoal->user_id === $this->user()->id;;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'                    => ['sometimes', 'required', 'string', 'max:255'],
            'job_type'                 => ['sometimes', 'nullable', 'in:full_time,part_time,internship,contract,freelance'],
            'target_industries'        => ['sometimes', 'nullable', 'array'],
            'target_industries.*'      => ['string', 'max:100'],
            'target_cities'            => ['sometimes', 'nullable', 'array'],
            'target_cities.*'          => ['string', 'max:100'],
            'target_application_count' => ['sometimes', 'required', 'integer', 'min:1', 'max:9999'],
            'target_salary_min'        => ['sometimes', 'nullable', 'integer', 'min:0'],
            'deadline'                 => ['sometimes', 'nullable', 'date', 'after:today'],
            'notes'                    => ['sometimes', 'nullable', 'string'],
            'status'                   => ['sometimes', 'required', 'in:active,achieved,archived'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required'                    => 'Judul goal wajib diisi.',
            'title.max'                         => 'Judul goal maksimal 255 karakter.',
            'job_type.in'                       => 'Tipe pekerjaan tidak valid. Pilih: full_time, part_time, internship, contract, atau freelance.',
            'target_industries.array'           => 'Target industri harus berupa array.',
            'target_industries.*.string'        => 'Setiap industri harus berupa teks.',
            'target_cities.array'               => 'Target kota harus berupa array.',
            'target_cities.*.string'            => 'Setiap kota harus berupa teks.',
            'target_application_count.required' => 'Target jumlah lamaran wajib diisi.',
            'target_application_count.integer'  => 'Target jumlah lamaran harus berupa angka.',
            'target_application_count.min'      => 'Target jumlah lamaran minimal 1.',
            'target_application_count.max'      => 'Target jumlah lamaran maksimal 9999.',
            'target_salary_min.integer'         => 'Target gaji minimum harus berupa angka.',
            'target_salary_min.min'             => 'Target gaji minimum tidak boleh negatif.',
            'deadline.date'                     => 'Format deadline tidak valid.',
            'deadline.after'                    => 'Deadline harus setelah hari ini.',
            'status.required'                   => 'Status goal wajib diisi.',
            'status.in'                         => 'Status goal tidak valid. Pilih: active, achieved, atau archived.',
        ];
    }
}
