@props(['exercise'])

<x-card class="relative">
    <li class="flex justify-between">
        <div class="flex flex-col gap-2">
            <div><b>{{ $exercise->name }}</b></div>
            <div class="ml-2 overflow-hidden mb-8 text-muted-foreground line-clamp-5 min-h-25">{{ $exercise->description }}</div>
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
                </form>
            </div>
        </div>

        <div class="flex flex-col gap-2 w-40 min-w-40">
        <div><btn class="btn btn-outlined cursor-default bg-gray-200 line-clamp-1 text-center">{{ $exercise->category->label() }}</btn></div>
            <div class="flex flex-col items-start ml-2">
                <p class="text-muted-foreground">id: {{ $exercise->id }}</p>
                <p class="text-muted-foreground">created: {{ date_format($exercise->created_at, 'Y.h.d' ) }}</p>
                <p class="text-muted-foreground">updated: {{ date_format($exercise->updated_at, 'Y.h.d' ) }}</p>
            </div>
        </div>
    </li>
</x-card>