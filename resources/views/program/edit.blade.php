<x-layout>
   <div class="w-full max-w-7xl mt-10 mb-6 mx-auto md:mt-6">
        <x-form title="Edit {{ $program->name }} program"
            description="Don't rush, think it through."
            action="{{ route('program.update', [$program]) }}"
            size="max-w-5xl"
            file="multipart/form-data"
            method="PATCH">
            <x-program.program-details :program="$program">
                <div id="programEditor">
                    @foreach ($programDays as $weekNumber => $days)
                        <x-program.programday-details
                            weekNumber="{{ $weekNumber }}"
                            :days="$days"
                        />
                    @endforeach
                </div>
    
                <div>
                    <input id="deletedExercises" type="hidden" name="deleted_program_exercises[]" value="">
                </div>
            </x-program.program-details>
        </x-form>
   </div>

    @if ($errors->getBag('updateProgramError')->any())
        <div id="message" class="bg-red-500 px-4 py-3 fixed bottom-4 right-4 rounded-lg text-white z-200">
            {{ $errors->getBag('updateProgramError')->first() }}
        </div>
    @endif

    <x-program.confirm-copy-modal :program="$program"/>
</x-layout>