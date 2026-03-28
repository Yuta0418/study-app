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

    public function messages(): array
    {
        return [
            'target_score.gte' => '目標得点は合格基準点以上を入力してください。',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '試験名',
            'exam_date' => '試験日',
            'passing_score' => '合格基準点',
            'target_score' => '目標得点',
        ];
    }
}
