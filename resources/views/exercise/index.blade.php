<x-layout>
@vite('resources/js/toggleModal.js')
@vite('resources/js/fillEditModalData.js')
@vite('resources/js/selectExerciseEditCategory.js')

    <div class="w-7xl mx-auto">
        <div class="font-bold text-2xl mt-6 mb-2"><h1>Current exercises library</h1></div>
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
                    <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
    
                <div class="absolute left-0 mt-2 rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 z-50">
                    <a href="{{ route('exercises', Arr::except(request()->query(), 'category'))}}"
                        class="block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                        value="">All categories</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('exercises', array_merge(request()->query(), [
                            'category' => $category
                        ])) }}"
                        class="filterOption block px-3 py-2 rounded-lg text-white hover:bg-white/10"
                        value="{{ $category }}">{{ $category->label() }}</a>
                    @endforeach
                </div>
            </details>
            <div>
                <a class="btn btn-green-500/40" id="openModal">New exercise <x-icons.plus/></a>
            </div>
        </div>

        <ul class="grid grid-cols-3 mt-10 gap-2">
        @forelse ($exercises as $exercise)
            <x-card class="relative">
                <li class="flex justify-between">
                    <div class="flex flex-col gap-2">
                        <div><b>{{ $exercise->name }}</b></div>
                        <div class="ml-2 overflow-hidden mb-8 text-muted-foreground line-clamp-5">{{ $exercise->description }}</div>
                        <div class="flex gap-2 absolute bottom-2 left-2">
                            <a class="btn btn-outlined bg-yellow-500/40 openEditModal"
                                data-id="{{ $exercise->id }}"
                                data-name="{{ $exercise->name }}"
                                data-description="{{ $exercise->description }}"
                                data-category="{{ $exercise->category }}">
                                Edit <x-icons.external/>
                            </a>
                             <form method="POST" action="{{ route('exercise.delete', $exercise) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outlined bg-red-500/40">
                                    Delete <x-icons.trash/>
                                </button>
                                <input type="hidden" value="{{ $exercise->id }}" name="delete_exercise">
                            </form>
                        </div>
                    </div>
    
                    <div class="flex flex-col gap-2 w-40 min-w-40">
                    <div><btn class="btn btn-outlined cursor-default bg-gray-200 line-clamp-1 text-center">{{ $exercise->category->label() }}</btn></div>
                        <div class="flex flex-col items-start ml-2">
                            <p class="text-muted-foreground">id: {{ $exercise->id }}</p>
                            <p class="text-muted-foreground">created at: {{ date_format($exercise->created_at, 'Y.h.d' ) }}</p>
                            <p class="text-muted-foreground">updated at: {{ date_format($exercise->updated_at, 'Y.h.d' ) }}</p>
                        </div>
                    </div>
                </li>
            </x-card>
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