<?php

namespace App\Actions;

use Amp\Http\Server\Request;
use App\Http\Requests\StoreProgramRequest;
use App\Models\Program;
use App\Models\ProgramDay;
use App\Models\ProgramDayExercise;
use App\ProgramStatus;
use DB;
use Illuminate\Support\Facades\Storage;

final class StoreProgram {
    public function handle(StoreProgramRequest $request): Program {
       return DB::transaction(function () use ($request) {
            $programData = $request->validated('program');

            if(array_key_exists('image_path', $programData)) {
                $programData['image_path'] = $request
                ->file('program.image_path')
                ->store('programs', 'public');
            }

            $program = $request->user()->programs()->create(
                $programData
            );

            $days = [];
            for ($week = 1; $week <= $program->weeks; $week++) {
                for ($day = 1; $day <= $program->days_per_week; $day++) {
                    $days[] = [
                        'week_number' => $week,
                        'day_number' => $day
                    ];
                }
            }

            $program->programDays()->createMany($days);
            return $program;
        });  
    }
}