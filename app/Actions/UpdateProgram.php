<?php

namespace App\Actions;

use Amp\Http\Server\Request;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Program;
use App\Models\ProgramDay;
use App\Models\ProgramDayExercise;
use DB;
use Illuminate\Support\Facades\Storage;

final class UpdateProgram {
    public function handle(Program $program, UpdateProgramRequest $request): void {
      DB::transaction(function() use ($request, $program) {
            $oldWeeks = (int) $program->weeks;
            $oldDays = (int) $program->days_per_week;

            $this->updateProgramDayNames($program, $request['days']);

            $program->update($request['program']);

            if ($request['program']['current_image'] === null && $request->hasFile('program.image_path')) {
                 $this->updateProgramImage($request, $program);
            }

            if((int) $program->weeks !== $oldWeeks  ||
                (int) $program->days_per_week !== $oldDays
            ) {
                $this->updateProgramDays($program, (int) $program->weeks, (int) $program->days_per_week);
            }

            if(!empty($request['weeks'])) {
                $this->updateProgramDayExcercises($program, $request['weeks']);
            }

            if($request['deleted_program_exercises']) {
                $this->deleteProgramDayExercises($request['deleted_program_exercises']);
            }
        });
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
                        
                        $programExercise->update($exerciseData);
                    }
                }

                if (array_key_exists('new_exercises', $exercises)) {
                    foreach($exercises['new_exercises'] as $exerciseNumber => $exerciseData) {
                        $programExercise = $day->programDayExercises();
                        $programExercise->create($exerciseData);
                    
                    }
                }
            }
        }
    }

    private function deleteProgramDayExercises(array $deletedExercises): void  {
        $deleteIds = explode(',', $deletedExercises[0]);
        
        ProgramDayExercise::whereIn('id', $deleteIds)->delete();
    }
}