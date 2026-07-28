<?php

namespace App\Http\Requests;

use App\ProgramCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramRequest extends FormRequest
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
            'weeks' => ['nullable', 'array'],
            'weeks.*.days' => ['required', 'array'],
            'weeks.*.days.*' => ['required', 'array'],
            'weeks.*.days.*.exercises.*.exercise_id' => ['required', 'integer', Rule::exists('exercises', 'id')],
            'weeks.*.days.*.exercises.*.sets' => ['required', 'integer', 'min:1', 'max:30'],
            'weeks.*.days.*.exercises.*.reps' => ['required', 'integer', 'min:1', 'max:50'],
            'weeks.*.days.*.exercises.*.percentage' => ['integer', 'min:1', 'max:100'],
            'weeks.*.days.*.exercises.*.rpe' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'weeks.*.days.*.exercises.*.duration_minutes' => ['nullable', 'numeric', 'min:0.1', 'max:120'],
            'weeks.*.days.*.exercises.*.position' => ['required', 'integer'],

            'weeks.*.days.*.new_exercises.*.exercise_id' => ['required', 'integer', Rule::exists('exercises', 'id')],
            'weeks.*.days.*.new_exercise.*.sets' => ['required', 'integer', 'min:1', 'max:30'],
            'weeks.*.days.*.new_exercise.*.reps' => ['required', 'integer', 'min:1', 'max:50'],
            'weeks.*.days.*.new_exercise.*.percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'weeks.*.days.*.new_exercise.*.rpe' => ['nullable', 'numeric', 'min:1', 'max:10'],
            'weeks.*.days.*.new_exercise.*.duration_minutes' => ['nullable', 'numeric', 'min:0.1', 'max:120'],
            'weeks.*.days.*.new_exercise.*.position' => ['required', 'integer'],

            'days' => ['required', 'array'],
            'days.*.name' => ['nullable', 'string', 'min:3', 'max:255'],

            'program' => ['required', 'array'],
            'program.name' => ['required', 'string', 'min:3', 'max:255'],
            'program.description' => ['nullable', 'string'],
            'program.category' => ['required', Rule::enum(ProgramCategory::class)],
            'program.weeks' => ['required', 'integer', 'min:1', 'max:30'],
            'program.days_per_week' => ['required', 'integer', 'min:1', 'max:7'],
            'program.image_path' => ['nullable', 'image', 'max:4000']
        ];
    }
}
