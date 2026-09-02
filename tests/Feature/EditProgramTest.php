<?php

use App\Models\Exercise;
use App\Models\Program;
use App\Models\ProgramDayExercise;
use App\Models\User;
use App\ProgramStatus;
use App\UserRoles;

test('can edit a draft program\'s details', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
    ]);

    $programDays = [];

    for ($i = 1; $i <= 25; $i++) {
        $programDays[$i]['name'] = null;
    }

    $response = $this->actingAs($user)->patch(
        route('program.update', $program),
        [
            'program' => [
                'name' => 'Example name',
                'description' => 'Example description',
                'category' => 'rehab',
                'weeks' => 5,
                'days_per_week' => 5,
                'current_image' => null
            ],
            'days' => $programDays,
        ]
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('programs', [
        'id' => $program->id,
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5,
    ]);
});


test('active program is not editable', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'name' => 'Not example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5
    ]);

    $programDays = [];

    for ($i = 1; $i <= 25; $i++) {
        $programDays[$i]['name'] = null;
    }

    $response = $this->actingAs($user)->patch(
        route('program.update', $program),
        [
            'program' => [
                'name' => 'Example name',
                'description' => 'Example description',
                'category' => 'rehab',
                'weeks' => 5,
                'days_per_week' => 5,
                'current_image' => null
            ],
            'days' => $programDays,
        ]
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('programs', [
        'id' => $program->id,
        'name' => 'Not example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5,
    ]);
});


test('hidden program is not editable', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::HIDDEN,
        'name' => 'Not example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5
    ]);

    $programDays = [];

    for ($i = 1; $i <= 25; $i++) {
        $programDays[$i]['name'] = null;
    }

    $response = $this->actingAs($user)->patch(
        route('program.update', $program),
        [
            'program' => [
                'name' => 'Example name',
                'description' => 'Example description',
                'category' => 'rehab',
                'weeks' => 5,
                'days_per_week' => 5,
                'current_image' => null
            ],
            'days' => $programDays,
        ]
    );

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('programs', [
        'id' => $program->id,
        'name' => 'Not example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5,
    ]);
});


test('can add exercises', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT,
        'name' => 'Not example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 2,
        'days_per_week' => 2
    ]);

    $programDays = [];

    for ($i = 1; $i <= 4; $i++) {
        $programDays[$i]['name'] = null;
    }

    $exercise = Exercise::factory()->create();

    $this->assertDatabaseEmpty('program_day_exercises');
    
    $response = $this->actingAs($user)->patch(
        route('program.update', $program),
        [
            'program' => [
                'status' => ProgramStatus::DRAFT,
                'name' => 'Not example name',
                'description' => 'Example description',
                'category' => 'rehab',
                'weeks' => 2,
                'days_per_week' => 2,
                'current_image' => null
            ],
            
            'weeks' => [
                1 => [
                    'days' => [
                        1 => [
                            'new_exercises' => [
                                [
                                    'exercise_id' => $exercise->id,
                                    'sets' => '1',
                                    'reps' => '1',
                                    'percentage' => '1',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1',
                                ],
                                [
                                    'exercise_id' => $exercise->id,
                                    'sets' => '2',
                                    'reps' => '2',
                                    'percentage' => '2',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '2',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseCount('program_day_exercises', 2);
});


test('can delete exercises', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
    ]);

    $programDays = [];

    for ($i = 1; $i <= 4; $i++) {
        $programDays[$i]['name'] = null;
    }

    $exercise = Exercise::factory()->create();

    ProgramDayExercise::create([
        'exercise_id' => $exercise->id,
        'program_day_id' =>1,
        'sets' => '1',
        'reps' => '1',
        'percentage' => '1',
        'rpe' => null,
        'duration_minutes' => null,
        'position' => '1',
    ]);

    $this->assertDatabaseCount('program_day_exercises', 1);

    $response = $this->actingAs($user)->patch(
        route('program.update', $program),
        [
            'program' => [
                'status' => ProgramStatus::DRAFT,
                'name' => 'Not example name',
                'description' => 'Example description',
                'category' => 'rehab',
                'weeks' => 2,
                'days_per_week' => 2,
                'current_image' => null
            ],

            'days' => $programDays,

            'deleted_program_exercises' => [
                0 => '1'
            ]
        ]
    );
    
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseEmpty('program_day_exercises');
});
