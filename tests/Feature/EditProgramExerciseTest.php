<?php
use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;
use App\ProgramStatus;
use App\UserRoles;

test('these program exercise fields are nullable: percentage, rpe, duration', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => null,
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasNoErrors();
});


test('program exercise set input data has to be bigger than 0', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'sets' => '0',
                                    'reps' => '1',
                                    'percentage' => '1',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise set input data has to be smaller than 31', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'sets' => '31',
                                    'reps' => '1',
                                    'percentage' => '1',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise reps input data has to be bigger than 0', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'reps' => '0',
                                    'percentage' => '1',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise reps input data has to be smaller than 51', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'reps' => '51',
                                    'percentage' => '1',
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise percentage input data has to be bigger than 0', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => 0,
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise percentage input data has to be smaller than 201', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => 201,
                                    'rpe' => null,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise rpe input data has to be bigger than 0', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => null,
                                    'rpe' => 0,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise rpe input data has to be smaller than 11', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => null,
                                    'rpe' => 11,
                                    'duration_minutes' => null,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise duration input data has to be smaller than 201', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => null,
                                    'rpe' => 11,
                                    'duration_minutes' => 201,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});


test('program exercise duration input data has to be bigger than 0', function () {
   $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT
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
                                    'percentage' => null,
                                    'rpe' => 11,
                                    'duration_minutes' => 0,
                                    'position' => '1'
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'days' => $programDays,
            'deleted_program_exercises' => [null]
        ]
    );
    
    $response->assertSessionHasErrors();
});

