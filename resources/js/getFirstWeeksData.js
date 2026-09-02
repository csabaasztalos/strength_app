const applyButton = document.querySelector('#copyPasteWeeks');

if (applyButton) {
    applyButton.addEventListener('click', function (event) {
        const form = document.querySelector('#form');
        const firstWeek = form.querySelector('.programWeek');
        const inputs = firstWeek.querySelectorAll('.input');
        const applyForm = document.querySelector('#applyForm');

        inputs.forEach(input => {
            if (input.name) {
                 const hidden = document.createElement('input');

                hidden.type = 'hidden';
                hidden.name = input.name;
                hidden.value = input.value;

                applyForm.appendChild(hidden);
            }
        });
    });
}