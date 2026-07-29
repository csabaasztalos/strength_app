<?php

namespace App\Http\Requests;

use App\ExerciseCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExerciseRequest extends FormRequest
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
            'edit_exercise' => ['required', 'array'],
            'edit_exercise.name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('exercises', 'name')->ignore($this->input('edit_exercise.id'))],
            'edit_exercise.description' => ['nullable', 'string'],
            'edit_exercise.category' => ['required', 'string', Rule::enum(ExerciseCategory::class)]
        ];
    }
}
