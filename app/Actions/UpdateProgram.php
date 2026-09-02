<?php

namespace App\Actions;

use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Models\ProgramDay;
use App\Models\ProgramDayExercise;
use DB;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

final class UpdateProgram {
    public function handle(Program $program, UpdateProgramRequest $request): void {
        $positionChanged = false;
        
        DB::transaction(function() use ($request, $program, &$positionChanged) {
            $oldWeeks = (int) $program->weeks;
            $oldDays = (int) $program->days_per_week;
        
            $this->updateProgramDayNames($program, $request['days']);
            
            $program->update($request['program']);

            if ($request['program']['current_image'] === null && $request->hasFile('program.image_path')) {
                $this->updateProgramImage($request, $program);
            }

            if ((int) $program->weeks !== $oldWeeks  ||
                (int) $program->days_per_week !== $oldDays
            ) {
                $this->updateProgramDays($program, (int) $program->weeks, (int) $program->days_per_week);
            }

            if ($request['deleted_program_exercises']) {
                $this->deleteProgramDayExercises($request['deleted_program_exercises']);
                $positionChanged = true;
            }
            
            if (!empty($request['positions'])) {
                $this->updatePositions($request['positions']);
                $positionChanged = true;
            }

            if (!empty($request['weeks'])) {
                $this->updateProgramDayExcercises($program, $request['weeks']);
                $positionChanged = true;
            }

            return $positionChanged;
        });

        if ($positionChanged) {
            $this->normalizePositions($program);
        }
    }


    private function updateProgramDays(Program $program, int $weeks, int $days) {
        for($w = 1; $w <= $weeks; $w++) {
            for($d = 1; $d <= $days; $d++) {
                $program->programDays()->firstOrCreate([
                    'week_number' => $w,
                    'day_number' => $d
                ]);
            }
        }

        $program->programDays()->where('week_number', '>', $weeks)->delete();
        $program->programDays()->where('day_number', '>', $days)->delete();
    }


    private function updateProgramImage(UpdateProgramRequest $request, Program $program): void {
        if (Storage::disk('public')->exists($program->image_path)) {
            Storage::disk('public')->delete($program->image_path);
        }

        $image['image_path'] = $request
            ->file('program.image_path')
            ->store('programs', 'public');

        $program->update($image);
    }


    private function updateProgramDayNames(Program $program, array $days): void {
         foreach ($days as $programId => $dayData) {
            $day = $program->programDays()
                ->findOrFail($programId);
            $day->update([
                'name' => $dayData['name']
            ]);
        }
    }


    private function updateProgramDayExcercises(Program $program, array $weeks): void  {
        foreach ($weeks as $weekNumber => $weekData) {
            foreach($weekData['days'] as $dayId => $exercises) {
                $day = $program->programDays()->findOrFail($dayId);
                

                if(array_key_exists('exercises', $exercises)) {
                    
                    foreach($exercises['exercises'] as $programExerciseId => $exerciseData) {
                        $programExercise = $day->programDayExercises()
                            ->findOrFail($programExerciseId);
                        
                        if(array_key_exists('RM', $exerciseData)) {
                            (int) $exerciseData['percentage'] === 100
                            ? $percentage = null
                            : $percentage = $exerciseData['percentage'];

                            $programExercise->update([
                                'sets' => $exerciseData['sets'],
                                'reps' => $exerciseData['reps'],
                                'rpe' => null,
                                'duration_minutes' => $exerciseData['duration_minutes'],
                                'rep_max' => true,
                                'percentage' => $percentage
                            ]);
                        } else {
                            $programExercise->update(['rep_max' => false, ...$exerciseData]);
                        }
                    }
                }

                if (array_key_exists('new_exercises', $exercises)) {
                    foreach($exercises['new_exercises'] as $exerciseNumber => $exerciseData) {
                        $programExercise = $day->programDayExercises();

                        if(array_key_exists('RM', $exerciseData)) {
                            (int) $exerciseData['percentage'] === 100
                            ? $percentage = null
                            : $percentage = $exerciseData['percentage'];

                            $programExercise->create([
                                'exercise_id' => $exerciseData['exercise_id'],
                                'sets' => $exerciseData['sets'],
                                'reps' => $exerciseData['reps'],
                                'rpe' => null,
                                'duration_minutes' => $exerciseData['duration_minutes'],
                                'rep_max' => true,
                                'percentage' => $percentage,
                                'position' => $exerciseData['position']
                            ]);
                        } else {
                            $programExercise->create(['rep_max' => false, ...$exerciseData]);
                        }
                    }
                }
            }
        }
    }


    private function deleteProgramDayExercises(array $deletedExercises): void  {
        $deleteIds = explode(',', $deletedExercises[0]);
        ProgramDayExercise::whereIn('id', $deleteIds)->delete();
    }

    //$positions = exercise_id => new_position, exercise_id => new_position]
    private function updatePositions(array $positions): void {
        $updatedPositions = [];

        foreach ($positions as $exerciseId => $newPosition) {
            if ($newPosition !== null) {
                $exercise = ProgramDayExercise::findOrFail($exerciseId);

                $oldPosition = $exercise->position;

                if($oldPosition !== $newPosition) {
                    $updatedPositions[] = [
                        'id' => $exerciseId,
                        'new_position' => $newPosition,
                        'program_day_id' => $exercise->program_day_id
                    ];
                }
            }
        }

        if (empty($updatedPositions)) {
            return;
        }

        foreach ($updatedPositions as $exercise) {
            ProgramDayExercise::whereId($exercise['id'])
                ->update(['position' => -1 * (int) $exercise['id']]);
        }

        foreach ($updatedPositions as $exercise) {
            if(ProgramDayExercise::select()->where([
                    'position' => $exercise['new_position'],
                    'program_day_id' => $exercise['program_day_id']
                ])->exists()) {

                throw ValidationException::withMessages([
                    'position' => 'Two exercises position cannot be the same.',
                ]);
            }

            ProgramDayExercise::whereId($exercise['id'])
                ->update(['position' => (int) $exercise['new_position']]);
        }
    }


    private function normalizePositions(Program $program): void {
        $programDays =
            $program->programDays;
        
        foreach ($programDays as $day) {
            $exercises = $day
                ->programDayExercises()
                ->orderBy('position')
                ->get();

            foreach($exercises as $index=>$exercise) {
                $position = $index+1;
                if((int) $exercise->position !== $position) {
                    ProgramDayExercise::find($exercise->id)->update(['position' => $position]);
                }
            }
        }
    }
}