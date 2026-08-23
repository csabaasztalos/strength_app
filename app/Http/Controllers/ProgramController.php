<?php

namespace App\Http\Controllers;

use App\Actions\StoreProgram;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\ProgramStatus;
use App\UserProgramStatus;
use App\UserRoles;
use Auth;
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
            ->groupBy('week_number');
        
        return view('program.show', [
                'program' => $program,
                'programDays' => $programDays,
                'user' => $user
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
}
