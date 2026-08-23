<?php

use App\Models\Program;
use App\Models\User;
use App\ProgramStatus;
use App\UserRoles;

test('can edit a draft program\'s details', function () {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $program = Program::factory()->create([]);

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
        'status' => ProgramStatus::ACTIVE,
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

//TODO:: drat, publish, delete, hide