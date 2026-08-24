<?php

namespace App\Helpers;

use App\Models\UserProgram;
use App\Models\UserProgramDay;
use App\UserProgramDayStatus;
use App\UserProgramStatus;
use DB;

class UserProgramDayHelper {
    public function getNeighbouringDays(UserProgram $userProgram, int $week, int $day): array {
        
        $nextWeek = $week;
        $nextDay = $day + 1;

        if ($nextDay > $userProgram->program->days_per_week && $nextWeek < $userProgram->program->weeks) {
            $nextDay = 1;
            $nextWeek++;
        } elseif ($nextDay > $userProgram->program->days_per_week && $nextWeek >= $userProgram->program->weeks) {
            $nextDay = null;
            $nextWeek = null;
        }

        $prevWeek = $week;
        $prevDay = $day - 1;

        if ($prevDay < 1 && $prevWeek > 1) {
            $prevDay = $userProgram->program->days_per_week;
            $prevWeek--;
        } elseif ($prevDay < 1 && $prevWeek === 1) {
            $prevDay = null;
            $prevWeek = null;
        }

        return [
            'nextDay' => $nextDay,
            'prevDay' => $prevDay,
            'nextWeek' => $nextWeek,
            'prevWeek' => $prevWeek
        ];
    }

    public function statusUpdate (UserProgram $userProgram, UserProgramDay $userProgramDay, UserProgramDayStatus $status) {
        DB::transaction(function() use ($userProgram, $userProgramDay, $status) {
            
            if($userProgram->status !== UserProgramStatus::STARTED) {
                return;
            }

            if ($userProgramDay->status === null) {
                if ($userProgram->current_day < $userProgram->program->days_per_week) {
                    $userProgram->current_day++;
                } elseif ($userProgram->current_week < $userProgram->program->weeks) {
                    $userProgram->current_day = 1;
                    $userProgram->current_week++;
                }
                $userProgram->save();
            }
            
            $userProgramDay->update(['status' => $status]);
        });
    }
}