const container = document.querySelector('#programEditor');

if (container) {
    
container.addEventListener('input', async event => {

    if (!event.target.classList.contains('exerciseSearch')) {
        return;
    }

    const searchInput = event.target;
    const exerciseRow = searchInput.closest('.exercise');

    const exerciseId = exerciseRow.querySelector('.exerciseId');
    const result = exerciseRow.querySelector('.exerciseResults');
    const query = searchInput.value.trim();

    exerciseId.value='';

    if(query.length < 2) {
        result.innerHTML = "";
        return;
    }

    const response = await fetch(
      `/exercises/search?query=${encodeURIComponent(query)}`
    );

    if(!response.ok) {
        result.innerHTML = '';
        result.classList.add('text-red-500');
        return;
    }

    const exercises = await response.json();

    result.innerHTML = exercises.map(exercise => `
        <li
            type="button"
            class="exerciseResult w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors"
            data-id="${exercise.id}"
            data-name="${exercise.name}"
        >
            ${exercise.name}
        </li>
    `).join('');
});

container.addEventListener('click', event => {
    const option = event.target.closest('.exerciseResult');

    if(!option) {
        return;
    }

    const exerciseRow = option.closest('.exercise');

    exerciseRow.querySelector('.exerciseSearch').value = option.dataset.name;
    exerciseRow.querySelector('.exerciseId').value = option.dataset.id;
    exerciseRow.querySelector('.exerciseResults').innerHTML = '';

});

}
