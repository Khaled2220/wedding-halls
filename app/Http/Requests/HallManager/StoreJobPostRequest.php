<?php

namespace App\Http\Requests\HallManager;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hall_id' => [ 'required', 'integer', 'exists:halls,id', ],
            'title' => [ 'required', 'string', 'max:255', ],
            'description' => [ 'nullable', 'string', ],
            'requirements' => [ 'nullable', 'string', ],
            'salary' => [ 'required', 'numeric', 'min:0', ],
            'workers_needed' => [ 'required', 'integer', 'min:1', ],
            'employment_type' => [ 'nullable', 'string', 'max:100', ],
            'job_date' => [ 'required', 'date', 'after_or_equal:today', ],
            'start_time' => [ 'required', 'date_format:H:i', ],
            'end_time' => [ 'required', 'date_format:H:i', 'after:start_time', ],
            'deadline' => [ 'nullable', 'date', 'after_or_equal:today', ],
            'status' => [ 'required', 'in:open,closed', ],
        ];
    }
}
