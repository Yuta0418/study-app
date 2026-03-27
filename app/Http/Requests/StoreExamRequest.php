<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'passing_score' => 'nullable|integer|min:0',
            'target_score' => 'nullable|integer|min:0|gte:passing_score',
        ];
    }
}
