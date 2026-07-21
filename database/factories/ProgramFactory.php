<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
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
        ];
    }
}
