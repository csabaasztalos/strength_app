const hiddenInput = document.querySelector('#category');

if(hiddenInput) {
    const categoryBtns = document.querySelectorAll('.category');
    const currentCategory = hiddenInput.value;


    if (currentCategory) {
        const activeButton = document.querySelector(`.category[value="${currentCategory}"]`);

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
}
    