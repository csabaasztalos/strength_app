<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\User;
use App\Models\UserProgram;
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
            //
        ];
    }
}
