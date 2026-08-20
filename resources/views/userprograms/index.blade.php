@vite('resources/js/toggleCancelModal.js')
@vite('resources/js/fillCancelModalData.js')

<x-layout>
    <h1 class="font-bold text-2xl mt-10 mb-6 md:mt-6 max-w-7xl mx-auto">Your current programs</h1>
    <div class="w-full max-w-7xl mx-auto flex flex-wrap gap-6 justify-center">
        @foreach ($programs as $program)
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
        @endforeach
    </div>
<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="cancelConfirm">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500" class="modalClose">X</a></div>
            <form
                action="{{ route('user_program.cancel') }}"
                method="POST"
                class="max-w-2xl max-w-2xl max-h-[80dvh]"
            >
                @csrf
                @method('PATCH')
                <div class="flex flex-col gap-2 mt-2">
                    <h1 class="text-2xl font-bold">Cancel program</h1>
                    <div class="text-muted-foreground">This is not reversible, your progression will be lost!<br>
                    Feel free to start again, or start a new program!</div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-outlined text-white bg-red-500 hover:bg-red-800 mt-2 mb-2">Proceed</button>
                        <a class="btn btn-primray mt-2 mb-2 modalClose">Go back</a>
                    </div>
                </div>
            <x-form.field id="cancel_program_id" type="hidden" name="cancel_program[id]"/>
            </form>
        </x-card>
    </div>
</dialog>
</x-layout>


