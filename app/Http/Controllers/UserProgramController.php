<?php

namespace App\Http\Controllers;

use App\Actions\StoreProgram;
use App\Actions\StoreUserProgram;
use App\Helpers\UserProgramDayHelper;
use App\Http\Requests\StoreUserProgramRequest;
use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use App\UserProgramStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserProgramController extends Controller
{
    public function index (User $user) {
        if($user->id !== Auth::user()->id){
            abort(404);
        }

        $userPrograms = $user->userProgram()->with('program')->orderByDesc('created_at')->get();

        return view('userprograms.index', ['programs' => $userPrograms]);
    }

    public function store (Program $program, StoreUserProgram $action, Request $request) {
        $user = $request->user();

        if($user->userProgram()->where(['program_id' => $program->id, 'status' => UserProgramStatus::STARTED])->exists()) {
            return redirect(route('programs'))->with('error', 'You can\'t run the same program twice at the same time!');
        }

        if(($user->userProgram()->where('status', UserProgramStatus::STARTED)->count()) < 2) {
            $action->handle($program, $user);

            return redirect(route('programs'))->with('success', 'Successfully started '. $program->name .'!');

        } else {
            return redirect(route('programs'))->with('error', 'You only can run 2 programs at the same time!');
        }
    }

    public function show (UserProgram $userProgram, int $week, int $day, UserProgramDayHelper $helper, Request $request) {
        $user = $request->user();

        if($userProgram->user->id !== $user->id){
            abort(404);
        }

        $programDays =
            $userProgram
            ->userProgramDays()
            ->with('programday.programDayExercises.exercise')
            ->get()
            ->groupBy('programDay.week_number');

        $days = $helper->getNeighbouringDays($userProgram, $week, $day);

        return view('userprograms.show', [
            'program' => $userProgram,
            'user' => $user,
            'programDays' => $programDays,
            'week' => $week,
            'day' => $day,
            'nextDay' => $days['nextDay'],
            'nextWeek' => $days['nextWeek'],
            'prevDay' => $days['prevDay'],
            'prevWeek' => $days['prevWeek']
        ]);
    }

    public function cancel(Request $request) {
        $user = $request->user();
        $userProgramStatus = $user->userProgram()
            ->where('id', $request['cancel_program.id'])
            ->pluck('status')
            ->contains(UserProgramStatus::STARTED);

        if ($userProgramStatus) {
            $user->userProgram()->where('id', $request['cancel_program.id'])->update(['status' => UserProgramStatus::CANCELLED]);
            return redirect(route('user.programs', [$user]))->with('success', 'Program successfully cancelled!');
        }

        return redirect(route('user.programs', [$user]))->with('error', 'You can\'t cancel this program!');
    }
}
