<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStatusRequest;
use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\ProgramCategory;
use App\ProgramStatus;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use App\Actions\UpdateProgram;
use View;

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

        return view('programs', [
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
    public function store(StoreProgramRequest $request)
    {
        $program = DB::transaction(function () use ($request) {
            $programData = $request->validated('program');
            if($programData['image_path']) {
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
        

        return redirect()
            ->route('program.edit', $program)
            ->with('success', 'Program has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        $programDays =
            $program->programDays()
            ->with('programDayExercises.exercise')
            ->get()
            ->groupBy('week_number');
        
        return view('program.show', [
                'program' => $program,
                'programDays' => $programDays
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

        return view('program.edit',
            [
                'program' => $program,
                'programDays' => $programDays
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, UpdateProgram $action, Program $program)
    {
        $action->handle($program, $request);
        
        return redirect(route('program.edit', ['program' =>$program]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program, Request $request)
    {
        //only delete if nobody is running the program
        if ($program->id === (int) $request['delete_program']) {
            $program->delete();
        }

        return redirect(route('index'))->with('success', "Program has been successfully deleted.");
    }

    /**
     * Publish specified resource.
     */
    public function publish(Program $program, UpdateStatusRequest $request)
    {
        if ($program->id === (int) $request['publish_program_id']) {
            $program->update(['status' => ProgramStatus::ACTIVE]);
        }
        
        return redirect(route('programs'))->with('success', "Program has been successfully published.");
    }

    /**
     * Draft specified program.
     */
    public function draft(Program $program, Request $request)
    {
        if ($program->id === (int) $request['draft_program_id']) {
            $program->update([
                'status' => ProgramStatus::DRAFT
            ]);
        }

        return redirect(route('programs', $program))->with('success', "Program has been successfully drafted.");
    }
}
