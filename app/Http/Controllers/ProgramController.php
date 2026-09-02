<?php

namespace App\Http\Controllers;

use App\Helpers\ApplyWeekData;
use App\Actions\StoreProgram;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\ProgramStatus;
use App\UserProgramStatus;
use Illuminate\Http\Request;
use App\Actions\UpdateProgram;
use Storage;


class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $duration = Program::select('weeks')
            ->distinct()
            ->orderBy('weeks')
            ->pluck('weeks');

        $frequency = Program::select('days_per_week')
            ->distinct()
            ->orderBy('days_per_week')
            ->pluck('days_per_week');

        $category = Program::select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $programs = Program::query()
        ->when($request->filled('duration'), function($query) use ($request) {
            $query->where('weeks', $request->duration);
        })
        ->when($request->filled('frequency'), function($query) use ($request) {
            $query->where('days_per_week', $request->frequency);
        })
        ->when($request->filled('category'), function($query) use ($request) {
            $query->where('category', $request->category);
        })
        ->get();

        return view('program.index', [
            'programs' => $programs,
            'durations' => $duration,
            'frequencies' => $frequency,
            'categories' => $category
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('program.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request, StoreProgram $action)
    {
        $program = $action->handle($request);

        return redirect()
            ->route('program.edit', $program)
            ->with('success', 'Program has been created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Program $program, Request $request)
    {
        $user = $request->user();

        $programDays =
            $program->programDays()
            ->with('programDayExercises.exercise')
            ->get()
            ->groupBy('week_number')
            ->map(function ($days) {
                return $days->map(function ($day) {

                    $day->groupedExercises = $day->programDayExercises->chunkwhile(function ($value, $key, $chunk) {
                        return $value->exercise_id === optional($chunk->last())->exercise_id;
                    });

                    return $day;
                });
            });
        
        $startModalData = $programDays
        ->flatMap(function ($daysInWeek) {
            return $daysInWeek;
        })->flatMap(function ($day) {
            return $day->programDayExercises;
        })
        ->filter(function ($programDayExercises) {
            return !is_null($programDayExercises->exercise->percentage_based_on_exercise_id);
        })
        ->unique(fn ($programDayExercise) =>
            $programDayExercise->exercise->percentage_based_on_exercise_id
        );

        return view('program.show', [
            'program' => $program,
            'programDays' => $programDays,
            'user' => $user,
            'exerciseMaxes' => $startModalData
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        $programDays =
            $program->programDays()
            ->with('programDayExercises.exercise')
            ->orderBy('position')
            ->get()
            ->groupBy('week_number');

        return view('program.edit',[
            'program' => $program,
            'programDays' => $programDays
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, UpdateProgram $action, Program $program)
    {
        if ($program->status === ProgramStatus::DRAFT) {
            $action->handle($program, $request);
        } else {
            return redirect(route('program.edit', ['program' =>$program]))->with('success', "You cannot edit an active program.");
        }
        
        return redirect(route('program.edit', ['program' =>$program]))->with('success', "Program has been successfully updated.");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        if ($program->status !== ProgramStatus::DRAFT) {
            return redirect()->back()->with('error', "You can only delete a drafted program.");
        }

        if ($program->image_path) {
            Storage::disk('public')->delete($program->image_path);
        }

        $program->delete();

        return redirect(route('programs'))->with('success', "Program has been successfully deleted.");
    }


    /**
     * Publish specified resource.
     */
    public function publish(Program $program, UpdateStatusRequest $request)
    {
        $program->update(['status' => ProgramStatus::ACTIVE]);

        return redirect(route('programs'))->with('success', "Program has been successfully published.");
    }


    /**
     * Draft specified program.
     */
    public function draft(Program $program, Request $request)
    {
        if ($program->userProgram()->where('status', UserProgramStatus::STARTED)->exists()) {
            return redirect(route('programs', $program))->with('error', "You cannot draft a program  while it has active users.");
        }

        $program->update([
            'status' => ProgramStatus::DRAFT
        ]);

        return redirect(route('programs', $program))->with('success', "Program has been successfully drafted.");
    }


    public function hide(Program $program, Request $request)
    {
        if ($program->status === ProgramStatus::ACTIVE) {

            $program->update(['status' => ProgramStatus::HIDDEN]);
            return redirect(route('programs'))->with('success', "Program is now hidden!");
        }
        
        return redirect()->back()->with('error', "You only can hide active programs!");
    }


    public function apply(Program $program, Request $request, ApplyWeekData $action)
    {
        $firstWeek = $request->input('weeks.1');
        $days = $firstWeek['days'];

        try {
            $action->handle($days, $program);

            return redirect()->back()->with('success', "You applied the 1. weeks data to all weeks!");
        } catch (\Throwable $e) {
             return redirect()->back()->with('error', "Something went wrong, during the copy!");
        }
    }
}
