
const modal = document.querySelector('#newExerciseModal');

if (modal) {
    const openBtn = document.querySelector('#openModal');
    const closeBtn = document.querySelector('#modalClose');

    openBtn.addEventListener('click', function(event) {
        modal.showModal();
    });

    closeBtn.addEventListener('click', function(event) {
        modal.close();
    });


    const editModal = document.querySelector('#editExerciseModal');
    const openEditModalBtns = document.querySelectorAll('.openEditModal');
    const closeEditModalBtn = document.querySelector('#closeEditModal');

    openEditModalBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            editModal.showModal();
        });
    });

    closeEditModalBtn.addEventListener('click', function(event) {
            editModal.close();
    });
}

