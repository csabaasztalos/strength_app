<?php

use App\Models\Exercise;
use App\Models\User;
use App\UserRoles;

it('creates an exercise', function () {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    visit('/exercises')
        ->assertPathIs('/exercises')
        ->click('@newExercise')
        ->fill('@exerciseName', 'Example exercise')
        ->fill('@exerciseDescription', 'Example description')
        ->click('@category-new-powerlifting')
        ->click('@createExercise')
        
        ->assertPathIs('/exercises');

    $this->assertDatabaseHas('exercises', [
        'name' => 'Example exercise',
        'description' => 'Example description',
        'category' => 'powerlifting',
    ]);
});


it('edits an exercise', function () {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $exercise = Exercise::factory()->create([]);

    visit('/exercises')
        ->assertPathIs('/exercises')
        ->click('Edit')
        ->fill('@editName', 'Not example exercise')
        ->fill('@editDescription', 'Not example description')
        ->click('@category-edit-rehab')
        ->click('@saveExercise')
        ->assertPathIs('/exercises');


    $this->assertDatabaseHas('exercises', [
        'name' => 'Not example exercise',
        'description' => 'Not example description',
        'category' => 'rehab',
    ]);
});


it('deletes an exercise', function () {
     $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $exercise = Exercise::factory()->create([]);

    visit('/exercises')
        ->assertPathIs('/exercises')
        ->click('Delete');


    $this->assertDatabaseEmpty('exercises');
});