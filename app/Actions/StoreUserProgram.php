<?php

namespace App\Actions;

use Amp\Http\Server\Request;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use DB;

final class StoreUserProgram {
    public function handle(Program $program, User $user, array $userMaxes): UserProgram {
        return DB::transaction(function () use ($program, $user, $userMaxes) {

            $userProgram = UserProgram::create([
                'user_id' => $user->id,
                'program_id' => $program->id
            ]);

            $userDays = [];
            foreach ($program->programDays as $day) {
                $userDays[] = [
                    'program_day_id' => $day->id
                ];
            }

            $userProgram->userProgramDays()->createMany($userDays);

            if (!empty($userMaxes)) {
                $maxes = array_filter($userMaxes, function ($row) {
                    return !is_null($row['max']) && $row['max'] !== '';
                });

                if(!empty($maxes)) {
                    $userProgram->userProgramExerciseMaxes()->createMany($maxes);
                }
            }

            return $userProgram;
        });
    }
}