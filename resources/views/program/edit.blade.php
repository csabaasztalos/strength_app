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

</x-layout>