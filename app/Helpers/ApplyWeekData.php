<?php

namespace App\Helpers;

use App\Models\Program;
use App\Models\ProgramDay;
use App\Models\ProgramDayExercise;
use DB;

class ApplyWeekData {
    public function handle(array $days, Program $program): void{

        DB::transaction(function () use($days, $program) {
             $remainingDays = $program->programDays()
            ->where('week_number', 1)
            ->pluck('day_number','id');

            for ($weeks = 2; $weeks <= $program->weeks; $weeks++) {
                foreach ($days as $dayId => $dayData) {
                    $currentDay = $program->programDays()
                        ->findOrFail($dayId);

                    $newDay = $program->programDays()
                    ->where([
                        'week_number' => $weeks,
                        'day_number' => $currentDay->day_number
                    ])
                    ->firstOrFail();

                    $remainingDays->forget($dayId);

                    $newDay->programDayExercises()->delete();

                    $exercisesValues = array_values($dayData['exercises']);

                    foreach ($exercisesValues as $position => $exerciseData ) {
                        $created = ProgramDayExercise::create([
                            'program_day_id' => $newDay->id,
                            'exercise_id' => $exerciseData['exercise_id'],
                            'sets' => $exerciseData['sets'],
                            'reps' => $exerciseData['reps'],
                            'percentage' => $exerciseData['percentage'] ?? null,
                            'rpe' => $exerciseData['rpe'] ?? null,
                            'duration_minutes' => $exerciseData['duration_minutes'] ?? null,
                            'position' => $position + 1
                        ]);
                    }
                }
            }

            if($remainingDays->isNotEmpty()) {
                foreach ($remainingDays as $id => $dayNumber) {
                    $program->programDays()->where('day_number', $dayNumber)
                    ->get()
                    ->each(function ($day) {
                        $day->programDayExercises()->delete();
                    });
                }
            }
        });
    }
}
