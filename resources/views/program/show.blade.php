<x-layout>
@vite('resources/js/toggleWeeks.js')
@vite('resources/js/toggleDays.js')
    <div class="mx-auto w-5xl px-4 mt-10">
        <div class="flex items-center justify-between">
            <div class="mt-4 mb-4">
                <h1 class="text-3xl font-bold ">{{ $program->name }}</h1>
                <a class= "btn border cursor-default
                    {{ $program->status == App\ProgramStatus::DRAFT ? "bg-yellow-500/10 text-yellow-500 border-yellow-500/20" : "bg-green-500/10 text-green-500 border-green-500/20" }}">
                    {{ $program->status }}
                </a>
            </div>
            <div class="flex items-end gap-2">
                <a href="{{ route('program.edit', $program) }}" class="btn btn-outlined bg-yellow-500/40">
                    Edit <x-icons.external/>
                </a>
                @if ($program->status === App\ProgramStatus::DRAFT)
                    <form method="POST" action="{{ route('program.publish', $program) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outlined bg-green-500/40">
                                Publish<x-icons.check/>
                        </button>
                        <input type="hidden" value="{{ $program->id }}" name="publish_program_id">
                    </form>
                @else
                    <form method="POST" action="{{ route('program.draft', $program) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outlined bg-gray-500/40">
                            Draft<x-icons.draft/>
                        </button>
                        <input type="hidden" value="{{ $program->id }}" name="draft_program_id">
                    </form>
                @endif
                
                <form method="POST" action="{{ route('program.delete', $program) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outlined bg-red-500/40">
                        Delete <x-icons.trash/>
                    </button>
                    <input type="hidden" value="{{ $program->id }}" name="delete_program">
                </form>
            </div>
        </div>

        @if ($program?->image_path)
            <x-card class="mb-2">
                <img src="{{ Storage::url($program->image_path) }}" alt="program" class="max-h-180 mx-auto rounded-md block"
                    data-test="program-image" id="imageDisplay">
            </x-card>
        @endif

        @if ($program->description)
            <x-card>
                <h1 class="text-lg font-bold">Program description</h1>
                <p class="text-muted-foreground">{{ $program->description }}</p>
            </x-card>
        @endif
        <x-program.exercises :programDays="$programDays"></x-program.exercises>

</x-layout>
