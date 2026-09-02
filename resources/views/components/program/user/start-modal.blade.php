@props([
    'program', 'exerciseMaxes'
])

<dialog class="backdrop:bg-black/50 backdrop:backdrop-blur-xs m-auto" style="background: transparent !important; border: 0 !important; padding: 0 !important;"  id="startConfirm">
    <div class="rounded-xl overflow-hidden max-w-2xl max-h-[80dvh] mx-auto shadow-2xl">
        <x-card class="w-full h-full overflow-hidden relative">
            <div class="flex items absolute top-5 right-5"><a class="btn btn-outlined text-gray-500 modalClose">X</a></div>
            <form
                action="{{ route('user_program.start', $program) }}"
                class="max-w-2xl max-w-2xl max-h-[80dvh]"
                method="POST"
            >
                @csrf
                @php
                    $usesPercentages = false;
                    $programDays = App\Models\ProgramDay::where('program_id', $program['id'])->get();
                    
                    foreach ($programDays as $day) {
                        if($day->programDayExercises()->whereNotNull('percentage')->exists()) {
                            $usesPercentages = true;
                        }
                    }
                   
                @endphp
                <div class="flex flex-col gap-2 mt-2">
                    <h1 class="text-2xl font-bold">Start program</h1>
                    @if ($usesPercentages)
                        <h4 class="text-lg font-bold text-muted-foreground">This step is fully optional!</h4>
                        <div class="text-muted-foreground">
                            To start this program you can add your exercise one rep maxes, so we can suggest loads. 
                            It's completely optional. I you don't know your maxes or you don't want to fill them, 
                            you will only see the suggested intensity per exercise (percentages).
                        </div>
                        
                        
                        <div id="exerciseMaxes" class="max-h-100 overflow-y-auto">
                            @foreach ($exerciseMaxes as $index => $exercise)
                                <x-form.field
                                    type="number"
                                    label="Your {{$exercise->exercise->percentageBasedOnExercise->name}} 1RM(kg):"
                                    name="user_maxes[{{ $index }}][max]"
                                    class="input w-1/2"
                                    min="1"
                                    max="1000"
                                    dataTest="userMax"/>

                                    <input type="hidden" name="user_maxes[{{ $index }}][exercise_id]" value="{{ $exercise->exercise->percentage_based_on_exercise_id }}">
                            @endforeach
                        </div>
                    @else
                        <h4 class="text-lg font-bold text-muted-foreground">Click on proceed to start this program!</h4>
                        <div class="text-muted-foreground">
                            You only can run 2 different programs at the same time. 
                            If you want to try/run another program, you will have to cancel one!
                        </div>
                    @endif
                    

                    <div class="flex items-center justify-between">
                        <button type="submit" class="btn btn-primray mt-2 mb-2" id="applyButton">Proceed</button>
                        <a class="btn btn-outlined text-white bg-red-500 hover:bg-red-800 mt-2 mb-2 modalClose">Go back</a>
                    </div>
                </div>
            </form>
        </x-card>
    </div>
</dialog>