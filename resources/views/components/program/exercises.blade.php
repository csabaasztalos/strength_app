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
                        <div class="flex flex-row mb-2">
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
                        @forelse ($day->groupedExercises as $index => $item)
                            <div class="text-muted-foreground mb-1">
                                <b class="text-gray-500">{{ $item->first()->exercise->name }}</b>
                            @foreach ( $item as $exercise)
                                        {{ $exercise->sets }} x {{ $exercise->reps }}
                                        @if($exercise->rep_max && $exercise->percentage) {{ $exercise->percentage . '% of ' . $exercise->reps . 'RM'}}
                                        @elseif($exercise->rep_max && !$exercise->percentage) RM 
                                        @elseif($exercise->percentage && !$exercise->rep_max) {{ '@'. $exercise->percentage }}%@endif
                                        @if($exercise->rpe), RPE{{ $exercise->rpe }} @endif
                                        @if($exercise->duration_minutes)| duration: {{ $exercise->duration_minutes }} <small>(minutes) </small> @endif
                                        @if(count($item) > 1 && $exercise !== $item->last()), @endif
                            @endforeach
                            </div>
                        @empty
                            No exercises yet.</p>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </x-card>
    @endforeach
</div>