
const toggleBtns = document.querySelectorAll('.toggle-week-btn');

if (toggleBtns) {
    toggleBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            const card = this.closest('.programWeek');
            const content = card.querySelector('.days_per_week');
            content.classList.toggle('hidden');

        if (content.classList.contains('hidden')) {
                card.querySelectorAll('.exercises').forEach(exercise => {
                    exercise.classList.add('hidden');
                });

                card.querySelectorAll('.toggle-day-btn svg').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });
            }

            const icon = this.querySelector('svg');
            if (icon) {
                icon.classList.toggle('rotate-180');
            }
        });
    });
}
