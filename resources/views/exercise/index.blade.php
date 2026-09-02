<x-layout>
    <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <h1 class="font-bold text-2xl mt-6 mb-6">Current exercises library</h1>
        <div class="flex justify-between">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-2">
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
                <input class="input max-w-70" placeholder="Search..." id="exerciseFilter">
            </div>
            
            <div>
                <a class="btn btn-green-500/40" id="openModal" data-test="newExercise">New exercise <x-icons.plus/></a>
            </div>
        </div>

        <div id="exerciseList" class="relative">
            <ul class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-3 mt-6">
            @forelse ($exercises as $exercise)
                <x-exercise.exercise-card :exercise="$exercise"/>
            @empty
                <li class="flex">
                    No exercises added yet.
                </li>
            @endforelse
            </ul>
            <div id="pageNumbers" class="absolute mt-1">
                {{ $exercises->links() }}
            </div>
        </div>
    </div>

    <x-exercise.new-exercise/>
    <x-exercise.edit-exercise/>

    @if ($errors->getBag('newExerciseModal')->any())
        <div id="message" class="bg-red-500 px-4 py-3 fixed bottom-4 right-4 rounded-lg text-white z-200">
            {{ $errors->getBag('newExerciseModal')->first() }}
        </div>
    @endif

    @if ($errors->getBag('editExerciseModal')->any())
        <div id="message" class="bg-red-500 px-4 py-3 fixed bottom-4 right-4 rounded-lg text-white z-200">
            {{ $errors->getBag('editExerciseModal')->first() }}
        </div>
    @endif

</x-layout>
