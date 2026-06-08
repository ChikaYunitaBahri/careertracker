<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->applicationNote->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'note_type'        => ['required', 'in:hr_interview,user_interview,psikotest,general'],
            'interview_date'   => ['nullable', 'date'],
            'interviewer_name' => ['nullable', 'string', 'max:255'],
            'content'          => ['required', 'string'],
            'impression'       => ['nullable', 'string'],
        ];
    }
}
