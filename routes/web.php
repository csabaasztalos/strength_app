<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramBuilderController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Models\Program;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/signup', [RegisteredUserController::class, 'create']);
Route::post('/signup', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/signin', [SessionsController::class, 'create'])->name('login');
Route::post('/signin', [SessionsController::class, 'store']);

Route::delete('/signout', [SessionsController::class, 'destroy'])->middleware('auth');


Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index')->middleware('auth');
Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create')->middleware('auth');
Route::post('/program', [ProgramController::class, 'store'])->name('program.store')->middleware('auth');
Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program.show')->middleware('auth');
Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit')->middleware('auth');
Route::patch('/program/{program}/update', [ProgramController::class, 'update'])->name('program.update')->middleware('auth');

Route::get('/exercises', [ExerciseController::class, 'index'])->middleware('auth');