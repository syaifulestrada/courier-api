<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourierRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('couriers', 'email')->ignore($this->courier)],
            'phone' => ['sometimes', 'string', 'max:13', Rule::unique('couriers', 'phone')->ignore($this->courier)],
            'level' => 'sometimes|integer|between:1,5',
            'address' => 'sometimes|string',
            'is_active' => 'sometimes|boolean',
            'registered_at' => 'sometimes|date|before_or_equal:today',
        ];
    }
}
