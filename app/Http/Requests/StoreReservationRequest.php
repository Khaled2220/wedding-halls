<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
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
            'hall_id' => ['required','integer','exists:halls,id',],
            'reservation_date' => ['required','date','after_or_equal:today',],
            'start_time' => ['required','date_format:H:i',],
            'end_time' => ['required','date_format:H:i','after:start_time',],
            'guests' => ['required','integer','min:1',],
            'food_ids' => ['nullable','array',],
            'food_ids.*' => [ 'integer','distinct','exists:foods,id',],
            'sweet_ids' => ['nullable','array',],
            'sweet_ids.*' => ['integer','distinct','exists:sweets,id',],
        ];
    }
}
