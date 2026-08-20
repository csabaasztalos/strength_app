@props([
    'programDays'
])

<div>
    @foreach ($programDays as $weekNumber => $days)
        <x-card class="programWeek space-y-2 mt-2">
            <h3 class="weeks text-2xl font-bold" >Week {{ $weekNumber }}
                <button class="toggle-week-btn" type="button"><x-icons.arrow-down/></button>
            </h3>
            <div class="days_per_week hidden mt-2">
                @foreach ($days as $day)
                    <div class="day ml-2 text-xl font-bold flex flex-col">
                        <div class="flex flex-row">
                            Day {{ $day->day_number}}
                            @if ($day->name)
                                <div>
                                    <b>&nbsp;{{ $day->name }}</b>
                                </div>
                            @endif
    
                            <button class="toggle-day-btn mx-1 mr-2" type="button">
                                <x-icons.arrow-down/>
                            </button>
                        </div>
                    </div>
                   
                    <div class="exercises ml-4 hidden text-lg mb-4">
                        @forelse ($day->programDayExercises as $programExercise)
                            <div>
                                <p class="text-muted-foreground">
                                    <b class="text-gray-500">{{ $programExercise->exercise->name }}</b>
                                    {{ $programExercise->sets }} x {{ $programExercise->reps }}
                                    @if($programExercise->percentage) {{ '@'. $programExercise->percentage }}<small> (percent) </small>@endif
                                    @if($programExercise->rpe), RPE{{ $programExercise->rpe }} @endif
                                    @if($programExercise->duration_minutes)| duration: {{ $programExercise->duration_minutes }} <small>(minutes) </small> @endif
                                </p>
                            </div>
                        @empty
                            <p class="text-muted-foreground">No exercises yet.</p>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </x-card>
    @endforeach
</div>
