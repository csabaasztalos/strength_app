@props([
    'weekNumber', 'dayId', 'programExercise', 'show' => false
])

<div class="exercise mb-2">
    <div>
        <div class="mb-2 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 mr-6">
            <div class="ml-2 xl:ml-0">
                <div class="relative">
                    <b>
                        <x-form.field
                            label="Name"
                            class="input exerciseSearch"
                            value="{{ $programExercise->exercise->name }}"
                            required="required"
                            type="text"
                        />
                    </b>
                        <x-form.field
                            class="input exerciseId"
                            name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][exercise_id]"
                            value="{{ $programExercise->exercise->name }}"
                            required="required"
                            type="hidden"
                        />
                    <div class="absolute w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <ul class="divide-y divide-gray-100 exerciseResults">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Sets"
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][sets]"
                    value="{{ $programExercise->sets }}"
                    required="required"
                    type="number"
                    min="1"
                    max="30"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Reps"
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][reps]"
                    value="{{ $programExercise->reps }}"
                    required="required"
                    type="number"
                    min="1"
                    max="50"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Percentage"
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][percentage]"
                    value="{{ $programExercise->percentage }}"
                    type="number"
                    min="1"
                    max="100"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="RPE"
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][rpe]"
                    value="{{ $programExercise->rpe }}"
                    type="number"
                    min="1"
                    max="10"
                    step="0.5"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Duration"
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][duration_minutes]"
                    value="{{ $programExercise->duration_minutes }}"
                    type="number"
                    min="0"
                    max="120"
                    step="0.5"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Position"
                    class="input positions"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][position]"
                    value="{{ $programExercise->position }}"
                    type="number"
                    required="required"
                    min="1"
                    max="100"
                />
            </div>
            <div class="flex items-center mt-8">
                @if (!$show)
                    <button class="btn bg-red-500 text-white ml-2 text-sm delete-exercise" type="button">X</button>
                @endif
            </div>
        </div>
    </div>

    <x-form.field
        class=""
        name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][exercise_id]"
        value="{{ $programExercise->exercise->id }}"
        required="required"
        type="hidden"
    />

    <x-form.field
        class="programExerciseId"
        value="{{ $programExercise->id }}"
        required="required"
        type="hidden"
    />
</div>





 