@props([
    'program'
])

<x-card class="w-full max-h-105 md:flex-1 md:min-w-[calc(50%-0.75rem)] md:max-w-[calc(50%-0.75rem)] md:max-h-full">
    <div class="flex justify-between">
        <h1 class="font-bold text-3xl">{{ $program->program->name }}</h1>
        <div
            @if ($program->status === App\UserProgramStatus::FINISHED)
                class="rounded rounded-lg px-3 inline-block mt-2 mb-2 border bg-yellow-500/10 text-yellow-500 border-yellow-500/20"
            @elseif ($program->status === App\UserProgramStatus::STARTED)
                class="rounded rounded-lg px-3 inline-block mt-2 mb-2 border bg-green-500/10 text-green-500 border-green-500/20"
            @else 
                class="rounded rounded-lg px-3 inline-block mt-2 mb-2 border bg-red-500/10 text-red-500 border-red-500/20"
            @endif
        >{{ $program->status->label() }}
        </div>
    </div>
    <p class="btn btn-outlined bg-[oklch(0.25_0.03_268)] text-white hover:none cursor-default">{{ $program->program->category->label() }}</p>
    <p class="">{{ $program->program->f }}</p>
    <div class="w-full">
        <img src="{{ Storage::url($program->program->image_path) }}" alt="program"
        class="mx-auto h-40 object-cover rounded-md block md:h-75">
    </div>
    <div class="user-details">
        <div class="md:text-lg">
            @if ($program->status !== App\UserProgramStatus::FINISHED)
                <p><b>Current Day:</b> week {{ $program->current_week }} / day {{ $program->current_day }}</p>
            @endif
            <p><b>Duration:</b> {{ $program->program->weeks }} weeks</p>
            <p><b>Frequency:</b> {{ $program->program->days_per_week }} days </p>
            <p><b>Started at:</b> {{ date_format($program->created_at, "Y.m.d") }}</p>
            <p><b>Finished at:</b> {{ $program->finished_at  ?? '-'}}</p>
        </div>
    </div>
    <div class="buttons flex justify-between">
        <a class="btn btn-primary" href="{{ route('progression', [$program, $program->current_week, $program->current_day]) }}">My progression</a>
        <button
            class="btn btn-primary bg-red-500 hover:bg-red-800 openModal"
            data-id="{{ $program->id }}"
        >Cancel program</button>
    </div>
</x-card>