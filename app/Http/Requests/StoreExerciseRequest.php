<?php

namespace App\Http\Requests;

use App\ExerciseCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExerciseRequest extends FormRequest
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
            'exercise' => ['required', 'array'],
            'exercise.name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('exercises', 'name')],
            'exercise.description' => ['nullable', 'string'],
            'exercise.category' => ['required', 'string', Rule::enum(ExerciseCategory::class)]
        ];
    }

    protected $errorBag = 'newExerciseModal';
}
