<?php

namespace App\Infrastructure\Framework\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'gender' => 'required|string|in:male,female',
            'skill_level' => 'required|integer|between:1,100',
            'strength_level' => 'sometimes|integer',
            'speed_level' => 'sometimes|integer',
            'reaction_time' => 'sometimes|integer',
        ];
    }

    public function withValidator($validator)
{
    $validator->after(fn ($validator) => $this->validateGenderFields($validator));
}

    private function validateGenderFields($validator)
    {
        $gender = $this->input('gender');

        $requiredFields = [
            'male' => ['strength_level', 'speed_level'],
            'female' => ['reaction_time'],
        ];

        foreach ($requiredFields[$gender] ?? [] as $field) {
            if (!$this->filled($field)) {
                $validator->errors()->add($field, "The {$field} is required for {$gender}s.");
            }
        }
    }
}
