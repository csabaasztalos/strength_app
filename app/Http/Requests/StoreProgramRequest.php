<?php

namespace App\Http\Requests;

use App\ProgramCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreProgramRequest extends FormRequest
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
            'program' => ['required', 'array'],
            'program.name' => ['string', 'min:3', 'max:255', 'required'],
            'program.description' => ['nullable', 'string'],
            'program.category' => ['string', Rule::enum(ProgramCategory::class), 'required'],
            'program.weeks' => ['integer', 'min:1', 'max:30', 'required'],
            'program.days_per_week' => ['integer', 'min:1', 'max:7', 'required'],
            'program.image_path' => ['nullable', 'image', 'max:4000']
        ];
    }
}
