<?php

use App\Models\User;

test('email is required', function() {
    $user = User::factory()->create([
        'email' => 'man@example.com',
        'password' => 'password123'
    ]);

    $response = $this->post('/signup', [
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors('email');

    $this->assertGuest();
});


test('password is required', function() {
    $user = User::factory()->create([
        'email' => 'man@example.com',
        'password' => 'password123'
    ]);

    $response = $this->post('/signup', [
        'email' => $user->email
    ]);

    $response->assertSessionHasErrors('password');

    $this->assertGuest();
});


test('email has to be valid', function() {
    $user = User::factory()->create([
        'email' => 'man@example.com',
        'password' => 'password123'
    ]);

    $response = $this->post('/signup', [
        'email' => 'manexample.com',
        'password' => 'password123'
    ]);

    $response->assertSessionHasErrors('email');

    $this->assertGuest();
});


test('password must be at least 8 characters', function() {
    $user = User::factory()->create([
        'email' => 'man@example.com',
        'password' => 'password123'
    ]);

    $response = $this->post('/signup', [
        'email' => $user->email,
        'password' => 'passwor'
    ]);

    $response->assertSessionHasErrors('password');

    $this->assertGuest();
});

