<?php

use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use App\ProgramStatus;
use App\UserProgramDayStatus;
use App\UserProgramStatus;
use App\UserRoles;

it('starts a program', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $program = Program::factory()->create([
        'user_id' => $user->id
    ]);


    visit(route('program.show', $program))
        ->assertPathIs('/program/1')
        ->click('@startProgram')
        ->assertSee('Successfully started');
    
    $this->assertDatabaseHas('user_programs', [
        'program_id' => $program->id,
        'status' => UserProgramStatus::STARTED
    ]);

    $this->assertDatabaseHas('user_program_days', ['id' => 1]);
});


it('cancels a user program', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $userProgram = UserProgram::factory()->create([
        'user_id' => $user->id
    ]);


    visit(route('user.programs', $user))
        ->assertPathIs('/my-programs/1')
        ->click('Cancel program')
        ->click('Proceed')
        ->assertPathIs('/my-programs/1')
        ->assertSee('Program successfully cancelled!');
    
    $this->assertDatabaseHas('user_programs', [
        'id' => $userProgram->id,
        'status' => UserProgramStatus::CANCELLED
    ]);

    $this->assertDatabaseHas('user_program_days', ['id' => 1]);
});

it('can complete days', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $userProgram = UserProgram::factory()->create([
        'user_id' => $user->id
    ]);

     visit(route('user.programs', $user))
        ->assertPathIs('/my-programs/1')
        ->click('My progression')
        ->click('@completeWorkout')
        ->assertSee('Day marked as Completed!');
    
    $this->assertDatabaseHas('user_programs', [
        'id' => $userProgram->id,
        'status' => UserProgramStatus::STARTED
    ]);

    $this->assertDatabaseHas('user_program_days', [
        'id' => 1,
        'status' => UserProgramDayStatus::COMPLETED
    ]);
});


it('can skip days', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $userProgram = UserProgram::factory()->create([
        'user_id' => $user->id
    ]);

     visit(route('user.programs', $user))
        ->assertPathIs('/my-programs/1')
        ->click('My progression')
        ->click('@skipWorkout')
        ->assertSee('Day marked as Skipped!');
    
    $this->assertDatabaseHas('user_programs', [
        'id' => $userProgram->id,
        'status' => UserProgramStatus::STARTED
    ]);

    $this->assertDatabaseHas('user_program_days', [
        'id' => 1,
        'status' => UserProgramDayStatus::SKIPPED
    ]);
});


it('can finish a user program', function () {
     $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $program = Program::factory()->create([
        'weeks' => 2,
        'days_per_week' => 2
    ]);

    $userProgram = UserProgram::factory()->create([
        'user_id' => $user->id,
        'program_id' => $program->id
    ]);

     visit(route('user.programs', $user))
        ->assertPathIs('/my-programs/1')
        ->click('My progression')
        ->click('@completeWorkout')
        ->assertSee('Day marked as completed!')
        ->click('@nextDay')
        ->click('@completeWorkout')
        ->assertSee('Day marked as completed!')
        ->click('@nextDay')
        ->click('@completeWorkout')
        ->assertSee('Day marked as completed!')
        ->click('@nextDay')
        ->click('@skipWorkout')
        ->assertSee('Program successfully finished!')
        ->assertPathIs('/my-programs/1');
        
    
    $this->assertDatabaseHas('user_programs', [
        'id' => $userProgram->id,
        'status' => UserProgramStatus::FINISHED
    ]);

    $this->assertDatabaseHas('user_program_days', [
        'id' => 1,
        'status' => UserProgramDayStatus::COMPLETED
    ]);
});


it('can\'t run 2 of the same program at once', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $program = Program::factory()->create([
        'user_id' => $user->id
    ]);


    visit(route('program.show', $program))
        ->assertPathIs('/program/1')
        ->click('@startProgram')
        ->assertSee('Successfully started')
        ->click('@showProgram')
        ->click('@startProgram')
        ->assertSee('You can\'t run the same program twice at the same time!');
    
    $this->assertDatabaseCount('user_programs', 1);

    $this->assertDatabaseHas('user_program_days', ['id' => 1]);
});


it('can run 2 (different) programs at once', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    $userProgram = UserProgram::factory()->create([
        'user_id' => $user->id
    ]);

    $program = Program::factory()->create([
        'user_id' => $user->id
    ]);

    visit(route('program.show', $program))
        ->assertPathIs('/program/2')
        ->click('@startProgram')
        ->assertSee('Successfully started');
    
    $this->assertDatabaseCount('user_programs', 2);

    $this->assertDatabaseHas('user_program_days', ['id' => 1]);
});


it('can\'t run more than 2 (different) programs at once', function () {
    $user = User::factory()->create(([
        'role' => UserRoles::COACH
    ]));

    $this->actingAs($user);

    UserProgram::factory()->create([
        'user_id' => $user->id
    ]);

    UserProgram::factory()->create([
        'user_id' => $user->id
    ]);

    $program = Program::factory()->create([
        'user_id' => $user->id
    ]);

    visit(route('program.show', $program))
        ->assertPathIs('/program/3')
        ->click('@startProgram')
        ->assertSee('You only can run 2 programs at the same time!');
    
    $this->assertDatabaseCount('user_programs', 2);

    $this->assertDatabaseHas('user_program_days', ['id' => 1]);
});