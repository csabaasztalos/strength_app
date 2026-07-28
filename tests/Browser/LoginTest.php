<?php

use App\Models\User;
use Nette\Schema\Expect;

it('logs in a user', function() {
    $user = User::factory()->create([
        'name' => 'Example Name',
        'email' => 'name@example.com',
        'password' => 'password123'
    ]);

    visit('/')
        ->click('Sign In')
        ->assertPathIs('/signin')
        ->fill('email', $user->email)
        ->fill('password', 'password123')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('logs out a user', function() {
    $user = User::factory()->create([]);
    $this->actingAs($user);

    visit('/')
        ->click('Sign Out')
        ->assertPathIs('/');

    $this->assertGuest();
});