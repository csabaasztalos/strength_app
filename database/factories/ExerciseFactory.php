<?php

namespace Database\Factories;

use App\ExerciseCategory;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' =>fake()->sentence(),
            'description' => fake()->paragraph(),
            'category' => ExerciseCategory::OLYMPIC
        ];
    }
}
