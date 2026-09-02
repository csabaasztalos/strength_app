@props([
    'programDays', 'program',
    'week_number', 'day_number',
    'next_day' => null, 'next_week' => null,
    'previous_day' => null, 'previous_week' => null
])

<x-card class="relative">
    <div class="w-full flex gap-2 mx-auto items-center justify-center">
        <a @if((int) $previous_day && (int) $previous_week)
                    href="{{ route('progression', [$program, $previous_week, $previous_day]) }}"
                @endif
            class="rotate-180 mt-1" title="previous"
            data-test="previousDay">
            <x-icons.arrow/>
        </a>
        <h1 class="text-2xl font-bold">
            @if ($program->current_week === (int) $week_number
                && $program->current_day === (int) $day_number)
                Current Day</h1>
            @else
                W{{ $week_number }}/D{{ $day_number }}</h1>
            @endif
        <a @if((int) $next_day && (int) $next_week)
                    href="{{ route('progression', [$program, $next_week, $next_day]) }}"
                @endif
            class="mt-1" title="next"
            data-test="nextDay">
            <x-icons.arrow/>
        </a>
    </div>

    @foreach ( $programDays as $weekNumber => $days )
        @foreach ( $days as $day )
            @if ($weekNumber === (int) $week_number && $day->programDay->day_number === (int) $day_number)
                <div class="ml-2">
                    <div class="flex items-center justify-between">
                        <h1 class="text-xl font-bold ">W{{ $weekNumber }} - D{{$day->programDay->day_number}}@if($day->programDay->name): {{ $day->programDay->name }} @endif</h1>
                        <div class="absolute top-12 right-5">
                            @if($day->status === App\UserProgramDayStatus::COMPLETED)
                                <a class= "btn border cursor-default
                                    {{"bg-green-500/10 text-green-500 border-green-500/20" }}">
                                    {{ $day->status->label() }}
                                </a>
                            @elseif ($day->status === App\UserProgramDayStatus::SKIPPED)
                                <a class= "btn border cursor-default
                                    {{"bg-red-500/10 text-red-500 border-red-500/20" }}">
                                    {{ $day->status->label() }}
                                </a>
                            @else
                                <a class= "btn border cursor-default
                                    {{"bg-yellow-500/10 text-yellow-500 border-yellow-500/20" }}">
                                    In progress
                                </a>
                            @endif
                        </div>
                    </div>

                    @forelse ($day->groupedExercises as $item)
                        <div class="mb-3">
                            <p class="font-semibold text-gray-500 text-lg">
                                {{ $item->first()->exercise->name }}
                            </p>

                            <ul class="list-disc ml-5 space-y-1 text-muted-foreground">
                                @foreach ($item as $exercise)
                                    @php
                                        $userMax = $program->userProgramExerciseMaxes
                                            ->firstWhere('exercise_id', $exercise->exercise->percentage_based_on_exercise_id);
                                    @endphp

                                    <li>
                                        {{ $exercise->sets }}×{{ $exercise->reps }}

                                        @if($exercise->rep_max && $exercise->percentage && !$userMax)
                                            {{ $exercise->percentage }}% of {{ $exercise->reps }}RM
                                        @elseif($exercise->rep_max)
                                            RM
                                        @elseif($exercise->percentage && $userMax)
                                            ~{{ $exercise->percentage }}%
                                            ({{ (int) ($userMax->max * ($exercise->percentage / 100)) }} kg)
                                        @elseif($exercise->percentage)
                                            ~{{ $exercise->percentage }}%
                                        @endif

                                        @if($exercise->rpe)
                                            , RPE {{ $exercise->rpe }}
                                        @endif

                                        @if($exercise->duration_minutes)
                                            | {{ $exercise->duration_minutes }} min
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-muted-foreground">No exercises yet.</p>
                    @endforelse

                        <label class="label mt-2 font-bold" for="notes">Notes(optional):</label>
                        <form action="{{ route('user_program.update', [$program, $day_number, $week_number]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <textarea class="input h-25" id="notes" name="notes">{{ $day->notes }}</textarea>
                            <button class="btn btn-outlined bg-gray-200 hover:bg-gray-500" type="submit">Save notes</button>
                            <input type="hidden" name="day_id" value="{{ $day->id }}">
                        </form>
                    </div>

                    @if ($program->status === App\UserProgramStatus::STARTED)
                        <div class="flex justify-between mt-5">
                            <form action="{{ route('user_program_day.changeStatus', [$day, App\UserProgramDayStatus::COMPLETED]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-primary" data-test="completeWorkout"><x-icons.white-check/>Complete Workout</button>
                                <input type="hidden" name="userProgram" value="{{ $program }}">
                                <input type="hidden" name="day_number" value="{{ $day->programDay->day_number }}">
                                <input type="hidden" name="week_number" value="{{ $day->programDay->week_number }}">
                            </form>
    
                            <form action="{{ route('user_program_day.changeStatus', [$day, App\UserProgramDayStatus::SKIPPED]) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn bg-red-500 hover:bg-red-800" data-test="skipWorkout"><x-icons.skip/>Skip Workout</button>
                                <input type="hidden" name="userProgram" value="{{ $program }}">
                                <input type="hidden" name="day_number" value="{{ $day->programDay->day_number }}">
                                <input type="hidden" name="week_number" value="{{ $day->programDay->week_number }}">
                            </form>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    @endforeach
</x-card>