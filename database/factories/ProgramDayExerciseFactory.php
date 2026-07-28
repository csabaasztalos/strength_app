<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\ProgramDay;
use App\Models\ProgramDayExercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProgramDayExercise>
 */
class ProgramDayExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'program_day_id'=>ProgramDay::factory(),
            'exercise_id'=>Exercise::factory(),
            'sets'=>fake()->numberBetween(0,10),
            'reps'=>fake()->numberBetween(0,30),
            'percentage'=>fake()->numberBetween(40,101),
            'rpe'=>fake()->numberBetween(4,11),
            'position'=>fake()->numberBetween(1,10)
        ];
    }
}
