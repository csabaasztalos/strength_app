<?php

use App\Models\User;
use App\UserRoles;
use App\Illuminate\Http\UploadedFile;


//This will fail due to pest can't upload files yet

it('creates a program', function() {
     $user = User::factory()->create([
        'name' => 'Example Name',
        'email' => 'name@example.com',
        'password' => 'password123',
        'email_verified_at' => now(),
        'role' => UserRoles::COACH
    ]);

    visit('/')
        ->click('Sign In')
        ->assertPathIs('/signin')
        ->fill('email', $user->email)
        ->fill('password', 'password123')
        ->click('@login-button')
        ->assertPathIs('/')

        ->click('New program')
        ->assertPathIs('/program/create')
        ->fill('@programName', 'Example Name')
        ->click('@category-rehab')
        ->fill('@programWeeks', '2')
        ->fill('@programDays', '2')
        ->fill('@programDescription', 'Example Description')
        ->attach('@programImage', realpath(Storage::url('assets/deadlift.jpg')))
        ->click('@save-program')
        
        ->assertPathIs('/program/1/edit');
        
        $this->assertDatabaseHas('programs', [
            'id' => 1,
            'user_id' => $user->id,
            'name' => 'Example Name',
            'description' => 'Example Description',
            'weeks' => 2,
            'days_per_week' => 2
        ]);
});
