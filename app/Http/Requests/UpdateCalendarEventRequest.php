<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCalendarEventRequest extends FormRequest
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
            'application_id'   => ['sometimes', 'nullable', 'exists:applications,id'],
            'title'            => ['sometimes', 'required', 'string', 'max:255'],
            'event_type'       => ['sometimes', 'required', 'in:interview,test,deadline,followup,other'],
            'event_datetime'   => ['sometimes', 'required', 'date'],
            'end_datetime'     => ['sometimes', 'nullable', 'date', 'after:event_datetime'],
            'description'      => ['sometimes', 'nullable', 'string'],
            'location'         => ['sometimes', 'nullable', 'string', 'max:255'],
            'is_online'        => ['sometimes', 'boolean'],
            'reminder_minutes' => ['sometimes', 'nullable', 'integer', 'min:0', 'max:10080'], // maks 7 hari
            'is_completed'     => ['sometimes', 'boolean'],
            'color'            => ['sometimes', 'nullable', 'regex:/^#([A-Fa-f0-9]{6})$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'application_id.exists'    => 'Lamaran yang dipilih tidak ditemukan.',
            'title.required'           => 'Judul event wajib diisi.',
            'title.max'                => 'Judul event maksimal 255 karakter.',
            'event_type.required'      => 'Tipe event wajib diisi.',
            'event_type.in'            => 'Tipe event tidak valid. Pilih: interview, test, deadline, followup, atau other.',
            'event_datetime.required'  => 'Waktu event wajib diisi.',
            'event_datetime.date'      => 'Format waktu event tidak valid.',
            'end_datetime.date'        => 'Format waktu selesai tidak valid.',
            'end_datetime.after'       => 'Waktu selesai harus setelah waktu mulai.',
            'is_online.boolean'        => 'Nilai online harus true atau false.',
            'reminder_minutes.integer' => 'Pengingat harus berupa angka menit.',
            'reminder_minutes.min'     => 'Pengingat tidak boleh negatif.',
            'reminder_minutes.max'     => 'Pengingat maksimal 10080 menit (7 hari).',
            'is_completed.boolean'     => 'Nilai selesai harus true atau false.',
            'color.regex'              => 'Format warna tidak valid, gunakan format hex (#RRGGBB).',
        ];
    }
}
