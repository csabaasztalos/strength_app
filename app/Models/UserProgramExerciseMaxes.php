<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['exercise_id', 'max'])]

class UserProgramExerciseMaxes extends Model
{
    /** @use HasFactory<\Database\Factories\UserProgramExerciseMaxesFactory> */
    use HasFactory;

    public function userProgramExerciseMaxes(): BelongsTo {
        return $this->BelongsTo(UserProgram::class);
    }
}
