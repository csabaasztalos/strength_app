<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\ProgramDay;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramDay>
 */
class ProgramDayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_id'=>Program::factory(),
            'week_number'=>fake()->numberBetween(0,16),
            'day_number'=>fake()->numberBetween(0,7),
            'name' =>fake()->sentence()
        ];
    }
}
