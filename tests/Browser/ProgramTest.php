creates a program will fail due to pest can't upload files yet
<?php

use App\Models\Program;
use App\Models\User;
use App\ProgramStatus;
use App\UserRoles;
use Illuminate\Http\UploadedFile;

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


it('changes program status to hidden', function() {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $program = Program::factory()->create([
        'status' => ProgramStatus::ACTIVE
    ]);

    visit(route('program.show', $program))
        ->click('@hideProgram')
        ->assertPathIs('/programs')
        ->assertSee('Program is now hidden!');

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'status' => ProgramStatus::HIDDEN
        ]);
});


it('changes program status to draft', function() {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $program = Program::factory()->create([
        'status' => ProgramStatus::HIDDEN
    ]);

    visit(route('program.show', $program))
        ->click('@draftProgram')
        ->assertPathIs('/programs')
        ->assertSee('Program has been successfully drafted.');

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'status' => ProgramStatus::DRAFT
        ]);
});


it('publishes a program', function() {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $imagePath = Storage::disk('public')
        ->putFile('programs', UploadedFile::fake()->image('program.jpg'));

    expect(Storage::disk('public')->exists($imagePath))->toBeTrue();

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT,
        'image_path' => $imagePath
    ]);

    visit(route('program.show', $program))
        ->click('@publishProgram')
        ->assertPathIs('/programs')
        ->assertSee('Program has been successfully published.');

    $this->assertDatabaseHas('programs', [
        'id' => $program->id,
        'status' => ProgramStatus::ACTIVE
    ]);

    Storage::disk('public')->delete($imagePath);
});

it('deletes a program', function() {
    $user = User::factory()->create([
        'role' => UserRoles::COACH
    ]);

    $this->actingAs($user);

    $imagePath = Storage::disk('public')
        ->putFile('programs', UploadedFile::fake()->image('program.jpg'));

    expect(Storage::disk('public')->exists($imagePath))->toBeTrue();

    $program = Program::factory()->create([
        'status' => ProgramStatus::DRAFT,
        'image_path' => $imagePath
    ]);

    visit(route('program.show', $program))
        ->click('@deleteProgram')
        ->assertPathIs('/programs')
        ->assertSee('Program has been successfully deleted.');

    expect(Storage::disk('public')->exists($imagePath))->toBeFalse();

    $this->assertDatabaseEmpty('programs');
});
