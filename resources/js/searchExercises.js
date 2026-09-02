const container = document.querySelector('#programEditor');

const searchFilter = document.querySelector('#exerciseFilter');

const editExerciseSearch = document.querySelector('#editExerciseSearch');

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


if (searchFilter) {
    let searchTimeout;

    const exerciseList = document.getElementById('exerciseList');

    searchFilter.addEventListener('input', function () {
        clearTimeout(searchTimeout);

        searchTimeout = setTimeout(async () => {
            const name = searchFilter.value;

            const url = new URL(window.location.href);
            url.searchParams.set('name', name);

            const response = await fetch(url);

            const html = await response.text();

            const parser = new DOMParser();
            const document = parser.parseFromString(html, 'text/html');

            const newExerciseList = document.getElementById('exerciseList');

            exerciseList.innerHTML = newExerciseList.innerHTML;
        }, 300);
    });
}



if (editExerciseSearch) {
    console.log("SEARCH JS FILE LOADED");
    editExerciseSearch.addEventListener('input', async event => {

        if (!event.target.classList.contains('exerciseSearch')) {
            return;
        }

        const searchInput = event.target;
        const query = searchInput.value.trim();
        const result = document.querySelector('#exerciseResults');


        if (query.length < 2) {
            result.innerHTML = "";
            document.querySelector('#percentageBase').value = '';
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

    document.querySelector('#exerciseResults').addEventListener('click', event => {
        const option = event.target.closest('.exerciseResult');

        if(!option) {
            return;
        }

        document.querySelector('#editExerciseSearch').value = option.dataset.name;
        document.querySelector('#percentageBase').value = option.dataset.id;
        document.querySelector('#exerciseResults').innerHTML = '';

    });
}