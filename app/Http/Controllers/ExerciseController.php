<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Exercise::select('category')
            ->distinct()
            ->pluck('category');

        $exercises = Exercise::query()
            ->when($request->filled('category'), function($query) use($request) {
                $query->where('category', $request->category);
            })
            ->when($request->filled('name'), function($query) use ($request) {
               $query->where('name', 'like', '%' . $request->name . '%') ;
            })
            ->paginate(9)
            ->withQueryString();

        return view('exercise.index', [
            'exercises' => $exercises,
            'categories' => $categories
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exercise.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        Exercise::create($request['exercise']);
        return redirect(route('exercises'))->with('success', 'Successfully created a new exercise!');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request)
    {
        $exerciseData = $request['edit_exercise'];
        $exercise = Exercise::select()->findOr($exerciseData['id'], function() {
             return redirect(route('exercises'))->with('error', 'Exercise was not found!');
        });

        $exercise->update($exerciseData);
        return redirect(route('exercises'))->with('success', 'Exercise successfully updated!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise, Request $request)
    {
        $inProgram = $exercise->programDayExercises()->get();

        if($inProgram->isEmpty()) {
            $exercise->delete();
            return redirect(route('exercises'))->with('success', 'Exercise successfully deleted!');
        }

        return redirect(route('exercises'))->with('error', 'Exercise cannot be deleted!');
}


    public function search(Request $request)
    {
        $query = $request->string('query')->trim();

         if ($query->length() < 2) {
            return response()->json([]);
        }

        $exercises = Exercise::query()
            ->where('name', 'like', '%' . $query . '%')
            ->orderBy('name')
            ->limit(9)
            ->get(['id', 'name']);

        return response()->json($exercises);
    }
}
