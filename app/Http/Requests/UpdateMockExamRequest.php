<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMockExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'taken_at' => 'required|date',
            'deviation_value' => 'nullable|numeric|min:0|max:100',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'required|string|max:100',
            'scores' => 'required|array|min:1',
            'scores.*' => 'required|integer|min:0|max:100',
        ];
    }
}
