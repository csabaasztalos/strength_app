@props([
    'weekNumber', 'dayId', 'programExercise', 'show' => false
])

<div class="exercise">
    <table style="width:80%;">
        <tr style="text-align: left;" class="mb-2 text-sm">
            <td>Name</td>
            <td>Sets</td>
            <td>Reps</td>
            <td>Percentage</td>
            <td>RPE</td>
            <td>Duration (m)</td>
            <td>Position</td>
        </tr>
        <tr class="mb-2">
            <td>
                <b>
                    <x-form.field
                        class="input"
                        name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][exercise_id]"
                        value="{{ $programExercise->exercise->name }}"
                        required="required"
                        type="text"
                    />
                </b>
            </td>
            <td>
                <x-form.field
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][sets]"
                    value="{{ $programExercise->sets }}"
                    required="required"
                    type="number"
                    min="1"
                    max="30"
                />
            </td>
            <td>
                <x-form.field
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][reps]"
                    value="{{ $programExercise->reps }}"
                    required="required"
                    type="number"
                    min="1"
                    max="50"
                />
            </td>
            <td>
                <x-form.field
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][percentage]"
                    value="{{ $programExercise->percentage }}"
                    type="number"
                    min="1"
                    max="100"
                />
            </td>
            <td>
                <x-form.field
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][rpe]"
                    value="{{ $programExercise->rpe }}"
                    type="number"
                    min="1"
                    max="10"
                />
            </td>
            <td>
                <x-form.field
                    class="input"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][duration_minutes]"
                    value="{{ $programExercise->duration_minutes }}"
                    type="number"
                    min="0"
                    max="120"
                />
            </td>
            <td>
                <x-form.field
                    class="input positions"
                    name="weeks[{{ $weekNumber }}][days][{{ $dayId }}][exercises][{{ $programExercise->id }}][position]"
                    value="{{ $programExercise->position }}"
                    type="number"
                    required="required"
                    min="1"
                    max="100"
                />
            </td>
            <td>
                @if (!$show)
                    <button class="btn bg-red-500 text-white ml-2 text-sm delete-exercise" type="button">X</button>
                @endif
            </td>
        </tr>
    </table>

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