<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <h1 class="font-bold text-2xl mt-6 mb-6">Current exercises library</h1>
        <div class="flex justify-between">
            <details class="relative group inline-block">
                <summary class="list-none cursor-pointer rounded-xl bg-[oklch(0.25_0.03_268)] text-white px-4 py-3 select-none flex items-center justify-between">
                    @if (request('category'))
                        {{ App\ExerciseCategory::tryFrom(request('category'))
                            ? (App\ExerciseCategory::from(request('category')))->label()
                            : 'Category'
                            }}
                    @else
                        All categories
                    @endif
                <x-icons.filter-arrow/>
                </summary>
    
                <x-filter title="All categories" type="category" route="exercises" category="true"
                    :options="$categories"
                />
            </details>
            
            <div>
                <a class="btn btn-green-500/40" id="openModal" data-test="newExercise">New exercise <x-icons.plus/></a>
            </div>
        </div>

        <ul class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3 mt-6">
        @forelse ($exercises as $exercise)
            <x-exercise.exercise-card :exercise="$exercise"/>
        @empty
            <li class="flex">
                No exercises added yet.
            </li>
        @endforelse
        </ul>
    </div>

    <x-exercise.new-exercise/>
    <x-exercise.edit-exercise/>

</x-layout>
