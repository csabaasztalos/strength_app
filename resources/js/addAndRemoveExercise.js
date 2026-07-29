const addExerciseBtns = document.querySelectorAll('.add-exercise');
let newExerciseCounter = 0;

addExerciseBtns.forEach(btn => {
    

    btn.addEventListener('click', function(event) {
        const container = this.closest('.exercises');
        const buttonWrapper = this.parentElement;

        const weekNumber = buttonWrapper.querySelector('.weekNumber').value;
        const dayId = buttonWrapper.querySelector('.dayId').value;;

        const newRow = document.createElement('div');
        newRow.classList.add('exercise-row', 'exercise', 'mb-2');
        
        newRow.innerHTML = `
            <table style="width:80%;">
                <tr style="text-align: left;" class="mb-2 text-sm">
                    <td>Name</td>
                    <td class="px-2">Sets</td>
                    <td class="px-2">Reps</td>
                    <td class="px-2">Percentage</td>
                    <td class="px-2">RPE</td>
                    <td class="px-2">Duration (m)</td>
                    <td class="px-2">Position</td>
                </tr>
                <tr class="mb-2">
                    <td>
                        <div class="relative">
                            <b>
                                <div class="space-y-2">
                                    <input class="input exerciseSearch" autocomplete="off" required type="text" placeholder="Exercise name">
                                </div>
                            </b>
                            <div class="absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                <ul class="divide-y divide-gray-100 exerciseResults">
                                </ul>
                            </div>
                            <input class="exerciseId" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][exercise_id]" required type="hidden">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][sets]" required type="number" min="1" max="30">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][reps]" required type="number" min="1" max="50">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][percentage]" type="number" min="1" max="100">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][rpe]" type="number" min="1" max="10">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][duration_minutes]" type="number" min="0.5" max="120">
                        </div>
                    </td>
                    <td>
                        <div class="space-y-2 ml-2">
                            <input class="input positions" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][position]" type="number" min="0" max="100" required
                                value=""
                            >
                        </div>
                    </td>
                    <td>
                        <button class="btn bg-red-500 text-white text-sm cancel-exercise ml-2" type="button">X</button>
                    </td>
                </tr>
            </table>
        `;

        container.insertBefore(newRow, buttonWrapper);
        newExerciseCounter++;
        
        const exerciseContainer = newRow.closest('.exercises');
        updatePositions(exerciseContainer);
    });
});


document.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('cancel-exercise')) {
        const addedRow = event.target.closest('.exercise-row');
        
        if (addedRow) {
            const exerciseContainer = addedRow.closest('.exercises');
            addedRow.remove();
            newExerciseCounter--;

            if (exerciseContainer) {
                updatePositions(exerciseContainer);
            }
        }
    }
});


const deleteExerciseBtns = document.querySelectorAll('.delete-exercise');

deleteExerciseBtns.forEach(btn => {
    btn.addEventListener('click', function() {
        const exerciseRow = this.closest('.exercise');
        const exerciseId = exerciseRow.querySelector('.programExerciseId').value;
        const deletedExercises = document.querySelector('#deletedExercises');

        if (deletedExercises.value.trim() === "") {
            deletedExercises.value = exerciseId;
        } else {
            deletedExercises.value += `,${exerciseId}`;
        }

        exerciseRow.remove();
    });
});

function updatePositions(exerciseContainer) {
    const rows = exerciseContainer.querySelectorAll('.exercise'); 

    rows.forEach((row, index) => {
        const positionInput = row.querySelector('input[name*="[position]"]');
        
        if (positionInput) {
            positionInput.value = index + 1;
        }
    });
}