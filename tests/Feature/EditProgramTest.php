<?php

use App\Models\Program;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('can edit program details', function() {
    $user = User::factory()->create();
    $program = Program::factory()->create();


    $response = $this->actingAs($user)->patch(route('program.update', $program), [ 'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7
    ]]);
    
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('programs', [
        'id' => $program->id,
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7
    ]);
});

