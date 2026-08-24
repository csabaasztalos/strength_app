<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
use App\UserProgramStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @extends Factory<UserProgram>
 */
class UserProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'program_id' => Program::factory()->create(),
            'status' => UserProgramStatus::STARTED,
        ];
    }

    public function configure() {
        return $this->afterCreating(function (UserProgram $program) {
            for ($week = 1; $week <= $program->program->weeks; $week++) {
                for ($day = 1; $day <= $program->program->days_per_week; $day++) {
                    $programDayId = $program->program->ProgramDays()
                    ->where(['week_number' => $week, 'day_number' => $day])
                    ->value('id');

                    $program->userProgramDays()->create([
                        'user_program_id' => $program->id,
                        'program_day_id' => $programDayId
                    ]);
                }
            }
        });
    }
}
