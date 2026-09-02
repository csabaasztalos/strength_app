const newPositions = document.querySelectorAll('.newPositions');

if (newPositions) {
    const positions = document.querySelectorAll('.currentPositions');

    positions.forEach(input => {
        input.addEventListener('change', function(event) {
            let container = input.closest('.dayExercise');

            let hiddenInput = container.querySelector('.newPositions');

            hiddenInput.value = input.value;
        });
    });
}