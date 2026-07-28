@props([
    'program' => null
])

<x-form.field 
    label="Name"
    name="program[name]"
    required="required"
    value="{{ $program ? $program->name : ''}}"
    dataTest="programName"
    ></x-form.field >
<x-form.field 
    label="Description (optional)"
    name="program[description]"
    value="{{ $program ? $program->description : ''}}"
    dataTest="programDescription">
    </x-form.field >

<h4 for="program_categories" class="label mb-2">Category</h4>
<div class="flex flex-row gap-2" id="program_categories">
    @foreach (App\ProgramCategory::cases() as $category)
        <button
            type="button"
            data-test="category-{{ $category->value }}"
            class="category btn btn-outlined flex-1 h-10 bg-gray-400 text-white hover:!bg-gray-600"
            value="{{ $category->value }}">
            {{ $category->label() }}
        </button>
    @endforeach
    
    <x-form.field
        required="required"
        id="category"
        name="program[category]"
        type="hidden"
        value="{{ $program ? $program->category : ''}}"
        dataTest="programCategory"/>

</div>
<div class="grid grid-flow-col auto-col-fr gap-6">
    <x-form.field
        label="Number of weeks"
        name="program[weeks]"
        required="required"
        type="number"
        min="1"
        max="30"
        value="{{ $program ? $program->weeks : '' }}"
        dataTest="programWeeks"/>
    <x-form.field
        label="Days per week"
        name="program[days_per_week]"
        required="required"
        type="number"
        min="1"
        max="7"
        value="{{ $program ? $program->days_per_week : '' }}"
        dataTest="programDays"/>
</div>

@if ($program?->image_path)
    <div class="imageContainer border border-border rounded-lg bg-card p-4 md:text-sm mt-2 mb-2">
        <div class="imageDisplayContainer">
            <img src="{{ Storage::url($program->image_path) }}" alt="program" class="max-h-180 mx-auto rounded-md block"
            data-test="program-image" id="imageDisplay">
        </div>
        <div class="w-full flex items-center" id="imgBtnContainer">
            <button type="button" class="btn bg-red-500 mx-auto mt-4 hover:!bg-red-800" id="deleteImage">Delete</button>
            <input type="hidden" id="current_image" name="program[current_image]" value="{{ $program->image_path }}">
            
        </div>
    </div>
@else
        <x-form.field class="image" label="Image" name="program[image_path]" type="file" accept="image/*"></x-form.field>
@endif

{{ $slot }}

<button
    id="save"
    type="submit"
    data-test="save-program"
    class="btn btn-primary mt-4 mb-10 w-full">
    Save program
</button>