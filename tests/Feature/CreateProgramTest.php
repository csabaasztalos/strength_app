<?php

use App\Models\Program;
use App\Models\User;
use App\UserRoles;
use Illuminate\Http\UploadedFile;

test('name is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.name');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('name is at least 3 character', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);


    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Ex',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.name');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('description is not required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
            'name' => 'Example Title',
            'category' => 'rehab',
            'weeks' => 5,
            'days_per_week' => 5
    ]]);

    $response->assertSessionHasNoErrors();
});


test('category is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'weeks' => 5,
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.category');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});

test('category must be valid', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'weeks' => 5,
        'category' => 'example',
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.category');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});



test('number of weeks is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.weeks');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('number of weeks is bigger than 0', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 0,
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.weeks');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('number of weeks is smaller than 31', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 31,
        'days_per_week' => 5
    ]]);

    $response->assertSessionHasErrors('program.weeks');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('days per week is required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5
    ]]);

    $response->assertSessionHasErrors('program.days_per_week');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('days per week is bigger than 0', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 0
    ]]);

    $response->assertSessionHasErrors('program.days_per_week');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});


test('days per week is smaller than 8', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 8
    ]]);

    $response->assertSessionHasErrors('program.days_per_week');

    $this->assertDatabaseEmpty('programs');
    $this->assertDatabaseEmpty('program_days');
});

test('image is not required', function() {
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7
    ]]);

    $response->assertSessionHasNoErrors();
});


test('program image upload is working', function() {
    Storage::fake('public');
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7,
        'image_path' => UploadedFile::fake()->image('program.jpg'),
    ]]);

    $program = Program::firstOrFail();

    expect(
        Storage::disk('public')->exists($program->image_path)
    )->toBeTrue();
    $response->assertSessionHasNoErrors();
});

test('only image can be uploaded', function() {
    Storage::fake('public');
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7,
        'image_path' => UploadedFile::fake()->image('program.pdf'),
    ]]);

    $response->assertSessionHasErrors('program.image_path');
});

test('program image must be an image', function() {
    Storage::fake('public');
    $user = User::factory()->create(['role' => UserRoles::COACH]);
    $this->actingAs($user);

    $response = $this->from('/program/create')->post('/program', [  'program' => [
        'name' => 'Example name',
        'description' => 'Example description',
        'category' => 'rehab',
        'weeks' => 5,
        'days_per_week' => 7,
        'image_path' => UploadedFile::fake()->image('program.pdf'),
    ]]);

    $response->assertSessionHasErrors('program.image_path');
});
