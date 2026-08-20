<?php

use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\auth\RegisteredUserController;
use App\Http\Controllers\auth\SessionsController;
use App\Http\Controllers\UserProgramController;
use App\Http\Controllers\UserProgramDayController;
use App\Http\Controllers\auth\UserVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::middleware(['auth', 'role:coach'])->group(function () {
    Route::get('/program/create', [ProgramController::class, 'create'])->name('program.create');
    Route::post('/program', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
    Route::patch('/program/{program}/update', [ProgramController::class, 'update'])->name('program.update');
    Route::patch('/program/{program}/publish', [ProgramController::class, 'publish'])->name('program.publish');
    Route::patch('/program/{program}/draft', [ProgramController::class, 'draft'])->name('program.draft');
    Route::patch('/program/{program}/hide', [ProgramController::class, 'hide'])->name('program.hide');
    Route::delete('/program/{program}/delete', [ProgramController::class, 'destroy'])->name('program.delete');

    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises');
    Route::get('/exercises/search', [ExerciseController::class, 'search'])->name('exercises.search');
    Route::get('/exercise/create', [ExerciseController::class, 'create'])->name('exercise.create');
    Route::patch('/exercise/{exercise}/edit', [ExerciseController::class, 'edit'])->name('exercise.edit');
    Route::post('/exercise/store', [ExerciseController::class, 'store'])->name('exercise.store');
    Route::patch('/exercise/update', [ExerciseController::class, 'update'])->name('exercise.update');
    Route::delete('/exercise/{exercise}/delete', [ExerciseController::class, 'destroy'])->name('exercise.delete');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/programs', [ProgramController::class, 'index'])->name('programs');
    Route::get('/program/{program}', [ProgramController::class, 'show'])->name('program.show');
    
    Route::get('/my-programs/{user}', [UserProgramController::class, 'index'])->name('user.programs');
    Route::get('/my-programs/{userProgram}/{week}/{day}', [UserProgramController::class, 'show'])->name('progression');
    Route::post('/program/{program}/start', [UserProgramController::class, 'store'])->name('user_program.start');
    Route::patch('/my-programs/cancel', [UserProgramController::class, 'cancel'])->name('user_program.cancel');
    
    Route::patch('/my-programs/{userProgram}/{week}/{day}/update', [UserProgramDayController::class, 'update'])->name('user_program.update');
    Route::patch('/my-programs/{userProgramDay}/{status}', [UserProgramDayController::class, 'changeStatus'])->name('user_program_day.changeStatus');
});

Route::middleware('guest')->group(function () {
    Route::get('/signup', [RegisteredUserController::class, 'create']);
    Route::post('/signup', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('/signin', [SessionsController::class, 'create'])->name('login');
    Route::post('/signin', [SessionsController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'show'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

});

Route::middleware('auth')->group(function () {
    Route::delete('/signout', [SessionsController::class, 'destroy']);

    Route::get('/email/verify', [UserVerificationController::class, 'show'])->name('verification.notice');
    Route::post('/email/verification-notification',[UserVerificationController::class, 'resend'])
        ->middleware(['auth', 'throttle:3,1'])
        ->name('verification.send');
});

Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', [UserVerificationController::class, 'verify'])->name('verification.verify');
});
