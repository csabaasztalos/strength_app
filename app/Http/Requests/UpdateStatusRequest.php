<?php

namespace App\Http\Requests;

use App\ProgramStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Storage;

class UpdateStatusRequest extends FormRequest
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
            'publish_program_id' => ['required', 'integer', Rule::exists('programs', 'id')]
        ];
    }

    public function after(): array {
        return [
            function ($validator) {
                $program = $this->route('program');

                if ( $program->status === ProgramStatus::ACTIVE) {

                    $validator->errors()->add(
                        'status',
                        'Program is already published.'
                    );
                }

                if ( blank($program->description) ) {

                    $validator->errors()->add(
                        'status',
                        'Description is required before publishing.'
                    );
                }

                if ( blank($program->image_path) ) {

                    $validator->errors()->add(
                        'status',
                        'Program image is required before publishing.'
                    );
                }

                if ( !Storage::disk('public')->exists($program->image_path) ) {

                    $validator->errors()->add(
                        'status',
                        'Can\'t find the specified program image in the storage.'
                    );
                }
            }
        ];
    }

}
