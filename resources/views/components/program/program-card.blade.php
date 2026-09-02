@props([
    'program'
])

<x-card>
    <div>
        <a href="{{ route('program.show', $program) }}" class="w-fit" data-test="showProgram">
            <h3 class="text font-bold text-lg mb-2 flex gap-2 line-clamp-1">
                <p class="line-clamp-1 text-ellipsis max-w-35 xl:max-w-50">{{ $program->name }}</p><x-icons.arrow/>
            </h3>
        </a>
    </div>
    
    <div class="flex flex-row gap-6 mb-2">
        <div>
            @if ($program?->image_path)
                <img src="{{ Storage::url($program->image_path) }}"
                alt="program"
                class="w-50 h-40 rounded-md mb-2 object-cover"
                data-test="program-image">
            @endif
        </div>
        <div>
            <p><b>Category:</b> {{ $program->category->label() }}</p>
            <p><b>Duration:</b> {{ $program->weeks }} weeks</p>
            <p><b>Frequency:</b> {{ $program->days_per_week }} days</p>
            <p><b>Published at:</b> {{ date_format($program->updated_at, "Y.m.d") }}</p>
            <div
                class="rounded rounded-lg px-3 inline-block mt-2
                    @if ($program->status === App\ProgramStatus::DRAFT)border bg-gray-500/10 text-gray-500 border-gray-500/20"
                    @elseif ($program->status === App\ProgramStatus::HIDDEN)border bg-yellow-500/10 text-yellow-500 border-yellow-500/20"
                    @else border bg-green-500/10 text-green-500 border-green-500/20"
                    @endif>
                {{ $program->status->label() }}
            </div>
        </div>
    </div>
    <div>
        
        <div class="text-muted-foreground text-ellipsis">{{ $program->description ?? 'No description for this program.'}}</div>
    </div>
</x-card>