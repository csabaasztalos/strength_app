<x-layout>
@vite('resources/js/toggleWeeks.js')
@vite('resources/js/toggleDays.js')
    <div class="mx-auto w-5xl px-4 mt-20">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold mt-4 mb-4">{{ $program->name }}</h1>
                <div class="flex items-end gap-6">
                    <a href="{{ route('program.edit', $program) }}" class="btn btn-outlined bg-yellow-500/20">
                        Edit <x-icons.external/>
                    </a>
                    <a href="{{ route('program.edit', $program) }}" class="btn btn-outlined bg-green-500/20">
                        Publish <x-icons.external/>
                    </a>
                </div>
            </div>
        @if ($program?->image_path)
            <x-card class="mb-2">
                <img src="{{ Storage::url($program->image_path) }}" alt="program" class="max-h-180 mx-auto rounded-md block"
                    data-test="program-image" id="imageDisplay">
            </x-card>
        @endif
        @if ($program->description)
            <x-card>
                <p>{{ $program->description }}</p>
            </x-card>
        @endif

        <div>
            @foreach ($programDays as $weekNumber => $days)
                <x-card class="programWeek space-y-2 mt-2">
                    <h3 class="weeks text-2xl font-bold" >Week {{ $weekNumber }}
                        <button class="toggle-week-btn" type="button"><x-icons.arrow-down/></button>
                    </h3>
                    <div class="days_per_week hidden mt-2">
                        @foreach ($days as $day)
                            <div class="day ml-2 text-xl font-bold flex flex-row gap-2 mb-4">Day {{ $day->day_number}}
                                @if ($day->name)
                                    <div><b>{{ $day->name }}</b></div>
                                @endif

                                <button class="toggle-day-btn" type="button">
                                    <x-icons.arrow-down/>
                                </button>
                            </div>
                            <div class="exercises ml-4 hidden text-lg mb-4">
                                @forelse ($day->programDayExercises as $programExercise)
                                    <div>
                                        <p>
                                            <b>{{ $programExercise->exercise->name }}</b>
                                            {{ $programExercise->sets }} x {{ $programExercise->reps }}
                                            {{ '@'. $programExercise->percentage }}<small>(percent)</small>
                                            @if($programExercise->rpe), RPE{{ $programExercise->rpe }} @endif
                                            @if($programExercise->rpe)| duration: {{ $programExercise->duration_minutes }} (minutes) @endif
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
        
</x-layout>