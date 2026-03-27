<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudyRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'study_date' => 'required|date',
            'subject' => 'required|string|max:100',
            'study_minutes' => 'required|integer|min:1',
            'memo' => 'nullable|string',
        ];
    }
}
