<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->applicationDocument->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'document_type' => ['required', 'in:cv,cover_letter,portfolio,other'],
            'file'          => [
                'required',
                'file',
                'max:10240',      // maksimum 10MB
                'mimes:pdf,doc,docx,jpg,jpeg,png',
            ],
        ];
    }
}
