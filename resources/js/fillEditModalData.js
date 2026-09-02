
const openBtns = document.querySelectorAll('.openEditModal');
if (openBtns) {
    openBtns.forEach( btn => {
    btn.addEventListener('click', function(event) {
        const exerciseId = btn.dataset.id;
        const exerciseName = btn.dataset.name;
        const exerciseCategory= btn.dataset.category;
        const exerciseDescription = btn.dataset.description;
        const percentageBase = btn.dataset.percentagebase;
        const percentagebaseid = btn.dataset.percentagebaseid;

        document.querySelector('#exerciseName').value = exerciseName;

        if(exerciseDescription !== null) {
            document.querySelector('#exerciseDescription').value = exerciseDescription;
        }

        if(percentageBase !== undefined) {
            document.querySelector('#percentageBase').value = percentagebaseid;
            document.querySelector('#editExerciseSearch').value = percentageBase;
        }

        document.querySelector('#edit_category').value = exerciseCategory;
        document.querySelector('#exerciseId').value = exerciseId;


        const categoryBtns = document.querySelectorAll('.editCategory');
        const hiddenInput = document.querySelector('#edit_category');
        const currentCategory = hiddenInput.value;

        if (currentCategory) {
            const activeButton = document.querySelector(`.editCategory[value="${currentCategory}"]`);

            if (activeButton) {
                categoryBtns.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outlined', 'bg-gray-400', 'hover:!bg-gray-600');
                });

                activeButton.classList.remove('btn-outlined', 'bg-gray-400', 'hover:!bg-gray-600');
                activeButton.classList.add('btn-primary');
            }
        }

        categoryBtns.forEach(button => {
            button.addEventListener('click', function(event) {
                categoryBtns.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outlined', 'bg-gray-400', 'hover:!bg-gray-600');
                });

                this.classList.remove('btn-outlined', 'bg-gray-400', 'hover:!bg-gray-600');
                this.classList.add('btn-primary');

                hiddenInput.value = this.value;
            });
        });

    });
   
});
}
