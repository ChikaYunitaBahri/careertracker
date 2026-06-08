<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserNotificationPrefRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->userNotificationPref->user_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_enabled'             => ['boolean'],
            'push_enabled'              => ['boolean'],
            'interview_reminder_email'  => ['boolean'],
            'interview_reminder_push'   => ['boolean'],
            'idle_application_email'    => ['boolean'],
            'idle_application_push'     => ['boolean'],
            'goal_milestone_push'       => ['boolean'],
            'weekly_summary_email'      => ['boolean'],
        ];
    }
}
