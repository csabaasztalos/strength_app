<?php

namespace App\Actions;

use Amp\Http\Server\Request;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use DB;

final class StoreUserProgram {
    public function handle(Program $program, User $user): UserProgram {
        return DB::transaction(function () use ($program, $user) {

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

            return $userProgram;
        });
    }
}