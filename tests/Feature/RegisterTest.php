<?php

use App\Models\User;

test('name is required', function() {
    $response = $this->post('/signup', [
        'email' => 'man@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertSessionHasErrors('name');

    $this->assertDatabaseEmpty('users');
});


test('email is required', function() {
    $response = $this->post('/signup', [
        'name' => 'Example man',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertSessionHasErrors('email');

    $this->assertDatabaseEmpty('users');
});


test('password is required', function() {
    $response = $this->post('/signup', [
        'name' => 'Example man',
        'email' => 'man@example.com',
    ]);

    $response->assertSessionHasErrors('password');

    $this->assertDatabaseEmpty('users');
});


test('password confirmation must match', function() {
    $response = $this->post('/signup', [
        'name' => 'Example man',
        'email' => 'man@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different_password'
    ]);

    $response->assertSessionHasErrors('password');

    $this->assertDatabaseEmpty('users');
});


test('name has to be at least 3 characters', function() {
    $response = $this->post('/signup', [
        'name' => 'Ex',
        'email' => 'man@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertSessionHasErrors('name');

    $this->assertDatabaseEmpty('users');
});


test('email has to be valid', function() {
    $response = $this->post('/signup', [
        'name' => 'Example man',
        'email' => 'manexample.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertSessionHasErrors('email');

    $this->assertDatabaseEmpty('users');
});


test('email must be unique', function() {
    User::factory()->create([
        'email' => 'man@example.com'
    ]);

    $response = $this->post('/signup', [
        'name' => 'Example man',
        'email' => 'man@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ]);

    $response->assertSessionHasErrors('email');

    $this->assertDatabaseCount('users', 1);
});


test('password must be at least 8 characters', function() {
    $response = $this->post('/signup', [
        'name' => 'Example man',
        'email' => 'man@example.com',
        'password' => 'passwor',
        'password_confirmation' => 'passwor'
    ]);

    $response->assertSessionHasErrors('password');

    $this->assertDatabaseEmpty('users');
});

