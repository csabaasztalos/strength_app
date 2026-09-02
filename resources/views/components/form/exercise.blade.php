@props([
    'weekNumber', 'dayId', 'programExercise', 'show' => false
])

<div class="exercise mb-2">
    <div>
        <div class="mb-2 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 mr-6">
            <div class="ml-2 xl:ml-0">
                <div class="relative">
                    <b>
                        <p class="label mt-2 mb-2">Name</p>
                        <x-form.field
                            class="input exerciseSearch"
                            value="{{ $programExercise->exercise->name }}"
                            required="required"
                            type="text"
                            displayErrors="false"
                        />
                    </b>
                        <x-form.field
                            class="input exerciseId"
                            name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][exercise_id]"
                            value="{{ $programExercise->exercise_id}}"
                            required="required"
                            type="hidden"
                            displayErrors="false"
                        />
                    <div class="absolute z-20 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        <ul class="divide-y divide-gray-200 exerciseResults">
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
                    displayErrors="false"
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
                    displayErrors="false"
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
                    max="200"
                    displayErrors="false"
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
                    displayErrors="false"
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
                    displayErrors="false"
                />
            </div>
            <div class="space-y-2 ml-2">
                <x-form.field
                    label="Position"
                    class="input positions currentPositions"
                    value="{{ $programExercise->position }}"
                    type="number"
                    required="required"
                    min="1"
                    max="100"
                    displayErrors="false"
                />
            </div>
            <div class="flex items-center mt-8 ml-2">
                @if (!$show)
                    <div class="grid grid-cols-2">
                        <p class="label">RM?</p>
                        <input type="checkbox" name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][RM]"
                        title="Checking this will ignore RPE. If percentage is not empty, then it will be displayed like this: 90% of XRM."
                        @if ($programExercise->rep_max === 1) checked @endif
                        >
                    </div>
                    <button class="btn bg-red-500 text-white ml-2 text-sm delete-exercise" type="button">X</button>
                @endif
            </div>
        </div>
    </div>

    <x-form.field
        class="programExerciseId"
        value="{{ $programExercise->id }}"
        required="required"
        type="hidden"
        displayErrors="false"
    />
</div>





 