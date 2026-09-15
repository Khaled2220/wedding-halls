<?php

namespace App\Http\Requests\Hall;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHallRequest extends FormRequest
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
            'name' => [ 'required', 'string', 'max:255', ],
            'description' => [ 'nullable', 'string', ],
            'images' => [ 'nullable', 'array', ],
            'images.*' => [ 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120', ],
            'address' => [ 'required', 'string', 'max:1000', ],
            'phone' => [ 'nullable', 'string', 'max:30', ],
            'price' => [ 'required', 'numeric', 'min:0', ],
            'capacity' => [ 'nullable', 'integer', 'min:1', ],
            'food' => [ 'nullable', 'in:included,available,not_available', ],
            'sweets' => [ 'nullable', 'in:included,available,not_available', ],
            'latitude' => [ 'nullable', 'numeric', 'between:-90,90', ],
            'longitude' => [ 'nullable', 'numeric', 'between:-180,180', ],
            'food_price' => [ 'nullable', 'numeric', 'min:0', ],
            'food_images' => [ 'nullable', 'array', ],
            'food_images.*' => [ 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120', ],
            'sweet_price' => [ 'nullable', 'numeric', 'min:0', ],
            'sweet_images' => [ 'nullable', 'array', ],
            'sweet_images.*' => [ 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120', ], 
        ];
    }
}
