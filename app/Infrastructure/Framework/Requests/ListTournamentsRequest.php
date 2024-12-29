<?php

namespace App\Infrastructure\Framework\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListTournamentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gender' => 'sometimes|string|in:male,female',
            'from_date' => 'sometimes|date',
            'to_date' => 'sometimes|date|after_or_equal:start_date',
        ];
    }
}
