<?php

use App\Models\User;

it('creates a program', function() {
    $user = User::factory()->create();
    $this->actingAs($user);

    visit('/program/create')
        ->fill('@programName', 'Example Name')
        ->fill('@programDescription', 'Example Description')
        ->click('@category-rehab')
        ->fill('@programWeeks', '5')
        ->fill('@programDays', '5')
        ->click('@save-program')
        ->assertPathIs('/program/1/edit');
        
        $this->assertDatabaseHas('programs', [
            'id' => 1,
            'user_id' => $user->id,
            'name' => 'Example Name',
            'description' => 'Example Description',
            'weeks' => 5,
            'days_per_week' => 5
        ]);

        $this->assertDatabaseHas('program_days', [
            'id' => 1,
            'program_id' => 1,
            'week_number' => 1,
            'day_number' => 1,
            'name' => null
        ]);

        $this->assertDatabaseHas('program_days', [
            'id' => 14,
            'program_id' => 1,
            'week_number' => 3,
            'day_number' => 4,
            'name' => null
        ]);
});
