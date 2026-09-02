<?php

use App\Models\Program;
use App\Models\User;
use App\ProgramStatus;
use App\UserRoles;
use Illuminate\Http\UploadedFile;

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
