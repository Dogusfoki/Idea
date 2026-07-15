<?php

namespace App\Http\Requests;

// use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10',
            'status' => ['required', 'in:pending,in_progress,completed'],
            'links' => 'nullable|array',
            'links.*' => 'nullable|url|max:255',
            'steps' => 'nullable|array',
            'steps.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:5120'
        ];
    }
}
