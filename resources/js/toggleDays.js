const toggleBtns = document.querySelectorAll('.toggle-day-btn');

toggleBtns.forEach(btn => {
    btn.addEventListener('click', function(event) {
        const day = this.closest('.day');
        const content = day.nextElementSibling;

        if(content) {
            content.classList.toggle('hidden');
        }

        const icon = this.querySelector('svg');
        if (icon) {
            icon.classList.toggle('rotate-180');
        }
    });
});
