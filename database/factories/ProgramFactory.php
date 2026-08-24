<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use App\ProgramCategory;
use App\ProgramStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
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
            'name' =>fake()->sentence(),
            'description' => fake()->paragraph(),
            'weeks' => fake()->numberBetween(6,16),
            'days_per_week' => fake()->numberBetween(6,7),
            'category' => ProgramCategory::STRENGTH,
            'status' => ProgramStatus::ACTIVE
        ];
    }

    public function configure() {
        return $this->afterCreating(function (Program $program) {
            for ($week = 1; $week <= $program->weeks; $week++) {
                for ($day = 1; $day <= $program->days_per_week; $day++) {
                    $program->programDays()->create([
                        'week_number' => $week,
                        'day_number' => $day
                    ]);
                }
            }
        });
    }
}
