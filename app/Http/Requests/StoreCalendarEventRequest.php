<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCalendarEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->calendarEvent->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_id'   => ['nullable', 'exists:applications,id'],
            'title'            => ['required', 'string', 'max:255'],
            'event_type'       => ['required', 'in:interview,test,deadline,followup,other'],
            'event_datetime'   => ['required', 'date', 'after:now'],
            'end_datetime'     => ['nullable', 'date', 'after:event_datetime'],
            'description'      => ['nullable', 'string'],
            'location'         => ['nullable', 'string', 'max:255'],
            'is_online'        => ['boolean'],
            'reminder_minutes' => ['nullable', 'integer', 'min:5', 'max:10080'],
            'color'            => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ];
    }
}
