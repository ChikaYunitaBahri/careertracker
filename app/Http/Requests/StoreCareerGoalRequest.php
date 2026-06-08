<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCareerGoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->careerGoal->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'                    => ['required', 'string', 'max:255'],
            'job_type'                 => ['nullable', 'in:full_time,part_time,internship,contract,freelance'],
            'target_industries'        => ['nullable', 'array'],
            'target_industries.*'      => ['string', 'max:100'],
            'target_cities'            => ['nullable', 'array'],
            'target_cities.*'          => ['string', 'max:100'],
            'target_application_count' => ['required', 'integer', 'min:1'],
            'target_salary_min'        => ['nullable', 'integer', 'min:0'],
            'deadline'                 => ['nullable', 'date', 'after:today'],
            'notes'                    => ['nullable', 'string'],
        ];
    }
}
