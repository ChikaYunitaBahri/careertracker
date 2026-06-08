<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGoalMilestoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->goal->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'          => ['required', 'string', 'max:255'],
            'target_count'   => ['required', 'integer', 'min:1', 'max:9999'],
            'is_achieved'    => ['sometimes', 'boolean'],
            'achieved_at'    => ['sometimes', 'nullable', 'date', 'before_or_equal:now', 'required_if:is_achieved,true'],
            'order_position' => ['sometimes', 'integer', 'min:1', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'               => 'Judul milestone wajib diisi.',
            'title.max'                    => 'Judul milestone maksimal 255 karakter.',
            'target_count.required'        => 'Target jumlah wajib diisi.',
            'target_count.integer'         => 'Target jumlah harus berupa angka.',
            'target_count.min'             => 'Target jumlah minimal 1.',
            'target_count.max'             => 'Target jumlah maksimal 9999.',
            'is_achieved.boolean'          => 'Nilai pencapaian harus true atau false.',
            'achieved_at.date'             => 'Format tanggal pencapaian tidak valid.',
            'achieved_at.before_or_equal'  => 'Tanggal pencapaian tidak boleh lebih dari sekarang.',
            'achieved_at.required_if'      => 'Tanggal pencapaian wajib diisi jika milestone sudah dicapai.',
            'order_position.integer'       => 'Urutan posisi harus berupa angka.',
            'order_position.min'           => 'Urutan posisi minimal 1.',
            'order_position.max'           => 'Urutan posisi maksimal 255.',
        ];
    }
}
