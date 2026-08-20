<?php

namespace App\Http\Controllers;

use App\Actions\StoreProgram;
use App\Actions\StoreUserProgram;
use App\Helpers\UserProgramDayHelper;
use App\Http\Requests\StoreUserProgramRequest;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use App\Models\UserProgramDay;
use App\UserProgramDayStatus;
use App\UserProgramStatus;
use DateTime;
use DateTimeZone;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\Echo_;
class UserProgramDayController extends Controller
{
    public function update(UserProgram $userProgram, int $day, int $week, Request $request) {
        $userProgram->userProgramDays()->where('id', $request['day_id'])->update(['notes' => $request['notes']]);
        
        return redirect(route('progression', [$userProgram, $week, $day]))->with('success', 'Notes successfully updated!');
    }

    public function changeStatus (UserProgramDay $userProgramDay, UserProgramDayHelper $helper, Request $request, UserProgramDayStatus $status) {
        $user = $request->user();
        $userProgram = $userProgramDay->userProgram;

        if(!$user->id === $userProgram->user->id) {
            abort(404);
        }

        $weekNumber = (int) $request['week_number'];
        $dayNumber = (int) $request['day_number'];
        
        $days = $helper->getNeighbouringDays($userProgram, $weekNumber, (int) $dayNumber);
        
        $programDayId = $userProgram->program->ProgramDays()
            ->where(['week_number' => $days['prevWeek'], 'day_number' => $days['prevDay']])
            ->value('id');

        $prevDayStatus = $userProgram->UserProgramDays()
            ->where('program_day_id', $programDayId)
            ->value('status');

        $maxWeeks = $userProgram->program->weeks;
        $maxDays = $userProgram->program->days_per_week;
        
        if (($prevDayStatus !== null) ||
        ($weekNumber === 1 && $dayNumber === 1))
        {
            $helper->statusUpdate($userProgram, $userProgramDay, $status);

            if ($weekNumber === $maxWeeks && $dayNumber === $maxDays) {
                
                $date = new DateTime('now', new DateTimeZone('UTC'));
                $formattedTime = $date->format('Y-m-d H:i:s');

                $userProgramDay->userProgram
                    ->update([
                        'status' => UserProgramStatus::FINISHED,
                        'finished_at' => $formattedTime
                        ]);
                return redirect(route('user.programs', $user))
                    ->with('success', 'Program successfully finished!');
            }

            return redirect(route('progression', [$userProgramDay->userProgram, $weekNumber, $dayNumber]))
                ->with('success', 'Day marked as ' . $status->label() .'!');
        } else {
            return redirect(route('progression', [$userProgramDay->userProgram, $weekNumber, $dayNumber]))
                ->with('error', 'In order mark a day ' . $status->label() .', you must complete or skip the previous!');
        }
    }
}
