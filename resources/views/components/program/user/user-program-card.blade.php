@props([
    'program'
])

<x-card>
    <div class="flex flex-row justify-between mb-2">
        <a href="{{ route('progression', [$program, $program->current_week, $program->current_day]) }}" class="w-fit" data-test="showProgram">
            <h3 class="text font-bold text-lg mb-2 flex gap-2 line-clamp-1"><p class="line-clamp-1 text-ellipsis max-w-35 xl:max-w-50">{{ $program->program->name }}</p></h3>
        </a>
        <div class="flex intems-center rounded-xl bg-[oklch(0.25_0.03_268)] border border-white/10 shadow-lg p-1 space-y-1 text-white w-fit">
            <p class="text-ellipsis">{{ $program->program->category->label() }}</p>
        </div>
    </div>
    
    <div class="flex flex-row gap-6 mb-2">
        <div>
            @if ($program->program?->image_path)
                <img src="{{ Storage::url($program->program->image_path) }}"
                alt="program"
                class="w-50 h-40 rounded-md mb-2 object-cover"
                data-test="program-image">
            @endif
        </div>
        <div>
            @if ($program->status !== App\UserProgramStatus::FINISHED)
                <p><b>Current:</b> W{{ $program->current_week }}/D{{ $program->current_day }}</p>
            @endif
            <p><b>Duration:</b> {{ $program->program->weeks }} weeks</p>
            <p><b>Frequency:</b> {{ $program->program->days_per_week }} days</p>
            <p><b>Finished at:</b> {{ $program->finished_at  ?? '-'}}</p>
            <div
                class="rounded rounded-lg px-3 inline-block mt-2
                    @if ($program->status === App\UserProgramStatus::STARTED)border bg-green-500/10 text-green-500 border-green-500/20"
                    @elseif ($program->status === App\UserProgramStatus::FINISHED)border bg-yellow-500/10 text-yellow-500 border-yellow-500/20"
                    @else border bg-red-500/10 text-red-500 border-red-500/20"
                    @endif>
                {{ $program->status->label() }}
            </div>
        </div>
    </div>

    <div class="buttons flex flex-row justify-between w-full">
        <a href="{{ route('progression', [$program, $program->current_week, $program->current_day]) }}" class="btn btn-primray">Progression</a>
        
        @if($program->status === App\UserProgramStatus::STARTED)
            <button
            class="btn bg-red-500 hover:bg-red-800 openModal"
            data-id="{{ $program->id }}"
            >Cancel</button>
        @endif
    </div>
</x-card>