<?php

use Nette\Schema\Expect;

it('registers a user', function() {
    visit('/')
        ->click('Sign Up')
        ->assertPathIs('/signup')
        ->fill('name', 'Example Name')
        ->fill('email', 'name@example.com')
        ->fill('password', 'password123')
        ->fill('password_confirmation', 'password123')
        ->click('@register-button')
        ->assertPathIs('/email/verify');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'Example Name',
        'email' => 'name@example.com',
        'role' => App\UserRoles::ATHLETE->value
    ]);

    expect(Auth::user()->hasVerifiedEmail())->toBeFalse();
});
