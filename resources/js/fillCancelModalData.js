
const openBtns = document.querySelectorAll('.openModal');

openBtns.forEach( btn => {
    btn.addEventListener('click', function(event) {
        const programId = btn.dataset.id;
        const hiddenInput = document.querySelector('#cancel_program_id');
        hiddenInput.value = programId;
    });
});