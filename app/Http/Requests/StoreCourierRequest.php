<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:couriers,email',
            'phone' => 'required|string|max:13|unique:couriers,phone',
            'level' => 'required|integer|between:1,5',
            'address' => 'required|string',
            'is_active' => 'required|boolean',
            'registered_at' => 'required|date|before_or_equal:today',
        ];
    }
}
