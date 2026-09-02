<?php

use App\Models\User;

it ('prevents unverified users from accessing the application', function() {
    $user = User::factory()->create([
        'email_verified_at' => null
    ]);
    
    $this->actingAs($user);

    visit('/')
        ->click('Programs')
        ->assertPathIs('/email/verify')
        ->click('My programs')
        ->assertPathIs('/email/verify')
        ->click('Profile')
        ->assertPathIs('/email/verify');

});


it ('prevents athletes to use coach features', function() {
    $user = User::factory()->create([]);
    
    $this->actingAs($user);

    visit('/')
        ->assertDontSee('Exercises')
        ->assertDontSee('New program');
});