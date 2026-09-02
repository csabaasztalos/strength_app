const addExerciseBtns = document.querySelectorAll('.add-exercise');

if (addExerciseBtns) {
    let newExerciseCounter = 0;

    addExerciseBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            const container = this.closest('.exercises');
            const buttonWrapper = this.parentElement;

            const weekNumber = buttonWrapper.querySelector('.weekNumber').value;
            const dayId = buttonWrapper.querySelector('.dayId').value;

            const existingRows = container.querySelectorAll('.exercise');
            let nextPosition = 1;

            if (existingRows.length > 0) {
                const lastRow = existingRows[existingRows.length - 1];
                const lastPositionInput = lastRow.querySelector('input[name*="[position]"]');
                
                if (lastPositionInput && lastPositionInput.value !== '') {
                    nextPosition = Number.parseInt(lastPositionInput.value, 10) + 1;
                } else {
                    nextPosition = existingRows.length + 1;
                }
            }

            const newRow = document.createElement('div');
            newRow.classList.add('exercise-row', 'exercise', 'mb-2');
            
            newRow.innerHTML = `
                <div>
                    <div class="mb-2 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-7 mr-6">
                        <div>
                            <div class="relative">
                                <b>
                                    <div class="space-y-2 ml-2">
                                        <p class="label ">Name</p>
                                        <input class="input exerciseSearch" autocomplete="off" required type="text" placeholder="Exercise name">
                                    </div>
                                </b>
                                <div class="absolute z-20 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    <ul class="divide-y divide-gray-100 exerciseResults">
                                    </ul>
                                </div>
                                <input class="exerciseId" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][exercise_id]" required type="hidden">
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2 ml-2">
                                <p class="label ">Sets</p>
                                <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][sets]" required type="number" min="1" max="30">
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2 ml-2">
                                <p class="label ">Reps</p>
                                <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][reps]" required type="number" min="1" max="50">
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2 ml-2">
                                <p class="label ">Percentage</p>
                                <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][percentage]" type="number" min="1" max="200">
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2 ml-2">
                                <p class="label ">RPE</p>
                                <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][rpe]" type="number" min="1" max="10">
                            </div>
                        </div>
                        <div>
                            <div class="space-y-2 ml-2">
                                <p class="label ">Duration</p>
                                <input class="input" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][duration_minutes]" type="number" min="0.5" max="120" step="0.5">
                            </div>
                        </div>

                        <div class="flex items-center mt-8 gap-2 ml-2">
                            <div class="grid grid-cols-2">
                                <p class="label">RM?</p>
                                <input type="checkbox" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][RM]"
                                title="Checking this will ignore RPE. If percentage is not empty, then it will be displayed like this: 90% of XRM.">
                            </div>
                            <button class="btn bg-red-500 text-white text-sm cancel-exercise ml-2" type="button">X</button>
                        </div>
                    </div>
                    <input type="hidden" class="input positions" name="weeks[${weekNumber}][days][${dayId}][new_exercises][${newExerciseCounter}][position]" type="number" min="0" max="100" required value="${nextPosition}">
                </div>
            `;

            container.insertBefore(newRow, buttonWrapper);
            newExerciseCounter++;
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
}