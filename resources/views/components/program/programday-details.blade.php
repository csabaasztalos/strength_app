@props([
    'weekNumber', 'days'
])

<x-card class="programWeek space-y-2 mt-2">
    @if(Route::is('program.edit') && (int) $weekNumber === 1)
        <div class="flex justify-between">
            <h3 class="weeks text-2xl font-bold" >Week {{ $weekNumber }}
                <button class="toggle-week-btn" type="button"><x-icons.arrow-down/></button>
            </h3>
            <button type="button" id="copyPasteWeeks" class="btn btn-primary">Apply to all</button>
        </div>
    @else
        <h3 class="weeks text-2xl font-bold" >Week {{ $weekNumber }}
            <button class="toggle-week-btn" type="button"><x-icons.arrow-down/></button>
        </h3>
    @endif

    <div class="days_per_week hidden mt-2">
        @foreach ($days as $day)
            <div class="day ml-2 text-xl font-bold flex flex-row gap-2 mb-4">Day {{ $day->day_number}}
                <x-form.field
                    class="w-36"
                    name="days[{{ $day->id }}][name]"
                    value="{{ $day->name }}"
                    placeholder="Optional name"
                />
                <button class="toggle-day-btn" type="button">
                    <x-icons.arrow-down/>
                </button>
            </div>
            <div class="exercises ml-4 hidden text-lg">
                @forelse ($day->programDayExercises as $programExercise)
                    <div class="dayExercise">
                        <x-form.exercise
                            :weekNumber="$weekNumber"
                            :dayId="$day->id"
                            :programExercise="$programExercise"
                        />
                        <input
                            class="newPositions"
                            type="hidden"
                            name="positions[{{ $programExercise->id }}]"
                        >
                    </div>
                @empty
                    <p class="text-muted-foreground mb-2">No exercises yet.</p>
                @endforelse
                
                <div class="flex gap-2 mt-4">
                    <input class="weekNumber" type="hidden" value="{{ $weekNumber }}">
                    <input class="dayId" type="hidden" value="{{ $day->id}}">
                    <button class="btn btn-primary add-exercise mt-2 mb-2" type="button">
                        <x-icons.plus/> New exercise
                    </button>
                </div>
            </div>
            
        @endforeach
    </div>
</x-card>