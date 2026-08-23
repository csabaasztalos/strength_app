<?php

use App\Models\User;
use App\UserRoles;

test('name is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);

    $this->actingAs($user);

    $response = $this->from('/exercises')->post('/exercise/store', [  'exercise' => [
        'description' => 'Example description',
        'category' => 'powerlifting'
    ]]);

    $response->assertSessionHasErrors('exercise.name');

    $this->assertDatabaseEmpty('exercises');
});


test('name is at least 3 character', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);


    $response = $this->from('/exercises')->post('/exercise/store', [  'exercise' => [
        'name' => 'Ex',
        'description' => 'Example description',
        'category' => 'powerlifting'
    ]]);

    $response->assertSessionHasErrors('exercise.name');

    $this->assertDatabaseEmpty('exercises');
});


test('description is not required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);


    $response = $this->from('/exercises')->post('/exercise/store', [  'exercise' => [
        'name' => 'Example name',
        'category' => 'powerlifting'
    ]]);

    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('exercises', [
        'name' => 'Example name',
        'category' => 'powerlifting'
    ]);
});


test('category is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);


    $response = $this->from('/exercises')->post('/exercise/store', [  'exercise' => [
        'name' => 'Example name',
        'description' => 'Example description'
    ]]);

   $response->assertSessionHasErrors('exercise.category');

    $this->assertDatabaseEmpty('exercises');
});


test('category must be valid', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);


    $response = $this->from('/exercises')->post('/exercise/store', [  'exercise' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'example',
    ]]);

   $response->assertSessionHasErrors('exercise.category');

    $this->assertDatabaseEmpty('exercises');
});
